<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;

/**
 * Description of OrderPlace
 *
 * @author admin
 */
class OrderPlace extends BaseValidate {

    protected $rule = [
        'products' => 'checkProducts'
    ];
    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    /**
     * 验证二维数组
     * product_id:物品id
     * count:数量
     * [
     * ['product_id'=>1,'count'=>3],
     * ['product_id'=>2,'count'=>3],
     * ....
     * ]
     * @param type $values
     * @return boolean
     * @throws ParameterException
     */
    protected function checkProducts($values) {
        if (!is_array($values)) {
            throw new ParameterException(['msg' => '商品参数异常']);
        }
        if (empty($values)) {
            throw new ParameterException(['msg' => '商品列表不能为空']);
        }
        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return TRUE;
    }

    /**
     * 验证子数组中的参数
     * @param type $value
     * @throws ParameterException
     */
    protected function checkProduct($value) {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if (!$result) {
            throw new ParameterException(['msg' => '商品列表参数错误']);
        }
    }

}
