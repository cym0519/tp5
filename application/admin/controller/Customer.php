<?php


namespace app\admin\controller;
use think\Controller;
use think\Model;

class Customer extends Base
{
    //用户列表
    public function customerlist(){
//        $result = model('Customer')->with('profile')->where('id','1797')->find();
//        print_r($result);die();
        if (request()->isPost()){
            $where = [
                'nickname' => ['like',input('post.username').'%']
            ];
            $result = \model('Customer')->where($where)->find();
//            print_r(count($result));
        }else {
            $result = model('Customer')->order('id', 'asc')->paginate(20);
//            print_r(count($result));
        }
        $this->assign('members', $result);
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
    //用户编辑
    public function customeredit(){
        if (request()->isAjax()){
            $data = [
                'id' => input('post.id'),
                'nickname' => input('nickname'),
                'password' => input('oldpass'),
                'newpass' => input('newpass'),
                'addr' => input('addr'),
                'email' => input('email'),
                'tel' => input('tel'),
                'age' => input('age')
            ];

        }else{
            $result = \model('Customer')->find(input('id'));
            $this->assign('memberInfo',$result);
            return view();
        }
    }
}