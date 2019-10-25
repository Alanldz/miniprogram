<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/23
 * Time: 20:16
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;

    public $msg = '用户不存在';

    public $errorCode = 60000;
}