<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\validate;

/**
 * Description of Count
 *
 * @author admin
 */
class Count extends BaseValidate {

    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];

}
