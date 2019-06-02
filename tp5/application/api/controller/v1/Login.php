<?php

namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use app\api\sdk\Rest;
use think\Model;
use app\common\lib\exception\IAuth;
use app\api\controller\v1\AuthBase;
use think\Cache;
use \think\Request;
use app\common\model\Admin;

class Login extends common{

    //发送手机短信验证码
    public function getPhoneCode(){
        $phone = input('get.');
        // array(rand('100000','999999')) 短信验证码、

        return $this->sendSms(implode('',$phone),array(rand('100000','999999')),1);
    }

    //发送短信验证码
    public function sendSms($to,$datas,$tempId){

            // 初始化REST sdk
            global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
            //主帐号
            $accountSid= '8a216da865e5a5f40165e677138a00d0';
            //主帐号Token
            //   317c1c008b78431d8df173926d4328f6
            $accountToken= '317c1c008b78431d8df173926d4328f6';

            //应用Id
            $appId='8a216da865e5a5f40165e67713ee00d6';

           //请求地址，格式如下，不需要写https://
            $serverIP='app.cloopen.com';

           //请求端口
            $serverPort='8883';

           //REST版本号
            $softVersion='2013-12-26';
            // 初始化REST SDK
            $rest = new Rest($serverIP,$serverPort,$softVersion);
            $rest->setAccount($accountSid,$accountToken);
            $rest->setAppId($appId);

            // 发送模板短信
            $result = $rest->sendTemplateSMS($to,$datas,$tempId);
            if($result == NULL ) {
                echo "result error!";
            }
            if($result->statusCode!=0) {

                return show(0,'短信发送失败','',400);
//                echo "error code :" . $result->statusCode . "";
//                echo "error msg :" . $result->statusMsg . "";
                //下面可以自己添加错误处理逻辑
            }else{

                Cache::set('user',implode('',$datas),60);
                return show(1,'短信发送成功','',200);
//                $smsmessage = $result->TemplateSMS;
//                echo "dateCreated:".$smsmessage->dateCreated."";
//                echo "smsMessageSid:".$smsmessage->smsMessageSid."";
            }
        }

        // 手机短信验证码验证
    public function phoneLogin(){
        if(!Request::instance()->isPost()){
            return ;
        }
          $code = input('post.');
          if(!$code['code']||!$code['username']){
               return show(0,'参数不得为空','失败',400);
           }
           $validate = validate('login');
           $checkCode = $code['code'];
           $getSessionCode = Cache::get('user');

           try {
               $user = db('admin')->where('username', $code['username'])->find();
           }
           catch (\Exception $e){
               return new ApiException('系统内部错误',500,0);
           }

          // 登录
          if($user){
              try {
                  if (!$validate->scene('phonelogin')->check($user)) {
                      return show(2, '验证失败', $validate->getError(), 400);
                  }
                  if ($getSessionCode == $checkCode) {
                      return show(1, '登录成功', $user, 200);
                  } else {
                      return show(0, '验证码错误','',  200);
                  }
              }
              catch(\Exception $e) {
                  return new ApiException('error', 500);
              }

              // 注册
          }else{

              if (!$validate->scene('register')->check($code)) {
                  return show(2,'验证失败：'.$validate->getError(),'',400);
              }

              if($getSessionCode== $checkCode){
                  if($user==null){
                      $code['create_time'] = time();
                      $token = md5(md5(uniqid()));
                      $code['token'] = $token;
                      $save = Model('admin')->allowField(true)->save($code);
                      $find = Model('admin')->where('username',$code['username'])->find();

                      return show(1,'注册成功',$find,200);
                  }
              }else{
                  return show(0,'验证码不准确','',200);
              }
          }
      }

