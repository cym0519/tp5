<?php


namespace app\admin\controller;


use think\Db;
use think\Loader;
use think\Model;

class Article extends Base
{
    //文章列表
    public function articlelist(){
        $articles = model('Article')->with('cate')->paginate(5);
//        print_r((array)$articles);die();
        $this->assign('articles',$articles);
        return view();
    }
    //添加文章
    public function articleadd(){
        if (request()->isAjax()){
            $data = [
                'title' =>input('title'),
                'author' =>input('author'),
                'tags'  =>input('tags'),
                'cate_id' =>input('cateid'),
                'desc'  =>input('desc'),
                'content' =>input('content'),
                'aup'  =>input('aup'),
            ];
            $validate = Loader::validate('Article');
            if ($validate->check($data)){
                $result = \model('Article')->add($data);
                if ($result){
                    $this->success('文章添加成功','admin/article/articlelist');
                }else{
                    $this->error('文章添加失败');
                }
            }else{
                $this->error($validate->getError());
            }
        }
        $cates = \model('Cate')->select();
        $this->assign('cates',$cates);
        return view();
    }
    //文章编辑
    public function articleedit(){
        if (request()->isAjax()){
            $data = [
                'id' => input('post.id'),
                'title' => input('title'),
                'author' => input('author'),
                'tags' => input('tags'),
                'cate_id' => input('cateid'),
                'desc' => input('desc'),
                'content' => input('content'),
                'aup' => input('aup')
            ];
            $validate = Loader::validate('Article');
            if ($validate->check($data)){
                $result = \model('Article')->edit($data);
                if ($result){
                    $this->success('文章编辑成功','admin/article/articlelist');
                }else{
                    $this->error($result);
                }
            }else{
                $this->error($validate->getError());
            }
        }
        $articles = Db::name('article')
            ->alias('a')
            ->join('cate','cate.id=a.cate_id')
            ->field('article.*,cate.id as cid,cate.catename')
            ->where('article.id',input('id'))
            ->find();
        $cates = model('Cate')->select();
        $this->assign('cates',$cates);
        $this->assign('articleInfo',$articles);
        return view();
    }
    //文章删除
    public function articledel(){
        $res = \model('Article')->find(input('post.id'));
        $result = $res->delete();
        if ($result){
            $this->success('删除成功','admin/article/articlelist');
        }else{
            $this->error('删除失败');
        }
    }
}