<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/25
 * Time: 15:26
 */

namespace app\api\Controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostLiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    public $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePostLiveInt())->goCheck();
        $pay = new PayService($id);
        $pay->pay();
    }

}