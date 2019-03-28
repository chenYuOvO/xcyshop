<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;
use app\api\validate\IDMustBePostiveInt;

/**
 * Description of Product
 *
 * @author admin
 */
class Product {

    /**
     * 最新新品
     * @param type $count
     * @return type
     * @throws ProductException
     */
    public function getRecent($count = 15) {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products->hidden(['summary']);
        return $products;
    }

    /**
     * 分类下所有商品
     * @param type $id
     * @return type
     * @throws ProductException
     */
    public function getAllInCategory($id) {
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products->hidden(['summary']);
        return $products;
    }

    /**
     * 商品详情
     * @param type $id
     * @return type
     * @throws ProductException
     */
    public function getOne($id) {
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }

}
