<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\validate;

/**
 * Description of pagingParameter
 *
 * @author admin
 */
class PagingParameter extends BaseValidate {

    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger',
    ];
    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数',
    ];

}
