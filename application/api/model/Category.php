<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of Category
 *
 * @author admin
 */
class Category extends BaseModel {

    protected $hidden = ['delete_time', 'update_time'];

    public function img() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

}
