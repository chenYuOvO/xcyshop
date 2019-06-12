<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\service;

use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

/**
 * Description of WxNotify
 *
 * @author admin
 */
class WxNotify extends \WxPayNotify {

    public function NotifyProcess($objData, $config, &$msg) {
        
    }

}
