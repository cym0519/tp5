<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
//use PHPMailer\src\PHPMailer;
//use PHPMailer\src\SMTP;
//use PHPMailer\src\Exception;

//include '../vendor/autoload.php';

// 应用公共文件

function curl_get($url, &$httpCode = 0){
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
    //不做证书校验，部署在linux环境下修改为true；
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}
//邮件发送
function sendmail($email,$content){
    \think\Loader::import('PHPMailer.src.PHPMailer');//加载extend中的自定义类
    \think\Loader::import('PHPMailer.src.SMTP');
    \think\Loader::import('PHPMailer.src.Exception');
    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    try {
        header("content-type:text/html;charset=utf-8");
        // 使用SMTP方式发送
        $mail->IsSMTP();
        // 设置邮件的字符编码
        $mail->CharSet='UTF-8';
        // 企业邮局域名
        $mail->Host = 'smtp.qq.com';
        //---------qq邮箱需要的------//设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        //设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = 587;//---------qq邮箱需要的------
        // 启用SMTP验证功能
        $mail->SMTPAuth = true;
        //邮件发送人的用户名(请填写完整的email地址)
        $mail->Username = '986306442@qq.com' ;
        // 邮件发送人的 密码 （授权码）
        $mail->Password = 'bnyjmfubnebhbfca';  //修改为自己的授权码
        //邮件发送者email地址
        $mail->From ="986306442@qq.com";
        //发送邮件人的标题
        $mail->FromName ="123456789@qq.com";
        //收件人的邮箱 给谁发邮件
        $email_addr = $email;
        //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->AddAddress("$email_addr", substr(  $email_addr, 0 , strpos($email_addr ,'@')));
        //回复的地址
        $mail->AddReplyTo('986306442@qq.com' , "" );
        $mail->AddAttachment("./mail.rar"); // 添加附件
        //set email format to HTML //是否使用HTML格式
        $mail->IsHTML(true);
        //邮件标题
        $mail->Subject = '验证码';
        //邮件内容
        $mail->Body =  "<p style='color:#ff0000'>" . $content . '</p>';
        //附加信息，可以省略
        $mail->AltBody = '';
        // 添加附件,并指定名称
        $mail->AddAttachment( './error404.php' ,'php文件');
        //设置邮件中的图片
        $mail->AddEmbeddedImage("shuai.jpg", "my-attach", "shuai.jpg");
        if( !$mail->Send() ){
                $mail_return_arr['mark'] = false ;
            $str  =  "邮件发送失败. <p>";
            $str .= "错误原因: " . $mail->ErrorInfo;
            $mail_return_arr['info'] = $str ;
        }else{
            $mail_return_arr['mark'] = true ;
            $str =  "邮件发送成功";
            $mail_return_arr['info'] = $str ;
        }
        echo "<pre>";
        print_r( $mail_return_arr);
    }catch (Exception $exception){
        \exception($mail->ErrorInfo, '100');
    }

}
function mailto($email,$content){
    \think\Loader::import('PHPMailer.phpmailer');
    \think\Loader::import('PHPMailer.smtp');
//    \think\Loader::import('PHPMailer.src.Exception');
    $mail = new PHPMailer();
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.qq.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = '986306442@qq.com';                     //SMTP username
        $mail->Password = 'bnyjmfubnebhbfca';                               //SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS`
        // above
        //Recipients
        $mail->setFrom('986306442@qq.com', 'cym');
        $mail->addAddress($email);     //Add a recipient
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = '验证码';
        $mail->Body = $content;

        return $mail->send();
    }catch (Exception $e){
        \exception($mail->ErrorInfo, '100');
    }

}
//获取天气预报
function weatherdata($city){
    $appkey = '8e1de5ce7e3dff8336577a42626459aa';

    //************1.根据城市查询天气************
    $url = "http://op.juhe.cn/onebox/weather/query";
    //请求参数
    $params = array(
        "cityname" => $city,//要查询的城市，如：温州、上海、北京
        "key" => $appkey,//应用APPKEY(应用详细页查询)
        "dtype" => "json",//返回数据的格式,xml或json，默认json
    );
    //处理接口返回结果，根据自身业务逻辑修改处理
    $paramstring = http_build_query($params);
    $content = juhecurl($url,$paramstring);
    $result = json_decode($content,true);
    if($result){
        if($result['error_code']=='0'){
            $data=$result['result'];
            return $data['data']['realtime'];
        }else{
            return $result['error_code'].":".$result['reason'];
        }
    }else{
        echo "请求失败";
    }

}
//历史上的今天
function today(){
    $appkey = 'b99c82ec56d35774ebb790ecc6b1268e';

    //************1.根据城市查询天气************
    $url = "http://v.juhe.cn/todayOnhistory/queryEvent.php";
    //请求参数
    $time = date('n/j');
    $params = array(
        "date" => $time,//
        "key" => $appkey,//应用APPKEY(应用详细页查询)
        "dtype" => "json",//返回数据的格式,xml或json，默认json
    );
    //处理接口返回结果，根据自身业务逻辑修改处理
    $paramstring = http_build_query($params);
    $content = juhecurl($url,$paramstring);
    $result = json_decode($content,true);
    if($result){
        if($result['error_code']=='0'){
            return $result['result'];
        }else{
            return $result['error_code'].":".$result['reason'];
        }
    }else{
        echo "请求失败";
    }
}
//IP的归属地查询
function ipaddr($ip){
    //接口请求key
    $appkey = "3543163a1f7ccc4a2c5ffb0246494db4";
    //
    $url = "http://apis.juhe.cn/ip/ipNew";
    $params = [
        "ip" => $ip,//需要查询的IP地址或域名
        "key" => $appkey,//应用APPKEY(应用详细页查询)
    ];
    $paramstring = http_build_query($params);
    $content = juhecurl($url, $paramstring, 1);
    $result = json_decode($content, true);
    if ($result) {
        if ($result['error_code'] == 0) {
//            echo "国家：{$result['result']['Country']}" . PHP_EOL;
//            echo "省份：{$result['result']['Province']}" . PHP_EOL;
//            echo "城市：{$result['result']['City']}" . PHP_EOL;
//            echo "运营商：{$result['result']['Isp']}" . PHP_EOL;
            return $result['result']['City'];
        } else {
            return $result['error_code'].':'.$result['reason'] . PHP_EOL;
        }
    } else {
        echo "请求失败";
    }
}
//聚合数据API接口
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;

}


