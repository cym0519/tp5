<?php
namespace app\admin\model;
use think\Loader;
use think\Model;
use traits\model\SoftDelete;
use think\Validate;
class Cate extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    //关联文章模型
    public function article(){
        return $this->hasMany('Article','cate_id','id');
    }
    public function add($data){
        $result = $this->save($data);
        if ($result){
            return 1;
        }else{
            return '添加失败';
        }
    }
    public function edit($data){
        $res = $this->find($data['id']);
        $res->catename = $data['catename'];
        $result = $res->save();
        if ($result){
            return 1;
        }else{
            return '栏目修改失败';
        }
    }

}