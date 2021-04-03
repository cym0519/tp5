<?php
namespace app\api\model;
use think\Db;
use think\Exception;
class Api {
    public static function getdata($data){
        try {
//            1/0;
        }
        catch (Exception $ex){
            throw $ex;
        }
        return $data.':'.'hello';
    }
    //查询单条记录
    public function find($uid,$table){
        $res=Db::table($table)->where('uid',$uid)->find();
        return $res;
    }

}
