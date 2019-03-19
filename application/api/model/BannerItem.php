<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

use think\Model;
/**
 * Description of BannerItem
 *
 * @author admin
 */
class BannerItem extends Model{
    //put your code here
    
    public function img() {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}
