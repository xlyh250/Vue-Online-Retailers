<?php

namespace app\common\lib;

class IAuth{
    public  static function setAppLoginToken($phone = '') {
        $str = md5(uniqid(md5(microtime(true)), true));
        return $str;
    }
}