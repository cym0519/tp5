<?php


namespace app\admin\model;

use traits\model\SoftDelete;
use think\Model;

class Image extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

}