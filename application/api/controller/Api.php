<?php
namespace app\api\controller;
use http\Env\Request;
use think\config;
use think\Db;
use think\Exception;
use think\Loader;
use think\response\Json;
use think\response\View;
use think\Session;
use think\validate;
use app\api\model\Api as IndexModel;
use app\api\model\UserInfo;
use \think\Controller;
class Api extends Controller{
    //退出登录
    public function logout(){
        if (Session::get('name') != ''){
            session(null);
            $this->success('退出成功','api/api/login');
        }else{
            $this->redirect('api/api/login');
        }

    }

    //用户登录
    public function login(){
        if (session('?name')){
            $this->redirect('api/index/index');
            return false ;
        }
        $validata=Loader::validate('User');
        if(request()->isAjax()){
            $data=[
                'username' =>input('username'),
                'upwd' =>md5(input('password')),
            ];
            $code=trim(input('vcode'));
            if (!captcha_check($code)){
                $this->error('验证码错误');
                return false;
            }
            if($validata->check($data)){
                $res=Db::name('userinfo')->where($data)->find();
                if ($res){
                    Session::set('name',$data['username']);
                    $this->success('登录成功','api/index/index');
                }else{
                    $this->error('登录失败');
                }
            }else{
                $this->error($validata->getError());
            }
        }
        return view();
    }
    //用户注册
    public function register(){
        if (Request()->isAjax()){
            $data=[
                'username' => input('username'),
                'upwd' => md5(input('password'))
            ];
            $res=Db::name('userinfo')->where('username',$data['username'])->find();
//            print_r($res);exit();
            if ($res !=''){
                $this->error('注册失败,用户名已存在');
            }else{
                $result=Db::name('userinfo')->insert($data);
                if ($result==1){
                    $this->success('成功注册!','api/api/login');
                }else{
                    $this->error('注册失败');
                }
            }
        }
        return view();
    }

    //找回密码
    public function retrieve(){
        if (Request()->isAjax()){

        }else{
            return view();
        }
    }
    //生成4位随机数
    public function mescontent(){
        $codedata = rand(1,9).rand(1,9).rand(1,9).rand(1,9);
        return $codedata;
    }
    //邮箱发送
    public function sendmes(){
        if (\request()->isAjax()){
             $data=[
                 'email' =>input('email'),
             ];
             if (mailto($data['email'],'验证码',$this->mescontent())){
                 $this->success('发送成功');
             }else{
                 $this->error('发送失败');
             }
        }
    }
    public function test(){
        $request= request();
        return config::get('wx.app_id');
//        return view();
    }
    public function getinfo(){
        $db = new UserInfo();
        $arr=[];
        for ($i=1;$i<20;$i++){
            $arr[]=[
                'username' =>'cym'.rand(),
                'age' => 1+$i.rand(),
                'email' => $i.rand().'@qq.com',
                'password' => md5(time().$i)
            ];
        }
//        $data=$db->insertAll($arr);
        print_r($arr);

    }

    public function database(){
        $data=new IndexModel();
        $uid=422;
        $table='wp_userinfo';
        $resdata=$data->find($uid,$table);
        $res=Db::query('select * from wp_userinfo where uid=?',[1797]);
        $result=Db::name('userinfo')->where('uid',420)->find();
        print_r($resdata);
//        print_r($result);
//        print_r($res);
        $request=Request();
        $qq=$request->domain();
//        echo $qq;
    }


    public function logins(){
        $data='qwer';
        $result=new IndexModel();
        try {
            $res = $result->getdata($data);
        } catch (Exception $e) {
        }

        return $res;
//        return view();
        
    }
    public function getdata(){
        $rule = [
            'name'  => 'require|max:10',
            'age'   => 'number|between:1,120',
            'email' => 'email',
        ];

        $msg = [
            'name.require' => '名称必须',
            'name.max'     => '名称最多不能超过10个字符',
            'age.number'   => '年龄必须是数字',
            'age.between'  => '年龄只能在1-120之间',
            'email'        => '邮箱格式错误',
        ];


        $data=[
            'name' => 'thinkphp',
            'age' => '20',
            'email' => 'thinkphp@qq.com'
        ];
        
        $validate = new validate($rule,$msg);

        $result = $validate->check($data);

        if ($result){
            dump($result);
        }else {
            dump($validate->getError());
        }
        
    }

}
