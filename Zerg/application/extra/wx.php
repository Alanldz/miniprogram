<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/14
 * Time: 19:00
 */
return [
    'app_id' => 'wxacc3195bed170713',

    'secret' => 'd120e8069e30d43fd79bb15c3b875f3f',//APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），

    'mchid' => '',//MCHID：商户号（如果有需要支付的话，必须配置，开户邮件中可查看）

    'key' => '',//KEY：商户支付密钥

    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" . "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

];