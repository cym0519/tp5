<?php


namespace app\admin\validate;
use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|文章标题' =>'require|unique:article',
        'cate_id|所属栏目' =>'require',
        'tags|标签' =>'require',
        'desc|文章简要' =>'require',
        'content|文章内容' =>'require',
    ];
}