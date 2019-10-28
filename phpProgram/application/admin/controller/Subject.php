<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/22
 * Time: 10:42
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Subject extends Controller
{
    public function  subjectlist(){
        $data = model('subject')->select();
//        dump($data);
        $count = count($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    public  function  subjectadd(){
        $subject = new \app\admin\model\Subject();
        $data = input('post.');

        if(!empty($data)){
            $rs = $subject->save($data);
            dump($rs);
            if($rs){
                $this->success('添加成功','subject/subjectlist');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function subjectedit($subid){
        $subject = new \app\admin\model\Subject();
        $data = input('post.');
//        dump($data);
        if(!empty($data)){
            $rs =$subject->where('subid',$data['subid'])->find()->save($data);
//            dump($rs);
            if($rs){
                $this->success('修改成功','subject/subjectlist');

            }else{
                dump($rs);
                $this->error('修改失败');

            }
        }else{
            $data  = $subject->where('subid',$subid)->find();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public  function  del($subid){
        $data = model('subject')->where('subid',$subid)->find()->delete();
        if($data){
            $this->success('删除成功','subject/subjectlist');
        }else{
            $this->error('删除失败');

        }
    }
    //批量删除
    public function  delall()
    {
        $str = input ('str');
        $cid = explode ('&', $str);//将字符串转化为数组
        $data = Db::name('subject')->delete($cid);
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
}