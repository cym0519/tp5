<?php


namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;

class Profile extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function customer(){
        return $this->belongsTo('Customer','user_id');
    }
}