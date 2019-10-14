<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/23
 * Time: 19:58
 */

namespace app\api\validate;

class IDMustBePostLiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];

    protected $message = [
        'id' => 'id必须是正整数'
    ];


}