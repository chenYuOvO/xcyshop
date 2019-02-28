<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 23:26
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;

class ExceptionHandler extends  Handle
{
    public function render(Exception $ex)
    {
        return json('~~~~~~~');
    }
}