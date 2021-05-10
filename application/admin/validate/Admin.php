<?php
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule =[
        'username|用户名' =>'require|max:10',
        'password|密码'      =>'require|max:32',
    ];
}