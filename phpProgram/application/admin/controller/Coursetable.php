<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/22
 * Time: 10:59
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Session;

class Coursetable extends Controller
{
    public function  coursetablelist(){
        $tea_id = Session::get('tea_id');
        $data=Db('coursetable')
            ->alias('c')
            ->field('c.couid,c.classroom,c.week,c.starttime,c.endtime,cla.cname,s.subname')
            ->join('classes cla','c.cla_id = cla.cid')
            ->join('subject s','c.sub_id = s.subid')
            ->where('tea_id',$tea_id)
            ->order('couid asc')
            ->paginate(15);
//        dump($data);
        $count = count($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    public  function  coursetableadd(){
        $data = input('post.');
        if(!empty($data)){
            $duibi = Db::name('coursetable')
//                ->where('sub_id',$data['sub_id'])
                ->where('cla_id',$data['cla_id'])
//                ->where('classroom',$data['classroom'])
                ->where('week',$data['week'])
                ->where('starttime',$data['starttime'])
//                ->where('endtime',$data['endtime'])
//                ->where('tea_id',$data['tea_id'])
                ->select();
            if(empty($duibi)){
                $rs = Db::name('coursetable')->insert($data);
                if($rs){
                    $this->success('添加成功','coursetable/coursetablelist');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error('当前时间该班级已有课程，请核对');
            }

        }else{
            $classes = Db::name('classes')->select();
            $this->assign('classes',$classes);
            $subject = Db::name('subject')->select();
            $this->assign('subject',$subject);
            return $this->fetch();
        }
    }

    public function coursetableedit($couid){
        $coursetable = new \app\admin\model\Coursetable();
        $data = input('post.');
        if(!empty($data)){
            $duibi = Db::name('coursetable')
                ->where('sub_id',$data['sub_id'])
                ->where('cla_id',$data['cla_id'])
//                ->where('classroom',$data['classroom'])
                ->where('week',$data['week'])
                ->where('starttime',$data['starttime'])
//                ->where('endtime',$data['endtime'])
//                ->where('tea_id',$data['tea_id'])
                ->select();
            if(empty($duibi)){
                $rs =$coursetable->where('couid',$data['couid'])->find()->save($data);
                if($rs){
                    $this->success('修改成功','coursetable/coursetablelist');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error('当前时间该班级已有课程，请核对');
            }
        }else{
            $data=Db('coursetable')
                ->alias('c')
                ->field('c.couid,c.classroom,c.week,c.starttime,c.endtime,c.cla_id,c.sub_id,cla.cname,s.subname')
                ->join('classes cla','c.cla_id = cla.cid')
                ->join('subject s','c.sub_id = s.subid')
                ->where('couid',$couid)->find();
            $this->assign('data',$data);
            $classes = Db::name('classes')->select();
            $this->assign('classes',$classes);
            $subject = Db::name('subject')->select();
            $this->assign('subject',$subject);
            return $this->fetch();
        }
    }

    public  function  del($couid){
        $data = model('coursetable')->where('couid',$couid)->find()->delete();
        if($data){
            $this->success('删除成功','coursetable/coursetablelist');
        }else{
            $this->error('删除失败');

        }
    }
    //批量删除
    public function  delall()
    {
        $str = input ('str');
        $couid = explode ('&', $str);//将字符串转化为数组
        $data = Db::name('coursetable')->delete($couid);
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
//   获取我的课程表
    public function ajaxGetCourse(){
        $tea_id = Session::get('tea_id');
        $data=Db('coursetable')
            ->alias('c')
            ->field('c.couid,c.classroom,c.week,c.starttime,c.endtime,cla.cname,s.subname,cla.cid,c.tea_id')
            ->join('classes cla','c.cla_id = cla.cid')
            ->join('subject s','c.sub_id = s.subid')
            ->where('tea_id',$tea_id)
            ->order('starttime asc')
            ->select();
        if ($data) {
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
    //学生信息存入数据库
    public function mycoursetable(){
        return $this->fetch();
    }
    public function qr(){
        import('phpqrcode.phpqrcode');
        $ThisCoures= $_POST['ThisCoures'];
        $value=$ThisCoures;
        $errorCorrectionLevel = "M"; // 纠错级别：L、M、Q、H
        $matrixPointSize = "8"; // 点的大小：1到10
        $qrcode = new \QRcode();
        ob_end_clean();//这个很重要
        $qrcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}