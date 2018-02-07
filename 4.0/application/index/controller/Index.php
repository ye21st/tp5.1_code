<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Request;

/**
 * 首页控制器
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        if ( $this-> request -> isPost() ){
            $ip = Request::param('ip');

            $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;

            $info = self::curl_get($url);

            //  为 true 的时候，返回的是数组而不是对象
            $datas = json_decode($info,true);
            $data = $datas['data'];
            $this->assign('ip',$ip);
            $this->assign('list',$data);
        }
        return $this->fetch();
    }

    /**
     * 通过CURL 方式调用接口
     * @param $url
     * @return mixed
     */
    public static function curl_get($url){
        $testurl = $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $testurl);
        //参数为1表示传输数据，为0表示直接输出显示。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //参数为0表示不带头文件，为1表示带头文件
        curl_setopt($ch, CURLOPT_HEADER,0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
