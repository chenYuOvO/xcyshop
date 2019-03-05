<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 23:05
 * 用于validate 验证错误信息
 */

namespace app\lib\exception;


class parameterException extends BaseException
{
    public $code = 400;//HTTP 状态码 400 500
    public $msg = '参数错误';//错误具体信息
    public $errorCode = 10000;//自定义状态码
}