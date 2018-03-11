<?php
namespace app\index\controller;

use think\Controller;

/**
 * Ê×Ò³¿ØÖÆÆ÷
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
