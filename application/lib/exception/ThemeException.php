<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/8/21
 * Time: 19:31
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;

    public $msg = '指定的主题不存在，请检查主题ID';

    public $errorCode =  30000;

}