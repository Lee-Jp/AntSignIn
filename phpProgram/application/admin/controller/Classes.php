<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/19
 * Time: 9:57
 */

namespace app\admin\controller;


use think\Db;

class Classes extends BaseController
{
    public function  classeslist(){
        $cname=input('post.cname');
        if($cname){

            $where['cname'] = array('like','%'.$cname.'%');//封装模糊查询 赋值到数组
            $data = model('classes')->where($where)->select();
        }else{
            $data = model('classes')->select();
        }
        $count = count($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    public  function  classesadd(){
        $classes = new \app\admin\model\Classes();
        $data = input('post.');

        if(!empty($data)){
            $rs = $classes->save($data);
            dump($rs);
            if($rs){
                $this->success('添加成功','classes/classeslist');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function classesedit($cid){
        $classes = new \app\admin\model\Classes();
        $data = input('post.');
//        dump($data);
        if(!empty($data)){
            $rs =$classes->where('cid',$data['cid'])->find()->save($data);
//            dump($rs);
            if($rs){
                $this->success('修改成功','classes/classeslist');

            }else{
                dump($rs);
                $this->error('修改失败');
            }
        }else{
            $data  = $classes->where('cid',$cid)->find();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public  function  del($cid){
        $data = model('classes')->where('cid',$cid)->find()->delete();
        if($data){
            $this->success('删除成功','classes/classeslist');
        }else{
            $this->error('删除失败');
        }
    }
    //批量删除
    public function  delall()
    {
        $str = input ('str');
        $cid = explode ('&', $str);//将字符串转化为数组
        $data = Db::name('classes')->delete($cid);
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