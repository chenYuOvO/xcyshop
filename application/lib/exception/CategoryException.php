<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\exception;

/**
 * Description of CategoryException
 *
 * @author admin
 */
class CategoryException extends BaseException {

    public $code = 404;
    public $msg = '指定类目不存在,请检查参数';
    public $errorCode = 50000;

}
