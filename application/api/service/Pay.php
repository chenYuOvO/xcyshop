<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

/**
 * Description of Pay
 *
 * @author admin
 */
class Pay {

    private $orderID;
    private $orderNO;

    public function __construct($orderID) {
        if(!$orderID){
            throw new Exception('订单号不允许为null');
        }
        $this->orderID = $orderID;
    }
    public function pay() {
        
    }
}
