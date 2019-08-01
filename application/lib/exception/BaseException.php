<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/25
 * Time: 10:16
 */

namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    //HTTP 状态码 404,200
    public $code = 400;

    public $msg = '参数错误';

    public $errorCode =  10001;

    public function __construct($params = [])
    {
        if(!is_array($params)){
            return '';
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}