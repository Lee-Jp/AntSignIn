<?php


namespace  app\admin\controller;


use think\Controller;


class BaseController extends Controller
{

    public function upload($file){
        // 获取表单上传文件
        // 移动到框架应用根目录/public/upload/目录下

        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            if($info){
                //成功上传后 获取上传信息
                //输出	20160820/42a79759f284b767dfcb2a0197904287.jpg
                $image = $info->getSaveName();
                $path = str_replace("\\","/",$image);
//                dump($path);
                $image_path = '/upload/'.$path;
//                dump($image_path);
                return $image_path;
            }else{
                // 上传失败获取错误信息
                return  $file->getError();
            }
        }
    }


}

?>