<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/1/23
 * Time: 16:33
 */

namespace app\index\controller;

use think\Controller;
use app\index\model\Cate as CateModel;
use think\facade\Request;

/**
 * 栏目控制器
 * Class Cate
 * @package app\index\controller
 */
class Cate extends Controller
{
    /**
     * 控制器的前置操作
     * @var array
     */
    protected $beforeActionList = [
        'delsoncate' => ['only' => 'del'],
    ];

    /**
     * 栏目列表页面显示数据 - 以及，排序功能的写法
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lst()
    {
        //  实例化模型
        $cate = new CateModel();
        //  判断是否是POST提交数据
        if ($this->request->isPost()) {
            //  获取post提交过来的数据
            $sorts = Request::post();
            //  通过ID循环更新排序的值
            foreach ($sorts as $k => $v) {
                $cate->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功！', url('index/cate/lst'));
            return;
        }
        //  调用模型的 catetree 拿到数据
        $cateres = $cate->catetree();
        //  对页面进行赋值
        $this->assign('cateres', $cateres);
        return $this->fetch();
    }


    public function add()
    {
        //  实例化模型
        $cate = new CateModel();
        //  判断是否是POST提交数据
        if ($this->request->isPost()) {
            //  获得post提交过来的数据
            $data = Request::post();
            //  实例化验证器
            $validate = new \app\index\validate\Cate;
            //  验证器验证
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            //  数据添加 返回 1 或者 0
            $add = $cate->save($data);
            if ($add) {
                $this->success('添加栏目成功！', url('index/cate/lst'));
            } else {
                $this->error('添加栏目失败！');
            }
        }
        //  调用模型的 catetree 拿到数据
        $cateres = $cate->catetree();
        //  对页面进行赋值
        $this->assign('cateres', $cateres);
        return $this->fetch();
    }


    public function edit()
    {
        //  实例化模型
        $cate = new CateModel();
        //  判断是否是post提交的数据
        if ($this->request->isPost()) {
            //  获取POST提交的数据
            $data = Request::post();
            //  实例化验证器
            $validate = new \app\index\validate\Cate;
            //  通过验证器去判断数据是否合法
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
            }
            //  通过ID修改相应的数据
            $save = $cate->save($data, ['id' => $data['id']]);
            if ($save !== false) {
                $this->success('修改栏目成功！', url('index/cate/lst'));
            } else {
                $this->error('修改栏目失败！');
            }
            return;
        }
        $cates = $cate -> find(Request::param('id'));
        //  调用自定义模型里面的树方法
        $cateres = $cate->catetree();
        //  模板赋值
        $this->assign(array(
            'cateres' => $cateres,
            'cates' => $cates,
        ));
        return $this->fetch();
    }

    /**
     * 栏目删除操作
     * @throws \think\exception\DbException
     */
    public function del()
    {
        //  通过ID去进行数据的删除
        $del = CateModel::get(Request::param('id'));
        if ($del) {
            $this->success('删除栏目成功！', url('index/cate/lst'));
        } else {
            $this->error('删除栏目失败！');
        }
    }

    /**
     * 通过要删除的栏目ID，去循环查出，该栏目下面的子目录，全部删除。
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function delsoncate()
    {
        //  要删除的当前栏目的id
        $cateid = Request::param('id');
        //  实例化模型
        $cate = new CateModel();
        //  调用模型里面的调用子栏目方法
        $sonids = $cate->getchilrenid($cateid);
        //  获得全部的栏目ID
        $allcateid = $sonids;
        $allcateid[] = $cateid;
        if ($sonids) {
            $cate->delete($sonids);
        }
    }
}