<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/25
 * Time: 15:26
 */

namespace app\api\Controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostLiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    public $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    /**
     * 获取微信准备的订单号，返回前端唤起微信支付
     * @param string $id
     * @return \think\response\Json
     * @throws \think\Exception
     * @author ldz
     * @time 2019/10/31 15:10
     */
    public function getPreOrder($id = '')
    {
        (new IDMustBePostLiveInt())->goCheck();
        $pay = new PayService($id);
        $result = $pay->pay();
        return json($result);
    }

    public function receiveNotify()
    {
        //通知频率为 15/15/30/180/1800/1800/1800/1800/1800/3600 ,单位：秒

        //1.检测库存量，超卖（超卖的概率较小，但可能存在）
        //2.更新这个订单的status状态
        //3.减库存
        //如果成功处理，我们返回微信成功处理的信息，否则，我们需要返回没有成功处理

        //特点：post：xml格式：不会携带参数
        $config = []; //微信配置
        $notify = new WxNotify();
        $notify->Handle($config);


    }

}