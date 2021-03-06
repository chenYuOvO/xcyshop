<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeException;

/**
 * Description of Theme
 *
 * @author admin
 */
class Theme {

    /**
     * 首页精选主题
     * @param type $ids
     * @return type
     * @throws ThemeException
     */
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if ($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }
    /**
     * 获取某个主题下的商品
     * @param type $id
     * @return type
     * @throws ThemeException
     */
    public function getComplexOne($id) {
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if (!$theme) {
            throw new ThemeException();
        }
        return $theme;
    }

}
