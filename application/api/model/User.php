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
class User extends BaseModel {

    public function address() {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID($openid) {
        $user = self::where('openid', '=', $openid)->find();
        return $user;
    }

}
