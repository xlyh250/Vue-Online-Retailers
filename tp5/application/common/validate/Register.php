<?php

namespace app\common\validate;

use think\Validate;

class Register extends Validate{
    protected $rule = [
        'email' => 'require|unique:admin',
        'username' => 'require|max:20|unique:admin',
        'password' => 'require|max:20',
        'confirmpass' =>'require|confirm:password'
    ];
    protected $message = [
        'email.require' => '邮箱必须填写',
        'email.unique' => '邮箱已注册',
        'username.require' => '用户名必须填写',
        'username.unique' => '用户已注册',
        'username.max' => '最大为20位',
        'password.require' =>'密码不得为空',
        'password.max' => '最大为20位',
        'confirmpass' =>'密码不一致'
    ];
    protected $scene = [
         'emailValidate' => ['email'=>'require']
    ];
}