<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/8/13
 * Time: 21:25
 */

namespace app\api\model;

class Product extends BaseModel
{
    //隐藏字段
    protected $hidden = ['update_time', 'create_time', 'delete_time', 'category_id', 'from', 'pivot'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count){
        return self::limit($count)->order('create_time desc')->select();
    }


}