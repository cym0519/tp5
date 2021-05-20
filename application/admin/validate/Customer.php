<?php


namespace app\admin\validate;
use think\Validate;

class Customer extends Validate
{
    protected $rule = [
        'nickname|昵称' => 'require|max:10',
        'addr|地址' => 'require',
        'email|邮箱' => 'require|email',
        'tel|电话号码' => 'require',
        'age|年龄' => 'require'
    ];
}