<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;

class Iauth extends Controller {

    public static function checktoken($token=''){

//        $header = Request::instance()->header();
//        $token = $header['token'];
        if(empty($token)){
            return false;
        }
    }
}
