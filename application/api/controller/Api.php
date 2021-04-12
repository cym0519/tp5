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
use think\Log;

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
    //对接微信公众平台
    public function dockweixin(){
        if (isset($_GET['echostr'])) {
            $this->valid();
        }else{
            $this->responseMsg();
        }
    }
    //
    public function valid(){
        $echostr = $_GET["echostr"];
        if ($this->checkSignature()) {
            header('content-type:text');
            echo $echostr;
            exit;
        }
    }
    //验证微信
    public function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = 'cym';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
    
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    //接收微信事件推送并回复
    public function responseMsg(){
        //获取到微信推送过来的post数据(XML格式)
        // $postArr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postArr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        //处理消息类型，并设置回复类型和内容
        // $postObj = simplexml_load_string($postArr);
        $postObj = simplexml_load_string($postArr,'SimpleXMLElement',LIBXML_NOCDATA);
        $keyword = trim($postObj->Content);
        //判断该数据包是否是订阅的事件推送
        if(strtolower($postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件
            if ( strtolower($postObj->Event == 'subscribe')) {
                echo $this->subscribe($postObj);
            }
        }else if ( strtolower($postObj->MsgType == 'text') && trim($postObj->Content) == '图片') {
            echo $this->image($postObj);
        }else{
            echo $this->text($postObj);
        }
    }
    //关注后回复的信息
    public function subscribe($postObj){
        //回复信息
        $toUser   = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time     = time();
        $msgType  = 'text';
        $content  = '欢迎来到云上长安';
        $template = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        return sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
    }
    //文本回复
    public function text($postObj){
        switch ( trim($postObj->Content)) {
            case '陈焕';
                $content = '颠佬正传';
                break;
            case 'tel';
                $content = '15677135691';
                break;
            case 'php';
                $content = 'php是世界上最好的编程语言';
                break;
            case "？";
                $content = date("Y-m-d H:i:s",time());
                break;
            case trim($postObj->Content):
                $content = '您输入的是：'.trim($postObj->Content);
                break;
            default:
                break;
        }
        $toUser   = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time     = time();
        $msgType  = 'text';
        $template = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        return sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
    }
    //单多图文回复,开发者只能回复单图文
    public function image($postObj){
        $toUser   = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time     = time();
        $msgType  = 'news';
        $arr = array(
            array(
                'title' => '一曲肝肠断,天涯何处觅知音',
                'description' => '你看,这就是专业!',
                'picurl' =>'http://120.77.146.195/static/api/img/login-bg.jpg',
                'url' => 'http://www.jd.com'
            ),
            array(
                'title' => '侠客行',
                'description' => '千里走单骑',
                'picurl' =>'http://120.77.146.195/static/api/img/about.jpg',
                'url' => 'http://www.baidu.com'
            ),
            array(
                'title' => '诗经',
                'description' => '乐府诗集',
                'picurl' =>'http://120.77.146.195/static/api/img/blog1.jpg',
                'url' => 'http://www.qq.com'
            ),
        );
        $template = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <ArticleCount>".count($arr)."</ArticleCount>
                    <Articles>";
        foreach($arr as $key=>$v){
                $template .= "<item>
                            <Title><![CDATA[".$v['title']."]]></Title>
                            <Description><![CDATA[".$v['description']."]]></Description>
                            <PicUrl><![CDATA[".$v['picurl']."]]></PicUrl>
                            <Url><![CDATA[".$v['url']."]]></Url>
                            </item>";
        }
        $template .= "</Articles>
                    </xml>";
        return sprintf($template,$toUser,$fromUser,$time,$msgType);          
    }
    //获取微信accesstoken
    public function getwxaccesstoken(){
        $appid = 'wxf06de655a2c4307f';
        $appsecret   = 'a0a54ae36a67c4c97a086ebcc247fa08';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        //初始化
        $ch = curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //调用接口
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }
        //关闭接口
        curl_close($ch);
        //返回json数据
        $arr = json_decode($res,true);
        return $arr['access_token'];
    }
    //获取微信服务器地址ip
    public function getwxip(){
        $accesstoken = $this->getwxaccesstoken();
        $url = "https://api.weixin.qq.com/cgi-bin/get_api_domain_ip?access_token=".$accesstoken;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }
        curl_close($ch);
        $arr = json_decode($res,true);
        print_r($arr['ip_list']);
    }
    //获取用户openid
    public function getwxinfo(){
        //获取code
        $appid = 'wxf06de655a2c4307f';
        $redirect_uri = urlencode("http://120.77.146.195/api/getwxcode");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=0519#wechat_redirect";
        echo "<script language='javascript'>window.location='".$url."'</script>";
        // header('location:'.$url);
    }
    //获取accesstoken
    public function getwxcode(){
        //获取到网页授权的accesstoken
        $appid = 'wxf06de655a2c4307f';
        $appsecret = 'a0a54ae36a67c4c97a086ebcc247fa08';
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $res = curl_get($url);
        $data = json_decode($res,true);
        return $data['access_token'];
    }
    //
    public function getuser()
    {
        $appid = 'wxf06de655a2c4307f';
        $redirect_uri = urlencode("http://120.77.146.195/api/getuserinfo");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=0519#wechat_redirect";
        // echo "<script language='javascript'>window.location='".$url."'</script>";
        header('location:'.$url);
    }
    //获取用户详细信息
    public function getuserinfo(){
        $appid = 'wxf06de655a2c4307f';
        $appsecret = 'a0a54ae36a67c4c97a086ebcc247fa08';
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $res = curl_get($url);
        $data = json_decode($res,true);
        $accesstoken = $data['access_token'];
        $openid = $data['openid'];
        //获取用户详细信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$accesstoken."&openid=".$openid."&lang=zh_CN";
        $result = curl_get($url);
        print_r($result);

    }
    //微信分享
    public function share(){
        $jsapiticket = $this->getjsapiticket();
        $url = 'http://120.77.146.195/api/share';
        $timestamp = time();
        $noncestr = $this->getrandcode();
        $signature = "jsapiticket=".$jsapiticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$url;
        print_r($signature);exit;
        $signature = sha1($signature);
        $data = [
            'signature' => $signature,
            'noncestr' => $noncestr,
            'timestamp' => $timestamp,
            'name' => 'cym'
        ];
        print_r($data);
        return $this->fetch('share',$data);
    }
    //获取票据
    public function getjsapiticket(){
        if(Session::get('jsapiticket') && Session::get('jsapiticket_time') > time()){
            $jsapiticket = Session::get('jsapiticket');
        }else{
            $accesstoken = $this->getwxaccesstoken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$accesstoken."&type=jsapi";
            $res = curl_get($url);
            $data = json_decode($res,true);
            $jsapiticket = $data['ticket'];
            Session('jsapiticket',$jsapiticket);
            Session('jsapiticket_time',time()+7000);
        }
        return $jsapiticket;
    }
     //获取随机码
     public function getrandcode($num=16){
        $array = [
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            '0','1','2','3','4','5','6','7','8','9'
        ];
        $tmpstr = '';
        $max = count($array);
        for ($i=1; $i <=$num; $i++) { 
            $key = rand(0,$max-1);
            $tmpstr .= $array[$key];
        }
        return $tmpstr;
     }
     public function http_curl($url,$type = 'get',$res = 'json',$arr = ''){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if($type == 'post'){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);

     }
     //创建微信菜单
     public function creatmenu(){
        $accesstoken = $this->getwxaccesstoken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=".$accesstoken;
        $postArr = array(
            'button' => array(
                array(
                    'name' =>'菜单1',
                    'type' =>'click',
                    'key' =>'item1'
                ),
                array(
                    'name' =>'菜单2',
                    'sub_button' =>array(
                        array(
                            'name' =>'歌曲',
                            'type' =>'click',
                            'key' =>'songs',
                        ),
                        array(
                            'name' =>'电影',
                            'type' =>'view',
                            'url' =>'http://www.jd.com',
                        ),
                    ),
                ),
            ),
            array(),
            array()
        );
        $postjson = json_encode($postArr);
        $result = $this->http_curl($url,'post','json',$postjson);
        var_dump($result);
     }   
}
