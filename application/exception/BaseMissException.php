<?php


namespace app\exception;
use app\exception\BaseException;

class BaseMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Base不存在';
    public $errorcode = 40000;
}