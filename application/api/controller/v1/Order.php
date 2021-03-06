<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\OrderException;
/**
 * Description of Order
 *
 * @author admin
 */
class Order extends BaseController {

    //用户在选择商品后，向API提交它包含所选择的商品信息
    //API在接收到信息后，需检查订单中，商品的库存量
    //有库存，订单数据存入数据库中（下单成功），返回客户端消息，告诉客户端可以支付了
    //调用支付接口
    //还需要在检测库存量
    //服务器调用微信支付接口进行支付
    //小程序根据服务器返回的参数拉起微信支付
    //微信返回支付结果
    //支付成功，也要检测库存量
    //支付成功后，减去库存量；失败，返回一个失败的结果
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser']
    ];

    /**
     * 订单支付
     */
    public function placeOrder() {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }
    /**
     * 历史订单
     * @param type $page
     * @param type $size
     */
    public function getSummaryByUser($page = 1, $size = 15) {
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage(),
            ];
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage(),
        ];
    }
    /**
     * 订单详情
     * @param type $id
     * @return type
     * @throws OrderException
     */
    public function getDetail($id) {
        (new IDMustBePostiveInt() )->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }
}
