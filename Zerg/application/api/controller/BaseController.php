<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/24
 * Time: 11:50
 */

namespace app\api\controller;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{

    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }

}