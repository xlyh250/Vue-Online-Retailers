<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Model;
use think\db;

class Cates extends Controller{
    public function index(){
        return show(1,'成功',Model('cates')->catestree(),200);
    }

     // 首页商品
    public function getHomegoods(){
        $result = db('categoods')->alias('cg')->join('cates c','c.id=cg.cateid')->where('cg.cateid','neq','1,2,3')->
        order('cg.cateid desc')
            ->field('cg.id,cg.name,cg.keywords,cg.state,cg.cateid,cg.img,cg.price,cg.desc,c.catename,c.pid')->select();
//        halt($result);
       $cate = db::name('cates')->where('pid','0')->select();

       foreach ($cate as $k => &$v){
           $array = [];
           foreach ($result as $key =>&$val){
               if($val['pid']==$v['id']){
                  $array[] = $val;
               }
           }
           $v['goods'] = $array;
       }
       return show(1,'成功',json_decode(json_encode($cate)),200);
    }

    // 列表页面商品
    public function listPageGoods(){
        return show(1,'成功',Model('cates')->listGoods(),200);
    }

}