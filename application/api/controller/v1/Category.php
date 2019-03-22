<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;
/**
 * Description of Category
 *
 * @author admin
 */
class Category {
    
    public function getAllCategories() {
        $categories = CategoryModel::all([], 'img');
        if($categories->isEmpty()){
            throw  new CategoryException();
        }
        return $categories;
    }
}
