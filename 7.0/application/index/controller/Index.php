<?php
namespace app\index\controller;

use think\Controller;

/**
 * 首页控制器
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
