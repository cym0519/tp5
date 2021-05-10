<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

    use think\Route;
Route::group('admin',function (){
    Route::rule('/','admin/user/login','get|post');
    Route::rule('index','admin/index/index','get|post');
    Route::rule('loginout','admin/user/loginout','post');
    Route::rule('catelist','admin/cate/catelist','get|post');
    Route::rule('cateadd','admin/cate/cateadd','get|post');
    Route::rule('cateedit/[:id]','admin/cate/cateedit','get|post');
    Route::rule('catedel','admin/cate/catedel','get|post');
    Route::rule('articlelist','admin/article/articlelist','get|post');
    Route::rule('articleadd','admin/article/articleadd','get|post');
    Route::rule('articleedit/[:id]','admin/article/articleedit','get|post');
    Route::rule('articledel','admin/article/articledel','post');
});