<?php


namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Error;
use think\Loader;

class Cate extends Base
{
    public function catelist(){
        $cates = model('Cate')->paginate(10);
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }
    //栏目添加
    public function cateadd(){
        if (request()->isAjax()){
            $data = [
                'catename' =>input('catename'),
            ];
            $res = Db::name('cate')->where('catename','like',$data['catename'].'%')->find();
            if ($res){
                $this->error('栏目名称不能相同');
            }else{
                $validate = Loader::validate('Cate');
                if ($validate->check($data)){
                    $result = model('Cate')->add($data);
                    if ($result){
                        $this->success('添加成功','admin/cate/catelist');
                    }else{
                        $this->error($result);
                    }
                }else{
                    $this->error($validate->getError());
                }
            }
        }
        return view();
    }
    //栏目编辑
    public function cateedit(){
        if (request()->isAjax()){
            $data = [
                'id' =>input('post.id'),
                'catename' =>input('catename'),
            ];
            $res = Db::name('cate')->where('catename','like',$data['catename'].'%')->find();
            if (!$res){
                $validate = Loader::validate('Cate');
                if ($validate->check($data)) {
                    $result = model('Cate')->edit($data);
                    if ($result) {
                        $this->success('栏目修改成功', 'admin/cate/catelist');
                    } else {
                        $this->error($result);
                    }
                }else{
                    $this->error($validate->getError());
                }
            }else{
                $this->error('栏目名称不能相同');
            }
        }
        $cateinfo =Db::name('cate')->find(input('id'));
        $this->assign('cateInfo',$cateinfo);
        return view();
    }
    //栏目删除
    public function catedel(){
        $res = model('Cate')->find(input('post.id'));
        $result = $res->delete();
        if ($result){
            Db::name('article')->where('cate_id',input('post.id'))->delete();
            $this->success('删除成功','admin/cate/catelist');
        }else{
            $this->error('删除失败');
        }
    }
}