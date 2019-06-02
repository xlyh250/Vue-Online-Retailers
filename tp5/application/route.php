<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
// 轮播图
Route::get('api/:ver/test','api/:ver.test/index');
//首页商品
Route::get('api/:ver/indexGoods','api/:ver.cates/getHomegoods');
//推荐商品
Route::get('api/:ver/recommend','api/:ver.recommend/index');
//搜索
Route::get('api/:ver/search','api/:ver.search/index');

// 发送手机验证码
Route::get('api/:var/getPhoneCode','api/:var.login/getPhoneCode');

//手机验证码登录
Route::post('api/:ver/phoneLogin','api/:ver.login/phoneLogin');
//密码登录
Route::post('api/:ver/passLogin','api/:ver.login/passLogin');

// 修改密码
Route::post('api/:var/setPass','api/:var.login/setPass');

// 检测是否登录
Route::put('api/:ver/isLogin','api/:ver.login/isLogin');

//获取列表页面数据
Route::get('api/:ver/listpagegoods','api/:ver.cates/listPageGoods');

//邮箱验证码
Route::get('api/:ver/emailcode','api/:ver.register/emailCode');

//注册
Route::post('api/:ver/register','api/:ver.register/index');

//忘记密码
Route::post('api/:ver/forgetpass','api/:ver.login/forgetPass');

//Route::put('test/:id','api/Test/update');
//Route::post('post','api/test/save');

//post 提交方式
//Route::post('test','api/test/save');

// 使用resource 指向默认方法，不用写方法名
//Route::resource('test','api/test');


