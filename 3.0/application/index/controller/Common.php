<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/2/4
 * Time: 18:40
 */

namespace app\index\controller;
//  这段代码很重要，这样才能允许页面访问接口，要不然会有跨域问题
header("Access-Control-Allow-Origin: *");
use think\Controller;

class Common extends Controller
{

}