<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
/**
 * Description of Theme
 *
 * @author admin
 */
class Theme {

    public function getSimpleList($ids ='') {
        (new IDCollection())->goCheck();
    }

}
