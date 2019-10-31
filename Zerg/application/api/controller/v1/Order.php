<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 10:50
 */

namespace app\api\Controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostLiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    //前置操作
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' =>['only'=>'getSummaryByUser,getDetail']
    ];

    //用户在选择商品后，向API提交包含它所选择商品的相关信息
    //API在接收到信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库中= 下单成功了，返回客户端消息，告诉客户端可以支付了
    //调用我们的支付接口，进行支付
    //还需要再次进行库存量检测
    //服务器这边就可以调用微信的支付接口进行支付
    //小程序根据服务器返回的结果拉起微信支付
    //微信会返回给我们一个支付的结果（异步）
    //成功：也需要进行库存量的检查
    //成功：进行库存量的扣除
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $orderService = new OrderService();
        $status = $orderService->place($uid, $products);
        return json($status);
    }

    /**
     * 用户订单列表
     * @param int $page
     * @param int $size
     * @return \think\response\Json
     * @throws \think\Exception
     * @author ldz
     * @time 2019/10/31 17:51
     */
    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return json([
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage(),
            ]);
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return json([
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage(),
        ]);
    }


    public function getDetail($id)
    {
        (new IDMustBePostLiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }

        return json($orderDetail->hidden(['prepay_id']));
    }

}