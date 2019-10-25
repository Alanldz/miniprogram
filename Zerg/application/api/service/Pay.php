<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/25
 * Time: 16:04
 */

namespace app\api\service;


use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;

    private $orderNO;

    public function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url('');
        return $this->getPaySingnature($wxOrderData);
    }

    private function getPaySingnature($wxOrderData)
    {
        $config = [];
        $wxOrder = \WxPayApi::unifiedOrder($config, $wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
        return null;
    }

    private function sign($wxOrder)
    {

    }

    /**
     * 判断订单是否存在
     * 判断该订单号和当前操作用户是否匹配
     * 判断订单是否支付过了
     * @author ldz
     * @time 2019/10/25 16:34
     */
    private function checkOrderValid()
    {
        $order = OrderModel::where('id', '=', $this->orderID)->find();
        if (!$order) {
            throw new OrderException();
        }
        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单于用户不匹配',
                'errorCode' => 10003
            ]);
        }

        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已支付过啦',
                'errorCode' => '80003',
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }

}