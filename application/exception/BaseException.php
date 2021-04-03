<?php
namespace app\exception;

class BaseException {
    //HTTP 状态码 404，200
    public $code = 400;
    //错误信息
    public $msg = 'parameter error';
    //自定义的错误码
    public $errorcode = 10000;
}
