<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\exception;

/**
 * Description of forbiddenException
 *
 * @author admin
 */
class ForbiddenException extends BaseException{

    public $code = 403;
    public $msg = "权限不够";
    public $errorCode = 10001;

}
