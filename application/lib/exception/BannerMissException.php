<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 23:32
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;//HTTP 状态码 400 500
    public $msg = '请求Banner不存在';//错误具体信息
    public $errorCode = 10000;//自定义状态码
}