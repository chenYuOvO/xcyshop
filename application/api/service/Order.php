<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

/**
 * Description of Order
 *
 * @author admin
 */
class Order {

    //订单商品列表，客户端传过来的products参数
    protected $oproducts;
    //真实商品信息，包括库存量
    protected $products;
    protected $uid;

    protected function place($uid, $oproducts) {
        //$oproducts和$products作对比
        //products从数据库中查出来
        $this->oproducts = $oproducts;
        $this->products =  $this->getProductsByOrder($oproducts);
        $this->uid = $uid;
    }

    //根据订单查找真实商品信息
    protected function getProductsByOrder($oproducts) {
        $oPIDs = [];
        foreach ($oproducts as $value) {
            array_push($oPIDs, $value['product_id']);
        }
        $products = Product::all(oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }

}
