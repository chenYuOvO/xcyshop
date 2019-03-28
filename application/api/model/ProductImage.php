<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of ProductImage
 *
 * @author admin
 */
class ProductImage extends BaseModel {

    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl() {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

}
