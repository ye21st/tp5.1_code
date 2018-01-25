<?php
namespace app\index\controller;

/**
 * Index 控制器
 * Class Index
 * @package app\index\controller
 */
class Index extends Common
{
    /**
     * 登录首页
     * @return mixed
     */
    public function index()
    {
        $this->assign('name', 'thinkphp');
        return $this->fetch();
    }
}
