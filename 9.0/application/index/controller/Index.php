<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 * 首页控制器
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        //  查询出来 pv uv vv的总数
        //  页面浏览量
        $pv = Db::name('doc') -> sum('pv');
        //  单独用户浏览量
        $uv = Db::name('doc') -> sum('uv');
        //  页面成功加载
        $vv = Db::name('doc') -> sum('vv');

        //  因为数量较少，我就直接通过拼接拿到数据，数据多的话，建议循环拼接。
        $str = "{value:".$pv.",name:'页面浏览量'},"."{value:".$uv.",name:'单独用户浏览量'},"."{value:".$vv.",name:'页面成功加载'}";
        //  模板赋值
        $this->assign('docRes',$str);
        return $this->fetch();
    }
}
