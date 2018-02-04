<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/31
 * Time: 0:32
 */

namespace app\index\model;

use think\Model;

/**
 * 用户模型表
 * Class User
 * @package app\index\model
 */
class User extends Model
{
    /**
     * 查询用户信息
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public function getUsers(){
        $user = new User();
        $list = $user -> field('id,username') -> order('id desc') -> select();
        return $list;
    }

    /**
     * @param array $data 主要传过来 用户姓名、密码、随机生成的盐值
     * @return User
     */
    public function addUser($data){
        $result = User::create($data);
        return $result;
    }

    /**
     * 查询单个用户
     * @param integer $id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public function findOne($id){
        $result = User::get($id);
        return $result;
    }

    /**
     * 用户信息编辑
     * @param $id
     * @param $data
     * @return static
     */
    public function edit($id,$data){
        $result = User::where('id',$id) -> update($data);
        return $result;
    }

    /**
     * 删除操作
     * @param $id
     * @return int
     * @throws \think\exception\DbException
     */
    public function del($id){
        $result = User::get($id) -> delete();
        return $result;
    }
}