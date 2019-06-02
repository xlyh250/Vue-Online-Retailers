<?php


namespace app\api\controller\v1;

class Recommend extends common {

    public function index(){
        $result = Model('categoods')->where('state',1)->limit(10)->select();

        return show(1,'成功',json_decode(json_encode($result)),201);
    }
}
