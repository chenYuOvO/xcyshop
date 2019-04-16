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
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays) {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException([
        'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    /**
     * 参数是否为正整数
     * @param type $values
     * @param type $rule
     * @param type $data
     * @param type $fields
     * @return boolean
     */
    protected function isPositiveInteger($values, $rule = '', $data = '', $fields = '') {
        if (preg_match("/^[1-9][0-9]*$/", $values)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 参数是否为空值
     * @param type $values
     * @param type $rule
     * @param type $data
     * @param type $fields
     * @return boolean
     */
    protected function isNotEmpty($values, $rule = '', $data = '', $fields = '') {
        if (!empty($values)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value) {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
