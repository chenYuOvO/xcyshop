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
use think\Log;
use think\Request;

class ExceptionHandler extends  Handle
{
    private $code;
    private $msg;
    private $errorCode;
    public function render(Exception $e)
    {
        if ($e instanceof BaseException) {
            //如果是自定义异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误，就不告诉你';
                $this->errorCode = 999;
                $this->recordErrorLog($e);//写入日志
            }

        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_rul' => $request->url()
        ];
        return json($result, $this->code);
    }
        //自定义日志
    private function recordErrorLog(Exception $e){
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            // 日志记录级别，使用数组表示
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(),'error');
    }
}