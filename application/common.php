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
function mailto($to,$title,$content){
//    import('PHPMailer.src.PHPMailer',VENDOR_PATH,'.php');
    import('PHPMailer.src.SMTP',VENDOR_PATH,'.php');
    import('PHPMailer.src.Exception',VENDOR_PATH,'.php');
    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.163.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'cc6619148025@163.com';                     //SMTP username
        $mail->Password = '45098119940519';                               //SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS`
        // above

        //Recipients
        $mail->setFrom('cc6619148025@163.com', 'cym');
        $mail->addAddress($to);     //Add a recipient
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $title;
        $mail->Body = $content;

        return $mail->send();
//        echo 'Message has been sent';
    } catch (Exception $e) {
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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


