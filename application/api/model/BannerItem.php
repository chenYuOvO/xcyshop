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
class BannerItem extends Model {

    //隐藏不需要显示的字段SS
    protected $hidden = ['id', 'img_id', 'banner_id', 'update_time', 'delete_time'];

    public function img() {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

}
