<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/12
 * Time: 19:02
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    public $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有code还想获取Token,做梦哦'
    ];
}