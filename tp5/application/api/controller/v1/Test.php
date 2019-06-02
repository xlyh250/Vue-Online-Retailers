<?php

namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use think\Controller;
use think\Model;

class Test extends common{
    // get提交方式
    public function index(){
//         $result = Model('Test')->get(2);

         $result = db('test')->select();
        return show(1,'成功',$result,201);
    }

    // put 提交方式
    public function update($id = 66){
//        echo $id;
        halt(input('put.'));
    }
    // post 提交方式
    public function save(){
        $data = input('post.');
        if($data['id']!==true){
            throw new ApiException('提交数据不合法',400);
        }
      return show(1,'成功',input('post.'),201);
    }
}