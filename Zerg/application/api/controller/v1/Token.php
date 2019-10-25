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

    /**
     * 获取Token
     * @param string $code
     * @return array
     * @throws \think\Exception
     * @author ldz
     * @time 2019/10/15 19:32
     */
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $userToken = new UserToken($code);
        $token = $userToken->get();
        return json(['token' => $token]);
    }

}