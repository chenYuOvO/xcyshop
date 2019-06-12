<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use app\api\model\Order;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\lib\order\OrderStatus;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;
use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

/**
 * Description of WxNotify
 *
 * @author admin
 */
class WxNotify extends \WxPayNotify {

    public function NotifyProcess($objData, $config, &$msg) {

        $data = $objData->GetValues();
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try {
                $order = Order::where('order_no', '=', $orderNo)->lock(true)->find();
                if ($order->status == 1) {
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);//检测库存
                    if ($stockStatus['pass']) {
                        //库存充足
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
                    } else {
                        //库存不充足
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
            } catch (Exception $ex) {
                Db::rollback();
                Log::error($ex);
                // 如果出现异常，向微信返回false，请求重新发送通知
                return false;
            }
        }
        return true;
    }

    /**
     * 减库存
     * @param type $status
     */
    private function reduceStock($status) {
        foreach ($status['pStatusArray'] as $singlePStatus) {
            Product::where('id', '=', $singlePStatus['id'])
                    ->setDec('stock', $singlePStatus['count']);
        }
    }

    /**
     * 更改订单状态
     * @param type $orderID
     * @param type $success
     */
    private function updateOrderStatus($orderID, $success) {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        Order::where('id', '=', $orderID)
                ->update(['status' => $status]);
    }

}
