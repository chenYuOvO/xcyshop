<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\validate;

/**
 * Description of IDCollection
 *
 * @author admin
 */
class IDCollection extends BaseValidate{
    protected $rule = [
        'ids'=>'require|checkIDs',
    ];
    protected $message = [
        'ids'=>'ids必须是以逗号隔开的正整数'
    ];
    protected function checkIDs($value) {
        $values = explode(',', $value);
        if(empty($values)){
            return FALSE;
        }
        foreach ($values as $id) {
            if(!$this->isPostiveIntager($id)){
                return FALSE;
            }
        }
        return TRUE;
    }
}
