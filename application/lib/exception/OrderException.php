<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 22:51
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;//HTTP 状态码 400 500
    public $msg = '指定订单不存在，请检查ID';//错误具体信息
    public $errorCode = 80000;//自定义状态码
}