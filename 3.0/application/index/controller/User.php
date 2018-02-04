<?php
namespace app\index\controller;
use app\index\model\User as UserModel;
use think\facade\Request;

/**
 * 用户控制器 API接口的开发
 * Class User
 * @package app\index\controller
 */
class User extends Common
{
    /**
     * 查询用户列表
     * @return $this
     * @throws \think\exception\DbException
     */
    public function lst()
    {
        //  如果请求是POST的话
        if ( $this->request -> isPost() ){
            //  实例化模型类
            $user = new UserModel();
            //  调用模型的查看用户列表的方法
            $list = $user -> getUsers();
            //  如果查到有数据
            if ( count($list) != 0 ){
                $data = [
                    'code'  =>  200,
                    'msg'   =>  '操作成功！',
                    'data'  =>  $list
                ];
                return json()->data($data);
            }else{  //  如果数组的元素为0，那么就可以判断数组为空
                $data = [
                    'code'  =>  201,
                    'msg'   =>  '数据为空，无法找到数据',
                    'data'  => []
                ];
                return json()->data($data);
            }
        }else{
            //  如果不是POST方式请求数据，就会返回 服务器异常的json对象
            $data = [
                'code'  =>  500,
                'msg'   =>  '服务器异常',
                'data'  =>  []
            ];
            return json()->data($data);
        }
    }

    /**
     * 用户添加成功
     * @return $this
     */
    public function add(){
        //  如果是POST提交过来的数据
        if ($this->request->isPost()){
            //  接收提交的数据（我们这里提交的数据很少，只有 用户名和密码 ）
            $username = Request::param('username');
            $password = Request::param('password');
            $salt = getSalt();

            $param = [
                'username' => $username,
                'password' => md5($password),
                'salt' => $salt
            ];

            $user = new UserModel();
            $result =$user -> addUser($param);

            if ( $result ){
                $data = [
                    'code'  =>  200,
                    'msg'   =>  '操作成功',
                    'data'  =>  []
                ];
                return json() -> data($data);
            }
        }else{
            //  如果不是POST方式请求数据，就会返回 服务器异常的json对象
            $data = [
                'code'  =>  500,
                'msg'   =>  '服务器异常',
                'data'  =>  []
            ];
            return json()->data($data);
        }
    }

    /**
     * 查找单个用户
     * @return $this
     * @throws \think\exception\DbException
     */
    public function findOne(){
        if ($this->request->isPost()){
            $id = Request::param('id');
            $user = new UserModel();
            $result = $user -> findOne($id);

            $datas = [
                'id'        =>  $result -> id,
                'username'  =>  $result -> username
            ];

            if ( $result ){
                $data = [
                    'code'  =>  200,
                    'msg'   =>  '操作成功',
                    'data'  =>  $datas
                ];
                return json() -> data($data);
            }

        }else{
            //  如果不是POST方式请求数据，就会返回 服务器异常的json对象
            $data = [
                'code'  =>  500,
                'msg'   =>  '服务器异常',
                'data'  =>  []
            ];
            return json()->data($data);
        }
    }

    /**
     * 修改用户信息
     * @return $this
     */
    public function edit(){
        if ($this->request->isPost()){
            $id = Request::param('id');
            $username = Request::param('username');
            $password = Request::param('password');

            if ( $password == null || $password == "" ){
                $datas = [
                    'username'  => $username
                ];
            }else{
                $datas = [
                    'username'  => $username,
                    'password'  => md5($password)
                ];
            }

            $user = new UserModel();
            $result = $user -> edit($id,$datas);

            if ( $result ){
                $data = [
                    'code'  =>  200,
                    'msg'   =>  '操作成功',
                    'data'  =>  []
                ];
                return json()->data($data);
            }else{
                $data = [
                    'code'  =>  201,
                    'msg'   =>  '用户信息添加失败',
                    'data'  =>  []
                ];
                return json()->data($data);
            }
        }else{
            //  如果不是POST方式请求数据，就会返回 服务器异常的json对象
            $data = [
                'code'  =>  500,
                'msg'   =>  '服务器异常',
                'data'  =>  []
            ];
            return json()->data($data);
        }
    }

    /**
     * 删除操作
     * @return $this
     * @throws \think\exception\DbException
     */
    public function del(){
        if ($this->request->isPost()){
            $id = Request::param('id');

            $user = new UserModel();
            $result = $user -> del($id);

            if ( $result ){
                $data = [
                    'code'  =>  200,
                    'msg'   =>  '操作成功',
                    'data'  =>  []
                ];
                return json()->data($data);
            }else{
                $data = [
                    'code'  =>  201,
                    'msg'   =>  '删除失败',
                    'data'  =>  []
                ];
                return json()->data($data);
            }
        }else{
            //  如果不是POST方式请求数据，就会返回 服务器异常的json对象
            $data = [
                'code'  =>  500,
                'msg'   =>  '服务器异常',
                'data'  =>  []
            ];
            return json()->data($data);
        }
    }
}
