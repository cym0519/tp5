<?php


namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
use app\admin\model\Profile;
class Customer extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function profile(){
        return $this->hasOne('Profile','user_id','id');
    }
    //用户添加
    public function add($data){
//        $result = $this->save(['username' => $data['nickname'],'nickname' => $data['nickname'],'upwd' => $data['upwd']]);
        $cus = new Customer();
        $cus->username = $data['nickname'];
        $cus->nickname = $data['nickname'];
        $cus->upwd = $data['upwd'];
        $profile = new Profile();
        $profile->email = $data['email'];
        $cus->profile = $profile;
        $result = $cus->together('profile')->save();
        if ($result){
            return 1;
        }else{
            return '添加失败';
        }
    }
    //用户编辑
    public function edit($data){
        $this->startTrans();
        $res = $this->find($data['id']);
        $res->nickname = $data['nickname'] ? $data['nickname'] : '';
        $res->profile->email = $data['email'] ? $data['email'] : '';
        $res->profile->age = $data['age'] ? $data['age'] : '';
        $res->profile->addr = $data['addr'] ? $data['addr'] : '';
        $res->profile->tel = $data['tel'] ? $data['tel'] : '';
        $res->save();
        $res->profile->save();
        if ($res){
            $this->commit();
            return 1;
        }else{
            $this->rollback();
            return '修改失败';
        }
    }
    //删除用户
    public function del($data){
        $this->startTrans();
        $res = $this->with('profile')->find($data['id']);
        $result = $res->together('profile')->delete();
        if ($result){
            $this->commit();
            return 1;
        }else{
            $this->rollback();
            return '删除失败';
        }
    }
}