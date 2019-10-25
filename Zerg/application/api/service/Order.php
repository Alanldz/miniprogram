<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 15:00
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use think\Exception;

class Order
{
    //订单的商品列表，也就是客户端传递过来的products参数
    protected $oProducts;

    //真实的商品信息（包括库存量）
    protected $products;

    //用户ID
    protected $uid;

    public function place($uid, $oProducts)
    {
        //$oProducts和$products 做对比
        //$products是从数据库中查询出来的
        $this->uid = $uid;
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);

        $status = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        //获取快照
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    //查询数据库中的商品
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        $products = Product::all($oPIDs)->visible(['id', 'name', 'price', 'stock', 'main_img_url'])->toArray();
        return $products;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPIDs, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];

        $productsCount = count($products);
        for ($i = 0; $i < $productsCount; $i++) {
            if ($oPIDs == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => 'id为' . $oPIDs . '的商品不存在，创建订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if ($product['stock'] >= $oCount) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap['totalPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = $this->getUserAddress();
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => '60001'
            ]);
        }
        return $userAddress->toArray();
    }

    /**
     * 创建订单
     * @param array $snap 快照
     * @return array
     * @throws Exception
     * @author ldz
     * @time 2019/10/24 16:59
     */
    private function createOrder($snap)
    {
        try {
            $order = new OrderModel();
            $order->order_no = $this->makeOrderNo();
            $order->user_id = $this->uid;
            $order->total_price = $snap['totalPrice'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->total_count = $snap['totalCount'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->snap_address = json_encode($snap['snapAddress']);

            $order->save();

            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $order->id;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            return [
                'order_no' => $order->order_no,
                'order_id' => $order->id,
                'create_time' => $order->create_time,
            ];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    //生成订单编号
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K','L','M','N','O','P','Q','R','S','T');
        $orderSn =
            $yCode[intval(date('Y')) - 2019] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
}