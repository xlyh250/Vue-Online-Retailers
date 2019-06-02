<?php

namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use think\Controller;
use \think\Request;

class AuthBase extends Controller {

    public static $token;
    public static function checktoken(){

        $header = Request::instance()->header();
        self::$token = $header['token'];
        if(empty(self::$token)){
            return false;
        }
        return true;
    }


}
