<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

use think\Model;
/**
 * Description of BaseModel
 *
 * @author admin
 */
class BaseModel extends Model{
   /**
    * 获取器
    * @param type $value 字段值
    * @param type $data 整个表的数据
    * @return type
    */
   protected function prefixImgUrl($value,$data) {
        $finalUrl = $value;
        if($data['from'] ==1){
            $finalUrl = config('setting.img_prefix').$finalUrl;
        }
        return $finalUrl;
    }
}
