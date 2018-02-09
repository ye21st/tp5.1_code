<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/2/9
 * Time: 17:17
 */

namespace app\index\validate;

use think\Validate;

class Member extends Validate
{
    protected $rule =   [
        'username'  => 'require|unique:member',
        'password' => 'require',
    ];

    protected $message  =   [
        'username.require' => '用户名必须填写！',
        'username.unique'     => '用户名已经存在！',
        'password.require'   => '密码必须填写!',
    ];
}