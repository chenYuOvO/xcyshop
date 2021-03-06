<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of Order
 *
 * @author admin
 */
class Order extends BaseModel {

    protected $autoWriteTimestamp = true;
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    
    public function getSnapAddressAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
    public function getSnapItemsAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
    
    public static function getSummaryByUser($uid, $page = 1, $size = 15) {

        $paginateData = self::where('user_id', '=', $uid)
                ->order('create_time desc')
                ->paginate($size, true, ['page' => $page]);
        return $paginateData;
    }

}
