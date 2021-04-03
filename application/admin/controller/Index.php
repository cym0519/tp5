<?php
namespace app\admin\controller;

class Index {
    public function login(){
        if (request()->isAjax()){
            $data=[
                'username' =>input('username'),
                'password' =>input('password')
            ];
            print_r($data);exit();
        }
        return view();
    }
}