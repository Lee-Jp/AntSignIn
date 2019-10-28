<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/1
 * Time: 20:11
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Model;
use think\Session;

class Statistics extends Controller
{
    public function  statisticslist(){
        $classes = Db::name('classes')->select();
        $this->assign('classes',$classes);
        $subject = Db::name('subject')->select();
        $this->assign('subject',$subject);
        $subname=input('post.subname');
        $cname = input('post.cname');
        $creattimestart = input('post.creattimestart');
        $creattimeend = input('post.creattimeend');
        $daochu = input('post.daochu');
//        dump($daochu);
        if($subname && $cname && $creattimestart && $creattimeend){
            $data = Db::name('statistics')
                ->where("cname" , $cname)
                ->where("creattime",'between time', [$creattimestart, $creattimeend])
                ->where("subname",$subname)
                ->paginate(100);
            if($daochu){
                $this->excelout($data);
            }
        }else{
            $data = Db::name('statistics')->paginate(100);
        }
        $count = count($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    //获取当前老师学生的数据
    public function  statisticstealist(){
        $tea_id = Session::get('tea_id');
        $classes = Db::name('classes')->select();
        $this->assign('classes',$classes);
        $subject = Db::name('subject')->select();
        $this->assign('subject',$subject);
        $subname=input('post.subname');
        $cname = input('post.cname');
        $creattimestart = input('post.creattimestart');
        $creattimeend = input('post.creattimeend');
        $daochu = input('post.daochu');
        if($subname && $cname && $creattimestart && $creattimeend){
            $data = Db::name('statistics')
                ->where("cname" , $cname)
                ->where("creattime",'between time', [$creattimestart, $creattimeend])
                ->where("subname",$subname)
                ->where('tea_id',$tea_id)
                ->paginate(100);
            if($daochu){
                $this->excelout($data);
            }
        }else{
            $data = Db::name('statistics')->where('tea_id',$tea_id)
                ->paginate(100);
        }
        $count = count($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    //获取当前老师echart
    public function  statisticsteaecharts(){
        return $this->fetch();
    }
    //获取admin echart
    public function  statisticsadminecharts(){
        return $this->fetch();
    }
    public  function  statisticsadd(){
        $data = input('post.');
        if(!empty($data)){
            $rs = Db::name('statistics')->insert($data);
            if($rs){
                $this->success('添加成功','statistics/statisticslist');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function statisticsedit($id){
        $data = input('post.');
        dump($data);
        if(!empty($data)){
            $rs =Db::name('statistics')->where('id',$data['id'])->update($data);
            if($rs){
                $this->success('修改成功','statistics/statisticslist');
            }else{
                dump($rs);
                $this->error('修改失败');
            }
        }else{
            $data  = Db::name('statistics')->where('id',$id)->find();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public function del($id){
        $data = Db::name('statistics')->where('id',$id)->delete();
        if($data){
            $this->success('删除成功','statistics/statisticslist');
        }else{
            $this->error('删除失败');

        }
    }
    //批量删除
    public function  delall()
    {
        $str = input ('str');
        $cid = explode ('&', $str);//将字符串转化为数组
        $data = Db::name('statistics')->delete($cid);
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
    //admin导出
    public function exceloutadmin(){
        $data = db('statistics')->select();
        $this->excelout($data);
    }
    //teacher导出
    public function excelouttea(){
        $tea_id = Session::get('tea_id');
        $data = Db::name('statistics')->where('tea_id',$tea_id)->select();
        $this->excelout($data);
    }
    public function excelout($data){
        import('phpexcel.PHPExcel', EXTEND_PATH);//方法二
        import('phpexcel.Writer.Excel5', EXTEND_PATH);//方法二
        import('phpexcel.Writer.Excel2007', EXTEND_PATH);//方法二
        import('phpexcel.PHPExcel.IOFactory', EXTEND_PATH);//方法二
        $objPHPExcel = new \PHPExcel();
        $sql = $data;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID编号')
            ->setCellValue('B1', '教室')
            ->setCellValue('C1', '星期')
            ->setCellValue('D1', '开始时间')
            ->setCellValue('E1', '结束时间')
            ->setCellValue('F1', '班级')
            ->setCellValue('G1', '课程名称')
            ->setCellValue('H1', 'cid')
            ->setCellValue('I1', '学号')
            ->setCellValue('j1', '学生姓名')
            ->setCellValue('K1', '插入时间')
            ->setCellValue('L1', '状态')
            ->setCellValue('M1', 'tea_id');


        /*--------------开始从数据库提取信息插入Excel表中------------------*/


        $i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
        $count = count($sql);  //计算有多少条数据
        for ($i = 2; $i <= $count+1; $i++) {
            if($sql[$i - 2]['status']=='1'){
                $sql[$i - 2]['status']='已签到';
            }else if($sql[$i - 2]['status']=='2'){
                $sql[$i - 2]['status']='迟到';
            }else if($sql[$i - 2]['status']=='3'){
                $sql[$i - 2]['status']='旷课';
            }else if($sql[$i - 2]['status']=='4'){
                $sql[$i - 2]['status']='请假';
            }else if($sql[$i - 2]['status']=='0'){
                $sql[$i - 2]['status']='未操作';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['classroom']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['week']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['starttime']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['endtime']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['cname']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i - 2]['subname']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sql[$i - 2]['cid']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sql[$i - 2]['scode']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sql[$i - 2]['sname']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sql[$i - 2]['creattime']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $sql[$i - 2]['status']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $sql[$i - 2]['tea_id']);
        }

        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->setTitle('sheet1');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
//        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="数据统计.xls"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $objWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
    //ajax接口添加签到数据
    public function ajaxSaveStatistics(){
        $data = input('post.');
        $arr = array();
        for($i=0;$i<count($data['students']);$i++){
            $arr[]=[
                "classroom"=>$data['students'][$i]['classroom'],
                "week"=>$data['students'][$i]['week'],
                "starttime"=>$data['students'][$i]['starttime'],
                "endtime"=>$data['students'][$i]['endtime'],
                "cname"=>$data['students'][$i]['cname'],
                "subname"=>$data['students'][$i]['subname'],
                "scode"=>$data['students'][$i]['scode'],
                "sname"=>$data['students'][$i]['sname'],
                "creattime"=>$data['students'][$i]['creattime'],
                "status"=>$data['students'][$i]['status'],
            ];
        }
        $rs = Db::name('statistics')->insertAll($arr);
        if ($rs) {
            $ret = [
                'code' => 200,
                'msg' => 'success',
                'data' => $data
            ];
            return json($ret);
        }else{
            $ret = [
                'code' => 202,
                'msg' => 'error',
                'data' => $data
            ];
            return json($ret);
        }
    }

    //教师查询签到数据  ajax
    public function teacherGetStatistics(){
        $tea_id = Session::get('tea_id');
        $subname=input('post.subname');
        $cname = input('post.cname');
        $creattimestart = input('post.creattimestart');
        $creattimeend = input('post.creattimeend');
        if(!empty($creattimeend)){   //传入了结束时间
            $data = Db::name('statistics')
                ->where("tea_id",$tea_id)
                ->where("cname" , $cname)
                ->where("creattime",'between time', [$creattimestart, $creattimeend])
                ->where("subname",$subname)
                ->select();
            $qiandao = Db::name('statistics')
                ->where("tea_id",$tea_id)
                ->where("cname" , $cname)
                ->where("creattime",'between time', [$creattimestart, $creattimeend])
                ->where("subname",$subname)
                ->field("sname,scode,count(sname) as num,
                            count(case when status=1 then 1 end) num1,
                            count(case when status=2 then 1 end) num2,
                            count(case when status=3 then 1 end) num3,
                            count(case when status=4 then 1 end) num4")
                ->where("status",'>=','1')
                ->group('scode')
                ->select();
            if($data!=""){
                $ret =[
                    'code' => 200,
                    'data' => $qiandao,
                    'msg' => '查询成功'
                ];
                return json($ret);
            }else{
                $ret =[
                    'code' => 202,
                    'data' => $qiandao,
                    'msg' => '查询失败'
                ];
                return json($ret);
            }
        }else{    //没有传入结束时间
            $data = Db::name('statistics')
                ->where("tea_id",$tea_id)
                ->where("cname" , $cname)
                ->where("creattime",$creattimestart)
                ->where("subname",$subname)
                ->field("sname,scode,count(sname) as num,
                            count(case when status=1 then 1 end) num1,
                            count(case when status=2 then 1 end) num2,
                            count(case when status=3 then 1 end) num3,
                            count(case when status=4 then 1 end) num4")
                ->where("status",'>=','1')
                ->group('scode')
                ->select();
//            dump($data);
            if($data!=""){
                $ret =[
                    'code' => 200,
                    'data' => $data,
                    'msg' => '查询成功'
                ];
                return json($ret);
            }else{
                $ret =[
                    'code' => 202,
                    'data' => $data,
                    'msg' => '查询失败'
                ];
                return json($ret);
            }
        }
    }

    //admin查询签到数据  ajax
    public function adminGetStatistics(){
        $subname=input('post.subname');
        $cname = input('post.cname');
        $creattimestart = input('post.creattimestart');
        $creattimeend = input('post.creattimeend');
        if(!empty($creattimeend)){   //传入了结束时间
            $data = Db::name('statistics')
                ->where("cname" , $cname)
                ->where("creattime",'between time', [$creattimestart, $creattimeend])
                ->where("subname",$subname)
                ->select();
//            Db::query("SELECT ts.scode,ts.sname sname,count(ts.sname) as num,
//                            count(case when ts.status=1 then 1 end) num1,
//                            count(case when ts.status=2 then 1 end) num2,
//                            count(case when ts.status=3 then 1 end) num3,
//                            count(case when ts.status=4 then 1 end) num4
//                            FROM `tp_statistics` ts WHERE 1 group by ts.scode
//                              ");
//            dump($data);
            $qiandao = Db::name('statistics')
                ->where("cname" , $cname)
                ->where("creattime",'between time', [$creattimestart, $creattimeend])
                ->where("subname",$subname)
                ->field("sname,scode,count(sname) as num,
                            count(case when status=1 then 1 end) num1,
                            count(case when status=2 then 1 end) num2,
                            count(case when status=3 then 1 end) num3,
                            count(case when status=4 then 1 end) num4")
                ->where("status",'>=','1')
                ->group('scode')
                ->select();
//            dump($qiandao);
            if($data!=""){
                $ret =[
                    'code' => 200,
                    'data' => $qiandao,
                    'msg' => '查询成功'
                ];
                return json($ret);
            }else{
                $ret =[
                    'code' => 202,
                    'data' => $qiandao,
                    'msg' => '查询失败'
                ];
                return json($ret);
            }
        }else{    //没有传入结束时间
            $data = Db::name('statistics')
                ->where("cname" , $cname)
                ->where("creattime",$creattimestart)
                ->where("subname",$subname)
                ->field("sname,scode,count(sname) as num,
                            count(case when status=1 then 1 end) num1,
                            count(case when status=2 then 1 end) num2,
                            count(case when status=3 then 1 end) num3,
                            count(case when status=4 then 1 end) num4")
                ->where("status",'>=','1')
                ->group('scode')
                ->select();
//            dump($data);
            if($data!=""){
                $ret =[
                    'code' => 200,
                    'data' => $data,
                    'msg' => '查询成功'
                ];
                return json($ret);
            }else{
                $ret =[
                    'code' => 202,
                    'data' => $data,
                    'msg' => '查询失败'
                ];
                return json($ret);
            }
        }
    }
    //学生获取自己的签到信息
    public function studentGetStatistics(){
        $scode = input('post.scode');
        $data = Db::name('statistics')
            ->where('scode',$scode)
            ->field("sname,scode,count(sname) as num,
                            count(case when status=1 then 1 end) num1,
                            count(case when status=2 then 1 end) num2,
                            count(case when status=3 then 1 end) num3,
                            count(case when status=4 then 1 end) num4")
            ->where("status",'>=','1')
            ->group('scode')
            ->select();
        if(!empty($data)){
            $ret =[
                'code' => 200,
                'data' => $data,
                'msg' => '查询成功'
            ];
            return json($ret);
        }else{
            $ret =[
                'code' => 202,
                'data' => $data,
                'msg' => '查询失败'
            ];
            return json($ret);
        }
    }
}