<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use \think\Exception;
use app\lib\exception\WeChatException;
use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;
/**
 * Description of UserToken
 *
 * @author admin
 */
class UserToken extends Token {

    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code) {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    /**
     * 获取session_key和openID
     * @throws Exception
     */
    public function get() {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key和openID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                //获取失败
                $this->processLoginErr($wxResult);
            } else {
                //获取成功
                return $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult) {
        //拿到openid
        //查看数据库中是否有openid,如果不存在，新增数据;
        //生成令牌
        //准备缓存数据，写入缓存，
        //key:令牌
        //value: wxResult,uid ,scope
        //把令牌返回给客户端
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token  = $this->saveToCache($cachedValue);
        return $token;
    }

    /**
     * 写入缓存
     * @param type $cachedValue
     */
    private function saveToCache($cachedValue) {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key, $value, $expire_in);
        if(!$request){
            throw new TokenException(['msg'=>'服务器异常','errorCode'=>10005,]);
        }
        return $key;
    }

    /**
     * 准备缓存数据
     * value: wxResult,uid ,scope
     * @param type $wxResult
     * @param type $uid
     */
    private function prepareCachedValue($wxResult, $uid) {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        //16-app用户；32-CMS管理员
        $cachedValue['scope'] = ScopeEnum::User;
//        $cachedValue['scope'] = ScopeEnum::Super;
        return $cachedValue;
    }

    /**
     * 查看数据库中是否有openid,如果不存在，新增数据;
     * @param type $openid
     * @return type
     */
    private function newUser($openid) {
        $user = UserModel::create(['openid' => $openid]);
        return $user->id;
    }

    /**
     * 返回微信端错误信息
     * @param type $wxResult
     * @throws WeChatException
     */
    private function processLoginErr($wxResult) {
        throw new WeChatException(['msg' => $wxResult['errmsg'], 'errorCode' => $wxResult['errcode']]);
    }

}
