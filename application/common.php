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
function mailto($email,$content){
    \think\Loader::import('PHPMailer.phpmailer');
    \think\Loader::import('PHPMailer.smtp');
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
            return $result;
        }else{
            return $result['error_code'];
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
//新闻头条的查询
function top(){
    $apiurl = 'http://v.juhe.cn/toutiao/index';
    // 请求参数
    $params = [
        'type' => 'top', // 新闻类型
        'key' => '90c24de36649d04f798e70d89339c027', // 接口调用key，通过聚合平台申请开通
    ];
    $paramsString = http_build_query($params);

    // 发起接口请求
    $response = juhecurl($apiurl, $paramsString, 1);

    // 处理接口返回结果，根据自身业务逻辑修改处理
    $paramstring = http_build_query($params);
    $content = juhecurl($apiurl, $paramstring, 1);
    $result = json_decode($content, true);
    if ($result) {
        if ($result['error_code'] == 0) {
            // 请求成功，根据自身业务逻辑修改处理
            $news = $result['result']['data'];
            return $news;
//            if ($news) {
//                foreach ($news as $key => $newsInfo) {
//                    // 更多字段，请参考官方接口文档
//                    echo $newsInfo['title'].PHP_EOL;
//                }
//            }
        } else {
            // 请求异常，根据自身业务逻辑修改处理
            echo "{$result['error_code']}:{$result['reason']}" . PHP_EOL;
        }
    } else {
        //可能网络异常等问题请求失败，根据自身业务逻辑修改处理
        echo "请求失败";
    }
}
//新闻头条详情查询
function detail($key){
    $apiurl = 'http://v.juhe.cn/toutiao/content';
    // 请求参数
    $params = [
        'uniquekey' => $key, // 新闻ID
        'key' => '90c24de36649d04f798e70d89339c027', // 接口调用key，通过聚合平台申请开通
    ];
    $paramsString = http_build_query($params);

    // 发起接口请求
    $response = juhecurl($apiurl, $paramsString, 1);

    // 处理接口返回结果，根据自身业务逻辑修改处理
    $paramstring = http_build_query($params);
    $content = juhecurl($apiurl, $paramstring, 1);
    $result = json_decode($content, true);
    if ($result) {
        if ($result['error_code'] == 0) {
            // 请求成功，根据自身业务逻辑修改处理
            return $newsContent = $result['result'];
        } else {
            // 请求异常，根据自身业务逻辑修改处理
            echo "{$result['error_code']}:{$result['reason']}" . PHP_EOL;
        }
    } else {
        //可能网络异常等问题请求失败，根据自身业务逻辑修改处理
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


