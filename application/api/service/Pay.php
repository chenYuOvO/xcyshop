<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use app\api\service\Token;
use app\lib\enum\OrderStatusEnum;

/**
 * Description of Pay
 *
 * @author admin
 */
class Pay {

    private $orderID;
    private $orderNO;

    public function __construct($orderID) {
        if (!$orderID) {
            throw new Exception('订单号不允许为null');
        }
        $this->orderID = $orderID;
    }

    public function pay() {
        //订单号可能不存在
        //订单号确实存在，但订单号和当前用户不匹配
        //订单号可能已经被支付
        //库存量进行检测

        $this->checkOrderValid();

        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    //订单号可能不存在
    //订单号确实存在，但订单号和当前用户不匹配
    //订单号可能已经被支付
    private function checkOrderValid() {
        $order = OrderModel::where('id', '=', $this->orderID)->find();
        if (!$order) {
            throw new OrderException();
        }
        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
        'msg' => '订单与用户比匹配',
        'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
        'msg' => '订单已支付过啦',
        'errorCode' => 80003,
        'code' => 400
            ]);
        }
        $this->orderNo = $order->order_no;
        return true;
    }

}
