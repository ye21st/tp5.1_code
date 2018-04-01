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
    /**
     * 首页圆滑折线图显示
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        //  定义空字符串
        $str = "";
        //  从数据中查询所有数据
        $res = Db::name('doc') -> select();
        //  循环数据，进行拼接
        foreach ( $res as $k => $v ) {
            $time = substr($v['time'],5,5);
            $str = $str . "{ time: '".$time."', pv:".$v['pv'].", uv: ".$v['uv']." , vv: ".$v['vv']." },";
        }
        //  处理拼接之后的数据
        $str = substr($str,0,strlen($str)-1);
        //  模板赋值
        $this->assign('data',$str);
        return $this->fetch();
    }
}
