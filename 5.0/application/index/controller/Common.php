<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/2/5
 * Time: 0:27
 */

namespace app\index\controller;

use think\Controller;

/**
 * 公共部分页面 控制器
 * Class Common
 * @package app\index\controller
 */
class Common extends Controller
{
    /**
     * 引用公共头
     * @return mixed
     */
    public function header(){
        return $this->fetch();
    }

    /**
     * 引用底部
     * @return mixed
     */
    public function footer(){
        return $this->fetch();
    }
}