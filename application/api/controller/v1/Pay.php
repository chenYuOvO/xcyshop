<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

/**
 * Description of Pay
 *
 * @author admin
 */
class Pay extends BaseController {

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    /**
     * 微信支付-预订单
     * @param type $id
     * @return type
     */
    public function getPreOrder($id = '') {
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    /**
     * 微信支付回调
     */
    public function receiveNotify() {
        //1.检测库存量
        //2.跟新订单状态
        //3.减库存
        //如果处理成功，向微信返回处理成功信息，否则，返回处理不成功信息
        
    }

}
