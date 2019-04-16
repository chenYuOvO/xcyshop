<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/26
 * Time: 21:51
 */

namespace app\api\validate;

use think\Validate;

class IDMustBePostiveInt extends BaseValidate {

    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message = [
        'id' => 'id必须为正整数',
    ];

}
