<?php


namespace app\api\controller;
use think\cache\driver\Redis;
use think\console\input\Option;
use think\Controller;
use think\Db;
use think\paginator\driver\Bootstrap;
use think\Request;
use think\Session;
use think\Validate;
use think\Cache;
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
        ];
        return $this->view->fetch('index',$data);
    }
    //联系页面
    public function contact(){
        if (\request()->isAjax()){
            $data = [
                'nickname' => input('nickname'),
                'email' => input('email'),
                'content' => input('content')
            ];
            $rule = [
                'nickname|昵称' => 'require',
                'email|邮箱' => 'require|email',
                'content|留言内容' => 'require'
            ];
            $validate = new Validate($rule);
            $res = $validate->check($data);
            if ($res){
                $result = Db::name('message')->insert($data);
                if ($result){
                    $this->success('留言成功','api/index/contact');
                }else{
                    $this->error('留言失败');
                }
            }else{
                $this->error($validate->getError());
            }
        }
        return $this->view->fetch('contact');
    }
    //shop页面
    public function shop(){

        return $this->view->fetch('shop');
    }
    //获取天气情况
    public function weather(){
        $ip=$this->getip();
        // $city=ipaddr($ip);
        $city = '';
        $res=weatherdata($city);
        if($res['result'] != ''){
            $data = $res['result'];
            $result = $data['data']['realtime'];
        }else{
            $result = '';
        }
        // print_r($result);die();
        $this->assign('data',$result);
        return view();
    }
    public function search(){
        $city = input('post.city_name');
        $res=weatherdata($city);
        // print_r($city);die();
        if($res['result'] != ''){
            $data = $res['result'];
            $result = $data['data']['realtime'];
        }else{
            $result = '';
        }
        $this->assign('data',$result);
        return view('weather');
    }
    //获取ip地址
    public function getip(){
        $request = Request();
        return $request->ip();
    }
    //历史上的今天
    public function today(){
        $redis = new \think\session\driver\Redis();
//        dump($redis);die();
        $data=today();
        $count = count($data);
        $page = new Bootstrap($count,'5');
        $this->assign('data',$data);
        $this->assign('page',$page);
        return view();
    }
    //新闻头条
    public function top(){
        $data = top();
//        print_r($data);
        $this->assign('data',$data);
        return view();
    }
    //头条新闻详情
    public function detail(){
        $data = input();
        $result = detail($data['key']);
//        print_r($result);die();
        $this->assign('data',$result);
        return view();
    }
    //签到
    public function sign(){
        if (\request()->isAjax()){
            $uid = Session::get('name');
            $data = Db::name('sign')->where('userid')->select();
            if (count($data) == 0){
                $res = Db::name('sign')
                    ->insert(['times' =>date('Y-m-d H:i:s'),'userid' =>$uid,'days' =>'1','number' =>'15','one'=>date('d',time())]);
                return 1;
            }else{
                //判断今天是否签到
                $todaybegin = date('y-m-d'."00:00:00");
                $todayend = date('y-m-d'."23:59:59");
                $where = [
                    'userid' =>$uid,
                    'times' =>'between',[$todaybegin,$todayend]
                ];
                $isexit = Db::name('sign')->field('times')->where($where)->select();
                if (count($isexit) == 1){
                    return 0;
                }else{
                    $times = Db::name('sign')->where('userid',$uid)->field('times')->select();
                    $time = strtotime($times[0]['times']);
                    if (time()-$time > 24*60*60){//连续签到时间大于24小时，连续签到天数清零
                        $query = Db::name('sign')->where('userid',$uid)->update(['days'=>1]);
                    }else{//连续签到时间小于24小时，连续签到跟新
                        $query = Db::name('sign')->where('userid',$uid)->setInc('days');
                    }
                    $query1 = Db::name('sign')->where('userid',$uid)->update(['times'=>date('y-m-d H:i:s')]);
                    $query2 = Db::name('sign')->where('userid',$uid)->setInc('number',15);
                    $sqldate = date('m',$time);//上次签到日期的月份
                    $nowdate = date('m',time());//这次签到日期的月份
                    //记录本次签到日期
                    if ($sqldate != $nowdate){//上次签到日期与本次签到日期月份不一样
                        $oldtime = $times[0]['times'];
                        $onetime = date('Y-m-d H:i:s',strtotime("-1 month"));//获取前1个月的时间，获取格式为2016-12-30 13:26:13
                        $twotime = date('Y-m-d H:i:s',strtotime("-2 month"));//获取前2个月的时间
                        $threetime = date('Y-m-d H:i:s',strtotime("-3 month"));//获取前3个月的时间
                        $result = Db::name('sign')->where('userid',$uid)->field('one,two,three')->select();
                        if ($oldtime < $onetime && $oldtime >= $twotime){//月份间隔 大于1个月，小于2个月
                            $one = date('d',time());
                            $two =$result[0]['one'];
                            $three = $result[0]['two'];
                        }elseif ($oldtime < $twotime && $oldtime >= $threetime){//月份间隔 大于2个月，小于3个月
                            $one = date('d',time());
                            $two = '';
                            $three = $result[0]['one'];
                        }elseif ($oldtime < $threetime){//月份间隔 大于3个月
                            $one =  date('d',time());
                            $two = '';
                            $three = '';
                        }
                        $query3 = Db::name('sign')->where('userid',$uid)->update(['one'=>$one,'two'=>$two,'three'=>$three]);
                    }else{//上次签到日期与本次签到日期月份一样
                        $one = Db::name('sign')->where('userid',$uid)->field('one')->select();
                        $arr[] = $one[0]['one'];
                        $arr[] = date('d',time());
                        $newones = implode(",",$arr);
                        $query3 = Db::name('sign')->where('userid',$uid)->update(['one'=>$newones]);
                    }
                    return 1;
                }
            }
        }else{
            return view();
        }
    }
    //redis测试
    public function redis(){
//        $redis = new Redis();
        // $redis->connect('127.0.0.1','6379');
        // $redis->set('demo','123123');
        // $data = Db::name('customer')->paginate(1000);
        // Cache::store('redis')->set('demo','123456');
        // Cache::store('redis')->set('demo',$data);
        // $list = Cache::get('demo') ? Cache::get('demo') : $data;
        // $list = '2222222222';
        if(Cache::get('demos')){
            $list = Cache::get('demos');
        }else{
            $list = Db::name('customer')->paginate(1000);
            Cache::set('demos',$list,10);
        }
        print_r($list);
        // print_r(Cache::get('cym'));
    }
}