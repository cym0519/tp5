<?php
namespace app\api\service;

use think\Exception;

class UserToken
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppId,$this->wxAppSecret,$this->code);
    }

    public function get($code){
        $result=curl_get($this->wxLoginUrl);
        $wxresult=json_decode($result,true);
        if (empty($wxresult)){
            throw new Exception('获取seesion_key及opendid时异常，微信内部错误');
        }else{
            $logonfail = array_key_exists('errcode',$wxresult);
            if ($logonfail){

            }else{

            }
        }
    }
}