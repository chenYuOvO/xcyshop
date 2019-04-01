<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\exception;

/**
 * Description of UserException
 *
 * @author admin
 */
class UserException extends BaseException {

    public $code = 401;
    public $msg = "用户不存在";
    public $errorCode = 60000;

}
