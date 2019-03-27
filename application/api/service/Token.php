<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

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

}
