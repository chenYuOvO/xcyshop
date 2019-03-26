<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\exception;

/**
 * Description of WeChatException
 *
 * @author admin
 */
class WeChatException extends BaseException{
    public $code = 404;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}
