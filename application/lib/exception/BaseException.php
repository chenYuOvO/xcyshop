<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 23:28
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    public $code = 400;//HTTP 状态码 400 500
    public $msg = '参数错误';//错误具体信息
    public $errorCode = 10000;//自定义状态码
    public function __construct($param= [])
    {
        if(!is_array($param)){
            return ;
        }
        if(array_key_exists('code',$param)){
            $this->code = $param['code'];
        }
        if(array_key_exists('msg',$param)){
            $this->msg = $param['msg'];
        }
        if(array_key_exists('errorCode',$param)){
            $this->errorCode = $param['errorCode'];
        }
    }
}