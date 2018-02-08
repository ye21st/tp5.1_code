<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/2/8
 * Time: 15:54
 */

namespace app\index\model;

use think\Model;

/**
 * 用户 模型类
 * Class User
 * @package app\index\model
 */
class User extends Model
{
    /**
     * 查询用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function lst(){
        //  设置每页只显示10条数据
        $list = User::paginate(10);
        return $list;
    }
}