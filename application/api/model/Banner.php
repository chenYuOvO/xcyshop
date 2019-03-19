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

class Banner extends Model {

    //隐藏不需要显示的字段
    protected $hidden = ['update_time', 'delete_time'];

    /**
     * 关联banner_item
     * @return type
     */
    public function items() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id) {
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }

}
