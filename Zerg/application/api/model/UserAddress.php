<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 9:38
 */

namespace app\api\model;


class UserAddress extends BaseModel
{

    public $hidden = ['user_id','delete_time','update_time'];

}