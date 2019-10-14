<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/12
 * Time: 19:01
 */

namespace app\api\Controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{

    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $userToken = new UserToken($code);
        $token = $userToken->get();
        return $token;
    }

}