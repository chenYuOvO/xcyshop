<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\OrderException;

/**
 * Description of Order
 *
 * @author admin
 */
class Order
{

    //订单商品列表，客户端传过来的products参数
    protected $oProducts;
    //真实商品信息，包括库存量
    protected $products;
    protected $uid;

    protected function place($uid, $oproducts)
    {
        //$oproducts和$products作对比
        //products从数据库中查出来
        $this->oProducts = $oproducts;
        $this->products = $this->getProductsByOrder($oproducts);
        $this->uid = $uid;
        $status = $this->getoOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单
        
    }

    //根据订单查找真实商品信息
    protected function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $value) {
            array_push($oPIDs, $value['product_id']);
        }
        $products = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }

    private function getoOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => [],
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];
        for ($i = 0; $i <= count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $oPID;
            }
        }
        if ($pIndex == -1) {
            throw new OrderException(['msg' => 'ID为' . $oPID . '商品不存在，订单创建失败']);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $product['name'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if ($product['stock'] - $oCount <= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }
}
