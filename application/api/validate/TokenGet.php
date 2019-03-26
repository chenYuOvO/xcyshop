<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\validate;

/**
 * Description of TokenGet
 *
 * @author admin
 */
class TokenGet extends BaseValidate {

    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];
    protected $message = [
        'code' => 'code不能为空'
    ];

}
