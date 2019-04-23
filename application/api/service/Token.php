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
use app\lib\enum\ScopeEnum;
use app\lib\exception\forbiddenException;
use think\Exception;

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

    //需要用户和cms都可以访问的接口权限
    public static function needPrimaryScope() {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return TRUE;
            } else {
                throw new forbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    //只有用户才可以访问的接口权限
    public static function needExclusiveScope() {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return TRUE;
            } else {
                throw new forbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

//检测uid 是否和当前登录人uid相同
    public static function isValidOperate($checkedUID) {
        if (!$checkedUID) {
            throw new Exception();
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }

}
