<?php


namespace app\api\controller;

use weixinpay\NativePay;
use weixinpay\WxPayConfig;
use weixinpay\WxPayResults;
use weixinpay\database\WxPayUnifiedOrder;
use think\Db;
use think\cache\driver\Redis;
class Wxpay{
    public function pay(){
        $orderData['out_trade_no'] = time();
        $orderData['total_price'] = 1;

        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody("支付订单");
        $input->SetAttach("test");
        $input->SetOut_trade_no(time());
        $input->SetTotal_fee(1);//单位是分
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://120.77.146.195/api/wxpay/notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");

        $result = $notify->GetPayUrl($input);
        $url2 = $result["code_url"];

        //生成二维码
        //二维码链接$url2
        //生成二维码的函数qrcode.php
        return view('',[
            'url2' => $url2,//二维码链接
            'orderData' => $orderData
        ]);
    }
    //微信支付回调
    public function notify(){
        //接受数据流
        $weixindata = file_get_contents("php://input");
        //数据流存放在2.txt,是xml格式
        file_put_contents('2.txt',$weixindata,FILE_APPEND);

        $config = new WxPayConfig();

        try {
            $resultObj = new WxPayResults();
            $weixindata = $resultObj->Init($config,$weixindata);
            echo "解析正确";
        }catch (\Exception $e){//返回给微信的应答
            $resultObj->setData('return_code','FAIL');
            $resultObj->SetData('return_msg',$e->getMessage());
            return $resultObj->ToXml();
        }
        //return_code此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
        if ($weixindata['return_code'] === 'FAIL' || $weixindata['result_code'] !== 'SUCCESS'){
            $resultObj->SetData('return_code','FAIL');
            $resultObj->SetData('return_msg','error');
            return $resultObj->ToXml();
        }
        //验证订单和订单金额
        if ($weixindata['result_code'] == 'SUCCESS'){
            $orderdata = Db::name('order')->where('out_trade_no',$weixindata['out_trade_no'])->find();
            if (!empty($orderdata) && $orderdata['total_price']*100 == $weixindata['total_fee']){
                //更改订单状态
                Db::name('order')->where('out_trade_no',$weixindata['out_trade_no'])->update(['status'=>1,'pay_time'=>time()]);
                //通知微信支付成功
                $resultObj->setData('return_code', 'SUCCESS');
                $resultObj->setData('return_msg', 'OK');
                return $resultObj->ToXml();
            }else{
                $resultObj->setData('return_code', 'FAIL');
                $resultObj->setData('return_msg', 'error');
                return $resultObj->ToXml();
            }
        }
    }
    //检查订单是否已支付
    public function get_pay_status(){
        $out_trade_no = input('out_trade_no');
        $orderdata = Db::name('order')->where('out_trade_no',$out_trade_no)->find();
        if ($orderdata['status'] == 1){
            return json(['status'=>1]);
        }
        return json(['status'=>0]);
    }
    //支付后跳转到这里
    public function myorder(){
        echo '订单支付成功!';
    }
}


