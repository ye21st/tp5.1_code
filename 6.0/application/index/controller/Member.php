<?php
/**
 * Created by PhpStorm.
 * Member: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/2/9
 * Time: 12:01
 */

namespace app\index\controller;

use app\index\model\Member as MemberModel;
use think\Controller;
use think\facade\Request;

/**
 * 会员 控制器
 * Class Member
 * @package app\index\controller
 */
class Member extends Controller
{
    /**
     * 在列表上显示数据
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lst(){
        $list = new MemberModel();
        $result = $list -> lst();
        $this->assign('list',$result);
        return $this->fetch();
    }

    /**
     * 会员添加操作
     * @return mixed
     */
    public function add(){
        if ( $this->request->isPost() ){

            $username = Request::post('username');
            $password = Request::post('password');

            $data = [
                'username' => $username,
                'password' => md5($password)
            ];

            $validate = new \app\index\validate\Member();

            //  验证器验证
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            $member = new MemberModel();
            $result = $member -> add($data);
            if ($result){
                $this->success('添加会员成功!','index/Member/lst');
            }else{
                $this->error('添加会员失败!');
            }
        }
        return $this->fetch();
    }
}