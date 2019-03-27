<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\exception;

/**
 * Description of TokenException
 *
 * @author admin
 */
class TokenException extends BaseException {

    public $code = 401;
    public $msg = "Token已过期或无效";
    public $errorCode = 10001;

}
