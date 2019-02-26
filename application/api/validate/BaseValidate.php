<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/26
 * Time: 23:10
 */

namespace app\api\validate;


use think\Exception;
use think\Request;
use think\Validate;
class BaseValidate extends Validate
{
    public function goCheck(){
        //获取参数
        //对参数进行校验
       $request = Request::instance();
       $params = $request->param();

       $result = $this->check($params);
       if(!$result){
           $error = $this->error;
           throw new Exception(Exception);
       }else{
           return true;
       }
    }
}