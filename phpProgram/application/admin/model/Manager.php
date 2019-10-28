<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/12/14
 * Time: 16:58
 */

namespace app\admin\model;


use think\captcha\Captcha;
use think\Model;

class Manager extends  Model
{


    public function check_verify($code){
        $captcha = new Captcha();
        return $captcha->check($code);
    }

    public function  checkpwd($username,$password){
        $info = $this->where('username','=',$username)->find();
        if($info['password']==md5($password)){
            return $info;
        }else{
            return null;
        }
    }

}