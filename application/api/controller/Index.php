<?php


namespace app\api\controller;
use think\console\input\Option;
use think\Controller;
use think\Request;
use think\Session;

class Index extends Controller
{
        //初始化
    public function _initialize(){
        if (!session('?name')){
            $this->redirect('api/api/login');
        }
    }
    //生成随机4位数验证码
    public function mewscontent(){
        $codedata = rand(1,9).rand(1,9).rand(1,9).rand(1,9);
        return $codedata;
    }
    //项目首页
    public function index(){
        $data = [
            'name' => Session::get('name'),
            'rand' => $this->mewscontent()
        ];
        return $this->view->fetch('index',$data);
    }
    //联系页面
    public function contact(){

        return $this->view->fetch('contact');
    }
    //shop页面
    public function shop(){

        return $this->view->fetch('shop');
    }
    //获取天气情况
    public function getweather(){
//        $ip='116.11.100.166';
        $ip=$this->getip();
        $city=ipaddr($ip);
        $result=weatherdata($city);
        print_r($result);

    }
    //获取ip地址
    public function getip(){
        $request = Request();
        return $request->ip();
    }
    //历史上的今天
    public function today(){
        $data=today();
        $this->assign('data',$data);
        return view();
    }
    public function dockweixin(){
        //将timestamp,nonce，token按字典排序
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        $token     = 'weixin';
        $signature = $_GET['signature'];
        $array     = array($timestamp, $nonce, $token);
        sort($array);
        //将排序后的三个参数拼接之后用sha1加密
        $tmpstr = implode('',$array);
        $tmpstr = sha1($tmpstr);
        //将加密后的字符串与signature进行对比，判断该请求是否来自微信
        if($tmpstr == $signature){
            echo $_GET['echostr'];
            exit;
        }
    }
}