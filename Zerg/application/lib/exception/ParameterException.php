<?php
/**
 * 参数异常处理
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/25
 * Time: 13:50
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{

    public $code = 400;

    public $msg = '参数错误';

    public $errorCode =  10000;
}