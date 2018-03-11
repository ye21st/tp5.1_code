<?php
/**
 * Created by PhpStorm.
 * User: ye21st
 * Email: ye21st@gmail.com
 * Date: 2018/3/1
 * Time: 10:10
 */

namespace app\index\controller;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Excel5;
use PHPExcel_Shared_Date;
use PHPExcel_Style_Alignment;
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

    /**
     * 表格数据导入操作
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function import(){
        //  如果是 POST请求方式提交数据
        if( $this -> request -> isPost() ){
            $file = request()->file('file');
            // 移动到框架根目录 /uploads/ 目录下
            $info = $file->move('../uploads');
            if($info){
                //  获取文件所在目录名
                $path = '../uploads/'.$info->getSaveName() ;
                //  实例化PHPExcel_IOFactory类（注意：实例化的时候前面需要加'\'）
                $objReader = \PHPExcel_IOFactory::createReaderForFile($path);
                //  获取excel文件
                $objPHPExcel = $objReader->load($path,$encode='utf-8');
                //  激活当前的表
                $sheet = $objPHPExcel->getSheet(0);
                //  取得总行数
                $highestRow = $sheet->getHighestRow();
                // 取得总列数
                $highestColumn = $sheet->getHighestColumn();
                $a = 0;
                //将表格里面的数据循环到数组中
                for($i=2;$i<=$highestRow;$i++)
                {
                    /**
                     *  为什么$i=2?
                     *  因为Excel表格第一行应该是
                     *  文章标题
                     *  作者
                     *  文章内容
                     *  markdown的HTML源码
                     *  排序
                     *  创建时间
                     *  更新时间
                     */
                    // ( 文章标题，作者，文章内容，文章内容，文章内容，文章内容，从第二行开始，才是我们要的数据。)
                    $data[$a]['title'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                    $data[$a]['author'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
                    $data[$a]['content'] = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                    $data[$a]['content_html'] = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                    $data[$a]['sort'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                    $create_time = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                    $data[$a]['create_time'] = gmdate("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($create_time));
                    $update_time = $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
                    $data[$a]['update_time'] = gmdate("Y-m-d H:i:s",PHPExcel_Shared_Date::ExcelToPHP($update_time));
                    // 这里的数据根据自己表格里面有多少个字段自行决定
                    $a++;
                }
                //往数据库添加数据
                $res = Db::name('article')->insertAll($data);
                if($res){
                    $this->success('导入成功！',url('index/Article/lst'));
                }else{
                    $this->error('导入失败！');
                }
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
    }

    /**
     * 导出操作
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function export(){
        //  从数据查找文章
        $articleres = Db::name('article') -> select();
        $indexKey = array('id','title','author','content','content_html','sort','create_time','update_time');
        $this->exportExcel($articleres,'文章数据导出',$indexKey);
    }

    /**
     * 导出通用方法
     * @param $list
     * @param $filename
     * @param array $indexKey
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    function exportExcel($list,$filename,$indexKey=array()){
        $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        //  初始化PHPExcel()
        $objPHPExcel = new \PHPExcel();

        //  设置保存版本格式
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        //  接下来就是写数据到表格里面去
        $objActSheet = $objPHPExcel -> getActiveSheet();
        //  设置当前活动sheet的名称
        $objActSheet->setTitle('文章导出数据');

        $i = 1;
        $j = 2;
        //  设置表头
        foreach ( $indexKey as $key => $value ){
            //  这个比较有用，能自适应列宽
            $objActSheet->getColumnDimension($header_arr[$key])->setAutoSize(true);
            $objStyleA5 = $objActSheet->getStyle($header_arr[$key]);
            //设置对齐方式
            $objAlignA5 = $objStyleA5->getAlignment();
            $objAlignA5->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objAlignA5->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objActSheet->setCellValue($header_arr[$key].$i,$value);
        }
        //  设置主要内容
        foreach ($list as $row) {
            foreach ($indexKey as $key => $value){
                //  这里是设置单元格的内容
                $objActSheet->setCellValue($header_arr[$key].$j,$row[$value]);
            }
            $j++;
        }

        // 下载这个表格，在浏览器输出就好了
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename="'.$filename.'.xlsx"');
        header("Content-Transfer-Encoding:binary");
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2010");
        $objWriter -> save('php://output');
    }
}