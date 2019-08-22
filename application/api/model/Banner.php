<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/24
 * Time: 17:41
 */
namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];

    public function item(){
        return $this->hasMany('banner_item','banner_id','id');
    }

    public static function getBannerByID($id){
        return static::with(['item','item.img'])->find($id);
    }

}