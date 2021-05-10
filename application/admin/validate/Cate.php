<?php


namespace app\admin\validate;
use think\Validate;

class Cate extends Validate
{
    protected $rule = [
        'catename|栏目名称' =>'require|max:10',
    ];
}