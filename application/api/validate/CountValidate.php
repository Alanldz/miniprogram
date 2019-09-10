<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/9/10
 * Time: 20:15
 */

namespace app\api\validate;


class CountValidate extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15',
    ];
}