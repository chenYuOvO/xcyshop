<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/26
 * Time: 21:51
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id'=>'require|isPostiveIntager',
    ];

    protected function isPostiveIntager($values,$rule,$data,$fields){
        if(preg_match("/^[1-9][0-9]*$/" ,$values)){
            return true;
        }else{
            return $fields.'必须为正整数';
        }
    }
}