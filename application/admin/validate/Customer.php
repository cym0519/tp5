<?php


namespace app\admin\validate;
use think\Validate;

class Customer extends Validate
{
    protected $rule = [
        'nickname|昵称' => 'require|max:15',
        'email|邮箱' => 'email',
        'age|年龄' => 'number|between:1,120',
        'upwd|密码' => 'require'
    ];
    protected $scene = [
        'edit' => ['age','email'],
    ];
}