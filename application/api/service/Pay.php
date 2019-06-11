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
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

/**
 * Description of Pay
 *
 * @author admin
 */
class Pay {

    private $orderID;
    private $orderNo;

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
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    /**
     * 创建预订单
     * @param type $totalPrice
     * @throws TokenException
     */
    private function makeWxPreOrder($totalPrice) {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('加入书院《刘连阳》费用:0.01元');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url('');
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData) {
        $config = new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config,$wxOrderData);
        // 失败时不会返回result_code
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
//            throw new Exception('获取预支付订单失败');
        }        
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
