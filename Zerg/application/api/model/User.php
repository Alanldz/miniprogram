<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/14
 * Time: 9:24
 */

namespace app\api\model;


class User extends BaseModel
{

    /**
     * 通过openid后获取用户信息
     */
    public static function getByOpenid($openid){
        return self::where(['openid'=>$openid,'delete_time'=>''])->find();
    }

}