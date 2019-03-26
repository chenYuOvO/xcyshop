<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of User
 *
 * @author admin
 */
class User extends BaseModel{
    public static function getByOpenID($openid) {
        $user = self::where('opendid','=',$openid)->find();
        return $user;
    }
}
