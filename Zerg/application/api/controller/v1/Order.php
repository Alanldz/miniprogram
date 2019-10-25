<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 10:50
 */

namespace app\api\Controller\v1;


use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    //前置操作
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
    ];

    //用户在选择商品后，向API提交包含它所选择商品的相关信息
    //API在接收到信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库中= 下单成功了，返回客户端消息，告诉客户端可以支付了
    //调用我们的支付接口，进行支付
    //服务器这边就可以调用微信的支付接口进行支付
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

}