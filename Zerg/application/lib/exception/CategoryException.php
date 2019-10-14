<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/12
 * Time: 17:32
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;

    public $msg = '指定类目不存在，请检查参数';

    public $errorCode = 50000;

}