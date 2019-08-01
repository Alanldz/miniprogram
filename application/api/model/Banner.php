<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/24
 * Time: 17:41
 */
namespace app\api\model;

use think\Db;

class Banner
{
    public static function getBannerByID($id){
//        $list = Db::query('select * from banner_item where banner_id=?',[$id]);
        $list = Db::table('banner_item')->where('banner_id',$id)->select();
        return $list;
    }

}