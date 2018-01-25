<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/19
 * Time: 11:52
 */

namespace app\index\controller;

use app\index\model\User as UserModel;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Request;
use think\facade\Session;

/**
 * 登录控制器
 * Class Login
 * @package app\index\controller
 */
class Login extends Controller
{
    /**
     * 登录操作
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        //  判断请求是否是 POST 请求
        if ( Request::isPost() ){
            //  获取用户登录时候的用户名、密码、验证码
            $username = $this -> request -> param('username');
            $password = $this -> request -> param('password');
            $code = $this -> request -> param('code');

            // 检测输入的验证码是否正确，$code 为用户输入的验证码字符串
            $captcha = new Captcha();
            if( !$captcha->check($code))
            {
                $this->error('验证码错误!');
            }

            $index = new UserModel();
            $result = $index -> login($username,$password);

            /**
             * 通过获得的条件去进行不同的操作
             */
            switch ($result){
                case ResultCode::$LOGIN_SUCCESS:
                    $this -> success('用户登录成功！',url('index/index/index'));
                    break;

                case ResultCode::$USER_DOES_NOT_EXIST:
                    $this->error('用户名不存在！');
                    break;

                case ResultCode::$PASSWORD_ERROR:
                    $this->error('密码错误，请确认后再次输入！');
                    break;
            }
        }
        return $this->fetch();
    }

    /**
     * 生成验证码
     * @return \think\Response
     */
    public function verify()
    {
        //  验证码配置
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    20,
            // 验证码位数
            'length'      =>    4,
            // 宽度
            'imageW'      =>    360,
            //  高度
            'imageH'      =>    60,
            // 关闭验证码杂点
            'useNoise'    =>    false,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    /**
     * 安全退出
     */
    public function logout(){
        Session::pull('id');
        Session::pull('name');
        $this->redirect('index/login/index');
    }
}