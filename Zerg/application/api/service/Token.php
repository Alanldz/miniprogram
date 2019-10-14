<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/14
 * Time: 20:31
 */

namespace app\api\service;


class Token
{
    public static function generateToken(){
        //32位字符组成一组随机字符串
        $randChars = getRandChars(32);
        //当前的时间搓
        $timeStamp = $_SERVER['REQUEST_TIME'];


        return getRandChars(32);
    }
}