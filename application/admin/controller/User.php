<?php


namespace app\admin\controller;
use think\Controller;

use think\Db;
use think\Loader;
use think\Session;

class User extends Controller
{
    //登录
    public function login(){
        $validate = Loader::validate('admin');
        if (request()->isAjax()){
            $data = [
                'username' =>input('username'),
                'password'     =>md5(input('password')),
            ];
            if ($validate->check($data)){
                $result = Db::name('user')->where($data)->find();
                if ($result){
                    Session::set('name',$result['username']);
                    $this->success('登录成功','admin/index/index');
                }else{
                    $this->error('登录失败');
                }
            }else{
                $this->error($validate->getError());
            }
        }
        return view();
    }
    //退出
    public function loginout(){
        \session(null);
        if (\session('?name')){
            $this->error('退出失败!');
        }else{
            $this->success('退出成功','admin/user/login');
        }
    }
}