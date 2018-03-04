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

Route::rule('','index/index/index');
Route::rule('article/add','index/article/add');
Route::rule('article/edit/:id','index/article/edit');
Route::rule('article/del/:id','index/article/del');
Route::rule('article/info/:id','index/article/info');
Route::rule('article','index/article/lst');

return [

];
