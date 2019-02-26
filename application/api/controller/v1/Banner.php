<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/25
 * Time: 23:40
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;

class Banner
{
    public function getBanner($id){
        $res = (new IDMustBePostiveInt())->goCheck();
    }

}