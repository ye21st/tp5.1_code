<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/3/1
 * Time: 10:10
 */

namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 * 文章控制器
 * Class Article
 * @package app\index\controller
 */
class Article extends Controller
{
    /**
     * 文章列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lst(){
        //  以创建时间排序，并以每页10条数据分页
        $list = Db::table('tp_article') -> order('create_time desc') -> paginate(10);
        //  模板赋值
        $this->assign('articleres',$list);
        return $this->fetch();
    }

    /**
     * 文章预览
     * @param $id integer 文章ID
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function info($id){
        //  通过文章ID查询数据
        $info = Db::table('tp_article') -> where('id',$id) -> find();
        //  模板赋值
        $this->assign('info',$info);
        return $this->fetch();
    }

    /**
     * 添加文章
     * @return mixed
     */
    public function add(){
        //  如果数据请求是POST方式的话
        if ( $this->request->isPost() ){
            //  获取POST提交过来的数据
            $title = $this->request->param('title');
            $author = $this->request->param('author');
            $content = $this->request->param('content');
            $content_html = $this->request->param('test-editormd-html-code');
            $sort = $this->request->param('sort');
            $date = new \DateTime();
            $create_time = $date -> format('Y-m-d H:i:s');

            //  将数据组装成数组
            $data = [
                'title' => $title,
                'author' => $author,
                'content' => $content,
                'content_html' => $content_html,
                'sort' => $sort,
                'create_time' => $create_time
            ];
            //  进行数据添加操作
            $result = Db::name('article') -> insert($data);
            if ( $result ){
                $this->success('文章添加成功!','index/article/lst');
            }else{
                $this->error('文章添加失败');
            }
        }
        return $this->fetch();
    }

    /**
     * 文章编辑操作
     * @param $id integer 文章ID
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit($id){
        //  通过文章ID查询数据
        $info = Db::table('tp_article') -> where('id',$id) -> find();
        //  模板赋值
        $this->assign('info',$info);

        //  如果数据请求是POST方式的话
        if ( $this->request->isPost() ){
            //  获取POST提交过来的数据
            $title = $this->request->param('title');
            $author = $this->request->param('author');
            $content = $this->request->param('content');
            $content_html = $this->request->param('test-editormd-html-code');
            $sort = $this->request->param('sort');
            $date = new \DateTime();
            $update_time = $date -> format('Y-m-d H:i:s');

            //  将数据组装成数组
            $data = [
                'title' => $title,
                'author' => $author,
                'content' => $content,
                'content_html' => $content_html,
                'sort' => $sort,
                'update_time' => $update_time
            ];
            //  进行数据修改操作
            $result = Db::name('article') -> where('id',$id) -> update($data);
            if ( $result ){
                $this->success('文章修改成功!','index/article/lst');
            }else{
                $this->error('文章修改失败');
            }
        }
        return $this->fetch();
    }

    /**
     * 文章删除操作
     * @param $id integer 文章ID
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del($id){
        //  通过文章ID删除数据
        $result = Db::table('tp_article') -> where('id',$id) -> delete();
        if ( $result ){
            $this->success('文章删除成功!','index/article/lst');
        }else{
            $this->error('文章删除失败');
        }
    }
}