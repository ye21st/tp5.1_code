<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/17
 * Time: 14:10
 */

namespace app\index\controller;

/**
 * 返回码
 * Class ResultCode
 * @package app\index\controller
 */
class ResultCode
{
    static public $LOGIN_SUCCESS = 1000;      //  登录成功
    static public $USER_DOES_NOT_EXIST = 1001;      //  用户名不存在
    static public $PASSWORD_ERROR = 1002;      //  密码错误
}