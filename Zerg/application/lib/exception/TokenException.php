<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/15
 * Time: 19:27
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;

    public $msg = 'Token已过期或无效Token';

    public $errorCode =  10001;

}