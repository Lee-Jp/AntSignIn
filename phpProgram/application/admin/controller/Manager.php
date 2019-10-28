<?php


namespace app\admin\controller;

use think\Db;
use think\Controller;

class Manager extends  Controller
{
    public function  managerlist(){
        $data = model('Manager')->select();
        $count = count($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        return $this->fetch();
    }
    public  function  manageradd(){
        $manager = new \app\admin\model\Manager();
        $data = input('post.');
        if(!empty($data)){
            $password = md5($data['password']);
            $data['password'] = $password;
//            dump($data);die();
            $rs = $manager->save($data);
//            dump($rs);
            if($rs){
                $this->success('添加成功','manager/managerlist');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    public function manageredit($id){
        $manager = new \app\admin\model\Manager();
        $data = input('post.');
//        dump($data);
        if(!empty($data)){
            $password = md5($data['password']);
            $data['password'] = $password;
            $rs =$manager->where('id',$data['id'])->find()->save($data);
//            dump($rs);
            if($rs){
                $this->success('修改成功','manager/managerlist');

            }else{
                $this->error('修改失败');

            }
        }else{
            $data  = $manager->where('id',$id)->find();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public  function  del($id){
        $data = model('Manager')->where('id',$id)->find()->delete();
        if($data){
            $this->success('删除成功','manager/managerlist');
        }else{
            $this->error('删除失败');

        }

    }
    public function  delall()
    {
        $str = input ('str');
        $id = explode ('&', $str);//将字符串转化为数组
        $data = Db::name('manager')->delete($id);
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

    //管理员小程序登录接口
    public function ajaxLoginManager(){
        $username = input('post.username');
        $password = input('post.password');
        $data = Db::name('manager')->where("username" , $username)->field('username,password')->find();

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

}
