<?php


namespace app\api\Validate;
use think\Validate;

class User extends Validate
{
    protected $rule=[
        'username' =>'require|max:10',
        'upwd' =>'require|max:32'
    ];
}