<?php


namespace app\admin\model;


use think\Model;
use traits\model\SoftDelete;

class Article extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    //关联栏目模型
    public function cate(){
        return $this->hasOne('Cate','id','cate_id');
    }
    //添加
    public function add($data){
        $result = $this->save($data);
        if ($result){
            return 1;
        }else{
            return '添加失败';
        }
    }
    //编辑
    public function edit($data){
        $res = $this->find($data['id']);
        $result = $res->save($data);
        if ($result){
            return 1;
        }else{
            return '编辑失败了';
        }
    }
}