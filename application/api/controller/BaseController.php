<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller;

use think\Controller;
use app\api\service\Token as TokenService;

/**
 * Description of BaseController
 *
 * @author admin
 */
class BaseController extends Controller {

    /**
     * 前置方法
     * @return boolean
     * @throws forbiddenException
     * @throws TokenException
     */
    public function checkPrimaryScope() {
        TokenService::needPrimaryScope();
    }

    /**
     * 前置方法
     * @return boolean
     * @throws forbiddenException
     * @throws TokenException
     */
    public function checkExclusiveScope() {
        TokenService::needExclusiveScope();
    }

}