    // 密码登录
    public function passLogin(){
        if(!Request::instance()->isPost()){
            return '不是post请求';
        }

        $result = input('post.');
        $validate = validate('login');
        if (!$validate->scene('passlogin')->check($result)) {
           return show(0,$validate->getError(),'',400);
        }

        try {
            $find = db('admin')->where('username', $result['username'])->find();
        }catch (\Exception $e){
            return new ApiException(0,'系统内部错误',500);
        }

        if($find){

             if($find['password']!=$result['password']){
                 return show(0,'密码不正确','',200);
            }else{
                 $token = md5(md5(time()));
               db('admin')->where('username',$result['username'])->update(['token'=>$token]);
                $userinfo = Model('admin')->where('username',$result['username'])->find();
                 return show(1,'登录成功',$userinfo,200);
            }
        }else{
            return show(0,'用户不存在','',500);
        }
    }

    // 修改密码
    public function setPass(){
        if(!Request::instance()->isPost()){
            return '';
        }

        $result = Request::instance()->post();

        if(!$result){
            throw new ApiException('数据有误',400);
        }

        if(empty($result['usertoken'])||empty($result['username'])||empty($result['oldpassword'])||empty($result['newpassword'])){
            return show(0,'参数有误','',400);
        }

//        if(AuthBase::checktoken()===false){
//            return show(0,'失败','没有权限',200);
//        };
//        !preg_match("/^1[34578]\d{9}$/", $find['username'])

        $validate = validate('login');

        if(!$validate->scene('setPass')->check($result)){
            return show(0,'检验失败',$validate->getError(),400);
        }

        if($result['oldpassword']==$result['newpassword']){
            return show(0,'新旧密码重复','',500);
        }

        $find = db('admin')->where('username',$result['username'])->find();

        if($find['token']!=$result['usertoken']){
              return show(0,'token错误','',400);
        }
        // 通过验证码修改
        $getSessionCode = Cache::get('user');
        if($getSessionCode) {
            if ($result['oldpassword'] != $getSessionCode) {
                return show(0, '验证码错误','' , 200);
            }
        }
//        $find = db('admin')->where('username',$result['username'])->find();

      // 通过新旧密码修改
        if(!$getSessionCode){
            $oldpassword = $result['oldpassword'];

            if($find['password']!=$oldpassword){
                return show(0,'旧密码不正确','修改失败',200);
            }
            $find['password'] = $result['newpassword'];
            $find['update_time'] = time();
        }

        $update = db('admin')->where('username',$result['username'])->setField('password', $result['newpassword'])||db('admin')->update($find);

        if($update){
            Cache::clear();
            return show(1,'修改密码成功','成功',200);
        }else{
            return show(0,'修改密码失败','失败',400);
        }
    }

    //通过邮箱修改密码
    public function forgetPass()
    {
        $data = input('post.');
        if (!Request::instance()->isPost()) {
            return '';
        }
        $validate = validate('login');

        if (!$validate->scene('forgetPass')->check($data)) {
            return show(0, $validate->getError(), '', 500);
        }

//        $user = Admin::get(['username' => $data['username']]);
          $user = db('admin')->where('username',$data['username'])->find();

        if (Cache::get('emailCode') == $data['emailcode']) {
            if ($user) {
                if($user['email']!=$data['email']){
                    return show(0,'邮箱和用户名不对应','',200);
                }
                $user['password'] = $data['password'];
                $user['token'] = md5(md5(time()));

                //只更新数据表存在的字段
                $res = Model('admin')->isUpdate(true)->save($user);
                if($res){
                    Cache::clear('emailcode');
                    return show(1,'设置密码成功','',200);
                }else{
                    return show(0,'设置密码失败','',400);
                }

             }else{
                return show(0,'用户不存在','',200);
            }
        }else{
            return show(0,'邮箱验证码错误','',200);
        }

    }
    // 检查是否登录
    public function isLogin($message = '登录成功'){

        if(!AuthBase::checktoken()){
            return show(0,'没有权限','失败',200);
        };
        $data = db('admin')->where('token',AuthBase::$token)->find();
        if($data){
            return show(1,'已经登录',$data,200);
        }else{
            return show(0,'没有登录','失败');
        }

    }
}