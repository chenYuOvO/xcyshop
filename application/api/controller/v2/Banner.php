<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/25
 * Time: 23:40
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;

class Banner {

    public function getBanner($id) {
        return ' this is v2';
    }

}
