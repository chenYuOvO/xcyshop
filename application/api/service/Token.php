<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use think\Cache;
use think\Request;
use app\lib\exception\TokenException;

/**
 * Description of Token
 *
 * @author admin
 */
class Token {

    public static function generateToken() {
        //32个字符组成随机字符
        $randChars = getRandChar(32);
        //用三组字符串，进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //SALT 盐
        $salt = config('secure.token_salt');
        return md5($randChars . $timestamp . $salt);
    }

    /**
     * 获取token缓存中的某个值
     * @param type $key
     * @return type
     * @throws TokenException
     * @throws Exception
     */
    public static function getCurrentTokenVar($key) {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, TRUE);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token不存在');
            }
        }
    }
    /**
     * 获取用户uid
     * @return type
     */
    public static function getCurrentUid() {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}
