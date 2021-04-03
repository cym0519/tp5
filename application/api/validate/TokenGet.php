<?php


namespace app\api\Validate;
use think\Validate;

class TokenGet extends Validate
{
    protected $rule=[
        'code' =>'require|isNotEmpty'
    ];
    protected $message=[
        'code' =>'没有code来获取Token'
    ];
}