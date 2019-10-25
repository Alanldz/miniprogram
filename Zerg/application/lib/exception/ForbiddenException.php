<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 10:27
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = '403';

    public $msg = '权限不够';

    public $errorCode = 10001;
}