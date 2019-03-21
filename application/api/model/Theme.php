<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

use think\Model;

/**
 * Description of Theme
 *
 * @author admin
 */
class Theme extends BaseModel {

    protected $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];

    public function topicImg() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg() {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products() {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }
    public static function getThemeWithProducts($id) {
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}
