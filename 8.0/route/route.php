<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

Route::rule('','index/Index/index');
Route::rule('article/test','index/Excel/test');
Route::rule('article/add','index/Article/add');
Route::rule('article/edit/:id','index/Article/edit');
Route::rule('article/del/:id','index/Article/del');
Route::rule('article/info/:id','index/Article/info');
Route::rule('article','index/Article/lst');
Route::rule('article/import','index/Article/import');
Route::rule('article/export','index/Article/export');

return [

];
