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
    Route::rule('customerlist','admin/customer/customerlist','get|post');
    Route::rule('customeredit/[:id]','admin/customer/customeredit','get|post');
    Route::rule('customeradd','admin/customer/customeradd','get|post');
    Route::rule('customerdel','admin/customer/customerdel','get|post');
    Route::rule('upload','admin/test/upload','get|post');
    Route::rule('duqu','admin/test/duqu','get|post');
    Route::rule('getdata','admin/test/getdata','get|post');
});
    Route::rule('weather','api/index/weather','get|post');
    Route::rule('getip','api/index/getip','get|post');
    Route::rule('contact','api/index/contact','get|post');
    Route::rule('today','api/index/today','get|post');
    Route::rule('index','api/index/index','get|post');
    Route::rule('logout','api/api/logout','get|post');
    Route::rule('retrieve','api/api/retrieve','get|post');
    Route::rule('register','api/api/register','get|post');
    Route::rule('search','api/index/search','get|post');
    Route::rule('redis','api/index/redis','get|post');
    Route::rule('top','api/index/top','get|post');
    Route::rule('detail/[:key]','api/index/detail','get|post');
    Route::rule('/','api/api/login','get|post');
