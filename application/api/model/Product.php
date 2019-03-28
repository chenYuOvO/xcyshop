<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\model;

/**
 * Description of Product
 *
 * @author admin
 */
class Product extends BaseModel {

    protected $hidden = ['update_time', 'create_time', 'delete_time', 'category_id', 'from', 'pivot', 'main_img_id'];

    public function getMainImgUrlAttr($value, $data) {
        return $this->prefixImgUrl($value, $data);
    }

    public function imgs() {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties() {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    /**
     * 首页-最近新品
     * @param type $count
     */
    public static function getMostRecent($count) {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    /**
     * 分类下的商品
     * @param type $categoryID
     * @return type
     */
    public static function getProductsByCategoryID($categoryID) {
        $products = self::where('category_id', '=', $categoryID)->select();
        return $products;
    }

    /**
     * 获取商品详情
     * @param type $id
     */
    public static function getProductDetail($id) {
        $product = self::with('imgs,properties')->find($id);
        return $product;
    }

}
