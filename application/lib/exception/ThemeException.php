<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\exception;

/**
 * Description of ThemeException
 *
 * @author admin
 */
class ThemeException extends BaseException {

    public $code = 404;
    public $msg = '指定主题不存在,请检查主题ID';
    public $errorCode = 30000;

}
