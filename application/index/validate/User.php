<?php


namespace app\index\Validate;
use think\Validate;

class User extends Validate
{
    protected $rule=[
        'username' =>'require|max:5',
        'upwd' =>'require|max:32'
    ];
}