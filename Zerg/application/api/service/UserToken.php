<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/10/14
 * Time: 9:26
 */

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;

class UserToken extends Token
{
    protected $code;

    protected $wxAppID;

    protected $wxAppSecret;

    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    /**
     * 获取Token
     * @throws Exception
     * @author ldz
     * @time 2019/10/14 19:20
     */
    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        } else {
            if (array_key_exists('errcode', $wxResult)) {
                $this->processLoginError($result);
            } else {
                return $this->grandToken($wxResult);
            }
        }
    }

    /**
     * 返回Token
     * @param $wxResult
     * @return string
     * @throws TokenException
     * @author ldz
     * @time 2019/10/15 19:31
     */
    private function grandToken($wxResult)
    {
        //拿到openID
        //查询数据库，判断openID是否存在
        //如果存在，则不处理，如果不存在那么新增一条user记录
        //生成令牌，准备缓存数据，写入缓存
        //将令牌还回到客户端去
        //key:令牌
        //value：wxResult,uid,scope
        $openID = $wxResult['openid'];
        $user = UserModel::getByOpenid($openID);
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openID);
        }
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    /**
     * 保存带缓存中
     * @param $cachedValue
     * @return string
     * @throws TokenException
     * @author ldz
     * @time 2019/10/16 8:52
     */
    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in);
        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    /**
     * 新增用户
     * @param $openID
     * @return mixed
     * @author ldz
     * @time 2019/10/14 20:25
     */
    private function newUser($openID)
    {
        $user = UserModel::create([
            'openid' => $openID
        ]);
        return $user->id;
    }

    /**
     * 错误异常处理
     * @param $wxResult
     * @throws WeChatException
     * @author ldz
     * @time 2019/10/14 19:35
     */
    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'code' => $wxResult['errcode'],
            'msg' => $wxResult['errmsg']
        ]);
    }
}