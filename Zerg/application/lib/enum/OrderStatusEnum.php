<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/25
 * Time: 16:28
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //未支付
    const UNPAID = 1;

    //已支付
    const PAID = 2;

    //已发货
    const DELIVERED = 3;

    //已支付，单库存不足
    const PAID_BUT_OUT_OF = 4;
}