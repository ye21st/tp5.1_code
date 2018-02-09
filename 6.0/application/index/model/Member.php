<?php
/**
 * Created by PhpStorm.
 * Member: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/2/8
 * Time: 15:54
 */

namespace app\index\model;

use think\Model;

/**
 * 会员模型类
 * Class Member
 * @package app\index\model
 */
class Member extends Model
{
    /**
     * 查询会员列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function lst(){
        //  设置每页只显示10条数据
        $list = Member::paginate(10);
        return $list;
    }

    /**
     * 会员添加操作
     * @param $data string 接收表单传过来的数据
     * @return static
     */
    public function add($data){
        $result =  Member::create($data);
        return $result;
    }
}