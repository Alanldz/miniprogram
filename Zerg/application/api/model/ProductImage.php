<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/17
 * Time: 20:06
 */

namespace app\api\model;


class ProductImage extends BaseModel
{

    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

}