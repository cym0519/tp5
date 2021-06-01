<?php


namespace app\admin\controller;


use think\Db;

class Test extends Base
{
    public function upload(){
        if (request()->isPost()){
            $file = request()->file('image');
            if ($file){
                $info = $file->validate(['ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
                if ($info){
                    $thumb = DS.'uploads'.DS.$info->getSaveName();
                    $data['url'] = $thumb;
//                    $result = Db::name('image')->insert($data);
                    $result = model('Image')->save($data);
                    if ($result){
                        echo '上传成功';
                    }else{
                        echo '上传失败';
                    }
                }else{
                    $this->error($file->getError());
                }
            }
        }else{
            return view();
        }
    }
    public function duqu(){
        $result = Db::name('image')->select();
        $this->assign('data',$result);
        return view();
    }
    public function getdata(){
        $data = Db::name('cateory')->select();
        $res = $this->cateory($data);
        print_r($res);
    }
    //
    public function cateory($data,$pid = 0,$level = 0){
        static $arr = array();
        foreach ($data as $key => $val){
            if ($val['pid'] == $pid){
                $val['level'] = $level;
                $arr[] = $val;
                $this->cateory($data,$val['pid'],$level+1);
            }
        }
        return $arr;
    }
}