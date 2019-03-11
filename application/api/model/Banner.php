<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 22:26
 */

namespace app\api\model;


use think\Db;

class Banner
{
    public static function getBannerByID($id){
       $resutl =  Db::table('banner')->where('id','=',$id)->select();
        return $resutl;
    }
}