<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/26
 * Time: 23:10
 */

namespace app\api\validate;

use app\lib\exception\parameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {

    public function goCheck() {
        //获取参数
        //对参数进行校验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new parameterException(['msg' => $this->error]);
            throw $e;
        } else {
            return true;
        }
    }

    /**
     * 参数是否为正整数
     * @param type $values
     * @param type $rule
     * @param type $data
     * @param type $fields
     * @return boolean
     */
    protected function isPostiveIntager($values, $rule = '', $data = '', $fields = '') {
        if (preg_match("/^[1-9][0-9]*$/", $values)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
