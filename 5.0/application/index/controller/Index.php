<?php
namespace app\index\controller;

use app\index\model\User as UserModel ;
use think\Controller;

/**
 * 首页控制器
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    /**
     * 显示首页
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $user = new UserModel();
        $list = $user -> lst();
        $this->assign('list',$list);
        return $this->fetch();
    }
}
