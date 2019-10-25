<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 15:24
 */

namespace app\lib\exception;


class OrderException extends BaseException
{

    public $code = 404;

    public $msg = '订单不存在，请检查ID';

    public $errorCode = 80000;

}