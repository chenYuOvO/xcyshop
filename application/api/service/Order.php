<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\OrderException;
use app\api\model\UserAddress;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct;
use think\Db;

/**
 * Description of Order
 *
 * @author admin
 */
class Order {

    //订单商品列表，客户端传过来的products参数
    protected $oProducts;
    //真实商品信息，包括库存量
    protected $products;
    protected $uid;

    public function place($uid, $oproducts) {
        //$oproducts和$products作对比
        //products从数据库中查出来
        $this->oProducts = $oproducts;
        $this->products = $this->getProductsByOrder($oproducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    /**
     * 创建订单
     */
    private function createOrder($snap) {
        Db::startTrans();
        try {
            $orderNo = self::makeOrderNo();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;

            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    /**
     * 创建订单号
     * @return string
     */
    public static function makeOrderNo() {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                        'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                        '%02d', rand(0, 99));
        return $orderSn;
    }

    /**
     * 创建快照
     * @param type $status
     */
    private function snapOrder($status) {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => NULL,
            'snapName' => '',
            'snapImg' => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products['0']['name'];
        $snap['snapImg'] = $this->products['0']['main_img_url'];
        if (count($this->products) > 1) {
            $snap['snapName'] .='等';
        }
        return $snap;
    }

    /**
     * 获取用户收货地址
     * @param type $param
     */
    private function getUserAddress() {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
        'msg' => '用户收货地址不存在，下单失败',
        'errorCode' => 60001,
            ]);
        }
        return $userAddress->toArray();
    }

    //根据订单查找真实商品信息
    private function getProductsByOrder($oProducts) {
        $oPIDs = [];
        foreach ($oProducts as $value) {
            array_push($oPIDs, $value['product_id']);
        }
        $products = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }

    public function checkOrderStock($orderID) {
        $oproducts = OrderProduct::where('order_id', '=', $orderID)->select();
        $this->oProducts = $oproducts;
        $this->products = $this->getProductsByOrder($oproducts);
        $status = $this->getOrderStatus();
        return $status;
    }

    private function getOrderStatus() {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => [],
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products) {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
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
            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

}
