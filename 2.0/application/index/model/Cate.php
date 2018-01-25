<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/23
 * Time: 16:50
 */

namespace app\index\model;

use think\Model;

/**
 * 栏目模型类
 * Class Cate
 * @package app\index\model
 */
class Cate extends Model
{
    /**
     * 模型的初始化方法，可以用来书写前置或后置方法
     */
    protected static function init()
    {
        Cate::event('before_delete',function(){
            return false;
        });
    }

    /**
     * 让栏目树 按照降序排序
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catetree(){
        $cateres=$this->order('sort desc')->select();
        return $this->sort($cateres);
    }

    /**
     * 排序方法
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }

    /**
     * 通过ID 获得子节点信息
     * @param $cateid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getchilrenid($cateid){
        $cateres=$this->select();
        return $this->_getchilrenid($cateres,$cateid);
    }

    /**
     * 递归方法
     * @param $cateres
     * @param $cateid
     * @return array
     */
    public function _getchilrenid($cateres,$cateid){
        static $arr=array();
        foreach ($cateres as $k => $v) {
            if($v['pid'] == $cateid){
                $arr[]=$v['id'];
                $this->_getchilrenid($cateres,$v['id']);
            }
        }

        return $arr;
    }

}