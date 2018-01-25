<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/19
 * Time: 11:52
 */

namespace app\index\controller;

use think\Controller;

/**
 * 公共控制器
 * Class Common
 * @package app\index\controller
 */
class Common extends Controller
{
    // 前置方法
    protected function initialize()
    {
        if(!session('id') || !session('name')){
            $this->error('您尚未登录系统',url('index/login/index'));
        }
    }
}