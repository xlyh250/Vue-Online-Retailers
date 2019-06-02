<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Session;

class common extends Controller{
    public function _initialize(){
         $this->checkRequestAuth();
        $this::setAppLoginToken();
    }

    public function checkRequestAuth(){
//        $headers = request()->header();
//        halt($headers);
    }

    public function isLogin(){

    }

    public static function setAppLoginToken($phone = '') {

    }

}
