<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/23
 * Time: 15:36
 */

namespace app\index\controller;
use think\Controller;

/**
 * 公共控制器类 - 主要用来存放一些公共的页面，比如，头部、底部
 * Class Common
 * @package app\index\controller
 */
class Common extends Controller
{
    /**
     * 头部控制器 - 显示页面
     */
    public function header(){
        $this->fetch();
    }

    /**
     * 底部控制器 - 显示页面
     */
    public function footer(){
        $this->fetch();
    }
}