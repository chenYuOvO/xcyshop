<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\validate\TokenGet;
use app\api\service\UserToken;

/**
 * Description of Token
 *
 * @author admin
 */
class Token {

    public function getToken($code = '') {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return $token;
    }

}
