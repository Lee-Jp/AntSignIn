<?php


namespace app\admin\controller;


use think\captcha\Captcha;
use think\Controller;

class Login extends  Controller
{

    public function log(){
        $this->view->engine->layout(false);
        $data = input('post.');
        if(!empty($data)){
            $vry = new Captcha();
            if($vry->check(input('post.code'))){
                $manager = new \app\admin\model\Manager();
                $rs = $manager->checkpwd(input('post.username'),input('post.password'));
                if($rs){
                    // 防跳墙
                    session('username', $rs['username']);
                    session('tea_id', $rs['id']);
                    session('isadmin', $rs['isadmin']);
                    $this->redirect('index/index');
                }else{
                    $this->error('用户名或密码错误');
                }
            }else{
                $this->error('验证码错误');
            }
        }else{
            return $this->fetch();
        }
    }

    public function verify(){
        $config = [
            'fontSize' => 18,
            'imageH' => 40,
            'imageW' => 126,
            'length' => 4
        ];
        $vry = new Captcha($config);
        return $vry->entry();
    }
    public function  logout(){
        session(null);
        $this->redirect('login/log');
    }
}