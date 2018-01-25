<?php
/**
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/17
 * Time: 10:30
 */
namespace app\index\model;
use app\index\controller\ResultCode;
use think\Model;
use think\facade\Session;

/**
 * User 模型类
 * Class User
 * @package app\index\model
 */
class User extends Model
{
    /**
     * 登录操作
     * @param $username     $string 用户名
     * @param $password     $password 密码
     * @return int          $code 返回码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($username,$password){
        $userData = User::where('username','eq',$username) ->find();

        //  如果查找到数据
        if ( $userData ){
            //  获取该用户信息对应的盐值
            $salt = $userData['salt'];
            //  将密码进行 MD5 加密，将其与数据库中的密码字符串作对比，看看匹不匹配
            $newPassword = md5($password.$salt);
            if ( $userData['password'] == $newPassword ){
                //  获得用户所在ID
                $id = $userData['id'];
                //  设置session，用于首页访问，不存在，则返回到登录页面
                Session::set('id',$id);
                Session::set('name',$username);
                return ResultCode::$LOGIN_SUCCESS;
            }else{
                return ResultCode::$PASSWORD_ERROR;    //  密码错误
            }
        }else{
            return ResultCode::$USER_DOES_NOT_EXIST;    //  该用户不存在
        }
    }
}