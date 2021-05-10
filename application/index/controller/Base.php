<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Session;

class Base extends Controller
{
    public function _initialize()
    {
        //共享视图
        $cats = Db::name('newsclass')->select();
        $user = Session::get('name');
        $viewdata = [
            'menu' =>$cats,
            'user' =>$user,
            'uid' =>Session::get('uid')
        ];
        $this->view->share($viewdata);
    }
}