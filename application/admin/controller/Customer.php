<?php


namespace app\admin\controller;
use think\Cache;
use think\Controller;
use think\Loader;
use think\Model;

class Customer extends Base
{
    //用户列表
    public function customerlist(){
        if (request()->isPost()){
            $where = [
                'nickname' => ['like',input('post.username').'%']
            ];
            $result = \model('Customer')->where($where)->find();
        }else {
            $result = model('Customer')->order('id', 'asc')->paginate(20);
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
                'addr' => input('addr'),
                'email' => input('email'),
                'tel' => input('tel'),
                'age' => input('age')
            ];
            $validate = Loader::validate('Customer');
            if ($validate->scene('edit')->check($data)){
                $result = \model('Customer')->edit($data);
                if ($result){
                    $this->success('修改成功','admin/customer/customerlist');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error($validate->getError());
            }
        }else{
            $result = \model('Customer')->find(input('id'));
            $this->assign('memberInfo',$result);
            return view();
        }
    }
    //用户添加
    public function customeradd(){
        if (request()->isAjax()){
            $data = [
                'username' => input('nickname'),
                'nickname' => input('nickname'),
                'upwd' => input('password'),
                'email' => input('email')
            ];
            if (input('conpass') != '' && input('password') == input('conpass')){
                $validate = Loader::validate('Customer');
                if ($validate->check($data)){
                    $result = \model('Customer')->add($data);
                    if ($result){
                        $this->success('添加成功','admin/customer/customerlist');
                    }else{
                        $this->error('添加失败');
                    }
                }else{
                    $this->error($validate->getError());
                }
            }else{
                $this->error('两次密码不一样');
            }
        }else{
            return view();
        }
    }

}