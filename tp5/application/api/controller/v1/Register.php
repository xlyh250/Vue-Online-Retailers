<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use think\Cache;
use app\common\validate\Register as regValidate;
use app\common\model\Admin;


class Register extends Controller{

    //邮箱验证码
    public function emailCode(){
        $email = input('get.');
        $emailCode = mt_rand(100000,999999);
        Cache::set('emailCode',$emailCode,200);
        $validate = validate('register');
        // check 里面是数组
        if(!$validate->scene('emailValidate')->check($email)){
            return show(0,$validate->getError(),'',500);
        }
        $res = email($email['email'],'验证码发送成功','你的验证码是'.$emailCode);

        if($res){
            return show(1,'发送邮件成功','',200);
        }else{
            return show(0,'发送邮件失败','',400);
        }
    }
   //注册
    public function index(){
        if(!Request()->isPost()){
            return ;
        }
        $data = input('post.');
        $validate = new regValidate();

        if(!$validate->check($data)){
           return show(0,$validate->getError(),'',500);
        }
//        $user = new Admin;
//        $user->data($data);
//        $user->save();
//        $user = Admin::create($data);

          $data['token'] = md5(md5(time()));
          $user = new Admin($data);

          // 只保存数据表存在的字段数值
         $msg = $user->allowField(true)->save();
          if($msg){
              return show(1,'注册成功','',200);
          }else{
              return show(0,'注册失败','',400);
          }
    }
}