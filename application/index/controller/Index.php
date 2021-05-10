<?php


namespace app\index\controller;
use think\console\input\Option;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use think\response\View;
use think\Session;

class Index extends Base
{
    //登录
    public function login(){
        if (\session('?name')){
            $this->redirect('index/index/index');
            return false;
        }
        if (\request()->isAjax()){
            $data = [
              'username' =>input('username'),
              'upwd' =>md5(input('password'))
            ];
            $code = input('verify');
            if (!captcha_check($code)){
                $this->error('验证码错误');
                return false;
            }
            $validata=Loader::validate('User');
            if ($validata->check($data)){
                $result = Db::name('userinfo')->where($data)->find();
                if ($result){
                    Session::set('name',$data['username']);
                    Session::set('uid',$result['uid']);
                    $this->success('登录成功','index/index/index');
                }else{
                    $this->error('登录失败');
                }
            }else{
                $this->error($validata->getError());
            }
        }else{
            return view();
        }
    }
    //注册
    public function register(){
        if (\request()->isAjax()){
            $data=[
                'username' => input('username'),
                'upwd' => md5(input('password')),
                'openid' =>'1'
            ];
            $res=Db::name('userinfo')->where('username',$data['username'])->find();
            if ($res !=''){
                $this->error('注册失败,用户名已存在');
            }else{
                $result=Db::name('userinfo')->insert($data);
                if ($result==1){
                    $this->success('成功注册!','index/index/login');
                }else{
                    $this->error('注册失败');
                }
            }
        }else{
            return view();
        }
    }
    //退出登录
    public function logout(){
        if (Session::get('name') != ''){
            session(null);
            $this->success('退出成功','index/index/login');
        }else{
            $this->redirect('index/index/login');
        }
    }
    //项目首页
    public function index(){
        $result = '';
        $where = '';
        if (input('?fid')){
            $where = [
                'ncategory' => input('fid')
            ];
            $result = Db::name('newsclass')->where('fid',input('fid'))->find();
        }
        $res = Db::name('newsinfo')->where($where)->paginate(5);
        $data = [
            'cat' =>$res,
            'class' =>$result
        ];
        $this->assign($data);
        return view();
    }
    //文章详情
    public function detail(){
        if (input('?nid')){
            $where =[
                'nid' =>input('nid'),
            ];
        }
        $db = model('newsinfo');
        $res = $db->where($where)->find();
        $result = Db::table('wp_comment')
                    ->alias('c')
                    ->join('wp_userinfo','wp_userinfo.uid=c.uid')
                    ->where($where)
                    ->field('wp_comment.*,wp_userinfo.uid,wp_userinfo.username')
                    ->paginate(5);
        $this->assign('res',$result);
        $this->assign('list',$res);
        return view();
    }
    //搜索
    public function search(){
        $fclass = input('keyword');
        $result = Db::name('newsinfo')->where('ntitle','like',input('keyword').'%')->paginate(5);
        $data = [
            'cat' =>$result,
            'class' =>$fclass
        ];
        $this->assign($data);
        return view('index');
    }
    //评论
    public function commit(){
        if(\request()->isAjax()){
            $data =[
                'content' =>input('content'),
                'nid' =>input('nid'),
                'uid' =>input('uid'),
                'time' =>time(),
            ];
            if(empty($data['uid'])){
                $this->error('请登录后再评论');
                return false;
            }
            $result = Db::name('comment')->insert($data);
            if ($result){
                $this->success('评论成功');
            }else{
                $this->error('评论失败');
            }
        }else{
            return view();
        }
    }
}