<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

use think\Model;

/**
 * Description of Image
 *
 * @author admin
 */
class Image extends Model {

    //隐藏不需要显示的字段
    protected $hidden = ['id', 'from', 'update_time', 'delete_time'];
   /**
    * 获取器
    * @param type $value 字段值
    * @param type $data 整个表的数据
    * @return type
    */
    public function getUrlAttr($value,$data) {
        $finalUrl = $value;
        if($data['from'] ==1){
            $finalUrl = config('setting.img_prefix').$finalUrl;
        }
        return $finalUrl;
    }
}
