<?php


namespace app\admin\controller;
use think\Controller;

class Customer extends Base
{
    public function customerlist(){
//        $result = model('Customer')->with('profile')->where('id','1797')->find();
//        print_r($result);die();
        $result = model('Customer')->order('id','asc')->paginate(15);
        $this->assign('members',$result);
        return view();
    }
    //删除
    public function customerdel(){
        $res = model('Customer')->with('profile')->find(input('post.id'));
        $data = [
            'id' =>input('post.id'),
        ];
        $result = model('Customer')->del($data);
        if ($result){
            $this->success('用户删除成功','admin/customer/customerlist');
        }else{
            $this->error('删除失败');
        }
    }
}