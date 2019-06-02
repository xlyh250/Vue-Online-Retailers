<?php

namespace app\common\validate;

use think\Validate;

class Login extends Validate{

     protected $rule = [
            'username'=>'require|max:20',
            'password'=> 'require|max:20',
            'oldpassword'=>'require|max:20',
        ];

    protected $message = [
        'username.require' => '用户名必须填写',
        'password.require' =>'密码不得为空',
        'username.max' => '最大为20位',
        'password.max' => '超出大小,最大为20',
        'newpassword.unique'=>'新旧密码重复',
        'email.require'=>'邮箱不得为空',
    ];
    protected $scene = [
        'phonelogin' =>[ 'username'=>'require|max:11'],
        'register' =>['username'=>'max:11|unique:admin'],
        'passlogin' =>['username','password'],
        'setPass' =>[
            'username',
            'oldpassword',
        ],
        'forgetPass'=>[
            'email'=> 'require',
            'username' =>'require|max:20',
            'password' => 'require|max:20',
            'confirmPass' =>'require|confirm:password'
        ]
    ];
}