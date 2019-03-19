<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 22:26
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
    /**
     * 关联banner_item
     * @return type
     */
    public function items() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
    public static function getBannerByID($id){
       $resutl =  Db::table('banner')->where('id','=',$id)->select();
        return $resutl;
    }
}