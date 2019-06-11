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

    public function getPreOrder($id='') {
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        $pay->pay();
    }

}
