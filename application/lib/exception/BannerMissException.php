<?php
/**
 * 验证Banner 异常处理
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/25
 * Time: 10:35
 */

namespace app\lib\exception;

class BannerMissException extends  BaseException
{
    public $code = 404;

    public $msg = '请求的Banner不存在';

    public $errorCode =  40000;
}