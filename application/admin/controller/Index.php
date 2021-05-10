<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\Session;

class Index extends Base {

    //首页
    public function index(){
        return $this->fetch('index');
    }

}
