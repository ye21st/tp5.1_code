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

Route::rule('/', 'index/index/index');

//  栏目路由
Route::rule('cate/add','index/cate/add');
Route::rule('cate/edit/:id', 'index/cate/edit');
Route::rule('cate/del/:id', 'index/cate/del');
Route::rule('cate', 'index/cate/lst');

return [

];
