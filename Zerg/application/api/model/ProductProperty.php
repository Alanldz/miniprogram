<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/17
 * Time: 20:08
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{

    protected $hidden = ['product_id', 'delete_time', 'id'];

}