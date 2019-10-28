<?php

namespace app\admin\controller;
use think\Controller;
use think\Db;
class Students extends Controller
{
    public function  studentslist(){
        $code=input('post.code');
        if($code){

//            $where['cname'] = array('like','%'.$cname.'%');//封装模糊查询 赋值到数组

//$where['_logic']='OR';如果查询条件是OR的关系请打开，一般都是AND关系。
//            $test = M('table')->where($where)->select();
            $data=Db('students')
                ->alias('s')
                ->field('s.sid,s.cid,s.code,s.name,s.password,c.cname')
                ->join('classes c','s.cid = c.cid')
                ->where('code',$code)->paginate(50);
        }else{
            $data=Db('students')
                ->alias('s')
                ->field('s.sid,s.cid,s.code,s.name,s.password,c.cname')
                ->join('classes c','s.cid = c.cid')
                ->paginate(50);
            //  dump($data);
        }
        $dataall=Db('students')->select();
        $count = count($dataall);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    public  function  studentsadd(){
        $students = new \app\admin\model\Students();
        $data = input('post.');
        if(!empty($data)){
            $rs = $students->save($data);
            dump($rs);
            if($rs){
                $this->success('添加成功','students/studentslist');
            }else{
                $this->error('添加失败');
            }
        }else{
            $data = Db::name('classes')->select();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public function studentsedit($sid){
        $students = new \app\admin\model\Students();
        $data = input('post.');
        if(!empty($data)){
            $rs =$students->where('sid',$data['sid'])->find()->save($data);
            if($rs){
                $this->success('修改成功','students/studentslist');
            }else{
                dump($rs);
                $this->error('修改失败');
            }
        }else{
            $data=Db('students')
                ->alias('s')
                ->field('s.sid,s.cid,s.code,s.name,s.password,c.cname')
                ->join('classes c','s.cid = c.cid')
                ->where('sid',$sid)->find();
            $this->assign('data',$data);
            $classes = Db::name('classes')->select();
            $this->assign('classes',$classes);
            return $this->fetch();
        }
    }

    public  function  del($sid){
        $data = model('students')->where('sid',$sid)->find()->delete();
        if($data){
            $this->success('删除成功','students/studentslist');
        }else{
            $this->error('删除失败');
        }
    }
    //批量删除
    public function  delall()
    {
        $str = input ('str');
        $id = explode ('&', $str);//将字符串转化为数组
        $data = Db::name('students')->delete($id);
        if ($data != "") {
            $ret = [
                'code' => 200,
                'data' => $data,
                'msg' => '删除成功'
            ];
            return json($ret);
        } else {
            $ret = [
                'code' => 202,
                'data' => $data,
                'msg' => '删除失败'
            ];
            return json($ret);
        }
    }
    //导入学生表信息
    public function studentsupload()
    {
        if (request()->isPost()) {

            import('phpexcel.PHPExcel', EXTEND_PATH);//方法二
//            vendor("PHPExcel.PHPExcel"); //方法一
            $objPHPExcel = new \PHPExcel();

            //获取表单上传文件
            $file = request()->file('excel');
            $info = $file->validate(['maxsize'=>15678,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');
            if($info){
                $exclePath = $info->getSaveName();  //获取文件名
                $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;   //上传文件的地址
                $objReader =\PHPExcel_IOFactory::createReader('Excel5');
                $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
                echo "<pre>";
                $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
                array_shift($excel_array);  //删除第一个数组(标题);
                $data = [];
                $i=0;
                foreach($excel_array as $k=>$v) {
                    $data[$k]['cid'] = $v[0];
                    $data[$k]['code'] = $v[1];
                    $data[$k]['password'] = $v[2];
                    $data[$k]['name'] = $v[3];
                    $i++;
                }
//                dump($data);
                $success=Db::name('students')->insertAll($data); //批量插入数据
                //$i=
                $error=$i-$success;
                echo "总{$i}条，成功{$success}条，失败{$error}条。";
                $this->success('导入成功','students/studentslist');
                // Db::name('t_station')->insertAll($city); //批量插入数据
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }else{
            return $this->fetch();
        }
    }
    //ajax学生登录
    public function ajaxStudentLogin(){
        $code = input('post.code');
        $password = input('post.password');
        $data = Db::name('students')->where("code" , $code)->field('code,password,name,cid')->find();
        if($data!=""){
            if($data['password']== $password ){
                $ret =[
                    'code' => 200,
                    'data' => $data,
                    'msg' => '登录成功'
                ];
                return json($ret);
            }
        }else{
            $ret =[
                'code' => 202,
                'data' => $data,
                'msg' => '登录失败'
            ];
            return json($ret);
        }
    }

    //测试   获取班级学生和签到成功学生
    public function ajaxGetAll(){
        $cid = input('post.cid');
        $creattime = input('post.creattime');
        $starttime = input('post.starttime');
        $data = Db::name('students')->where("cid" , $cid)->field('code,name,status')->select();


        $siginlist = Db::name('statistics')
            ->where("creattime", $creattime)
            ->where("starttime",$starttime)
            ->where("cid",$cid)
            ->select();
//        $data = array_merge($studentlist,$siginlist);
        if($data!=""){
            $ret =[
                'code' => 200,
                'data' => $data,
                'siginlist' => $siginlist,
                'msg' => '获取成功'
            ];
            return json($ret);
        }else{
            $ret =[
                'code' => 202,
                'data' => $data,
                'siginlist' => $siginlist,
                'msg' => '获取失败'
            ];
            return json($ret);
        }
    }
    //学生签到
    public function ajaxSaveStatistics(){
        $data = input('post.');
        $rs = Db::name('statistics')->insert($data);
        if($rs!=""){
            $ret =[
                'code' => 200,
                'data' => $data,
                'msg' => '签到成功'
            ];
            return json($ret);
        }else{
            $ret =[
                'code' => 202,
                'data' => $data,
                'msg' => '签到失败'
            ];
            return json($ret);
        }
    }
    //教师手动更新学生状态
    public function ajaxSetStatus(){
        $scode = input('post.scode');
        $status = input('post.status');
        $creattime = input('post.creattime');
        $starttime=input('post.starttime');
        $data = Db::name('statistics')
            ->where("scode" , $scode)
            ->where("creattime",$creattime)
            ->where("starttime",$starttime)
            ->update(['status' => $status]);
        if($data!=""){
            $ret =[
                'code' => 200,
                'data' => $data,
                'msg' => '更新状态成功'
            ];
            return json($ret);
        }else{
            $ret =[
                'code' => 202,
                'data' => $data,
                'msg' => '更新状态失败'
            ];
            return json($ret);
        }
    }

    //判断重复签到
    public function ajaxGetStatus(){
        $cid = input('post.cid');
        $scode = input('post.scode');
        $status = input('post.status');
        $creattime = input('post.creattime');
        $starttime=input('post.starttime');
        $data = Db::name('statistics')
            ->where("cid" , $cid)
            ->where("scode" , $scode)
            ->where("creattime",$creattime)
            ->where("starttime",$starttime)
            ->where("status",$status)
            ->find();
        if($data!=""){
            $ret =[
                'code' => 200,
                'data' => $data,
                'msg' => '您已签到成功'
            ];
            return json($ret);
        }else{
            $ret =[
                'code' => 202,
                'data' => $data,
                'msg' => '签到失败'
            ];
            return json($ret);
        }
    }
}