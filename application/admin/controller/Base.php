<?php


namespace app\admin\controller;

use think\Controller;

class Base extends Controller{

    public function _initialize()
    {
        if (!session('?name')){
            $this->redirect('admin/user/login');
        }
    }
}