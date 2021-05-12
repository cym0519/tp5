<?php


namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;

class Customer extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function profile(){
        return $this->hasOne('Profile','user_id','id');
    }
    //用户编辑
    public function edit($data){

    }
    //删除用户
    public function del($data){
        $res = $this->with('profile')->find($data['id']);
        $result = $res->together('profile')->delete();
        if ($result){
            return 1;
        }else{
            return '删除失败';
        }
    }
}