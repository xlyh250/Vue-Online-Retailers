<?php


namespace app\common\model;

use think\Model;
use think\controller;

class Cates extends Model{

    public function catestree(){
        $datas = db('cates')->select();
        $tree = $this->sort($datas);
        return $this->generateTree($tree);
    }
    //列表页面商品
    public function listGoods(){

        $cates = db('cates')->select();
        $goods = db('categoods')->select();
        $tree = $this->sort($cates);
        $data = $this->generateTree($tree);
        foreach ($data as $k=>&$v){
            foreach ($v['son'] as $key=>&$val){
                $array = array();
                foreach ($goods as $kk=>$vv){
                    if($val['id'] ==$vv['cateid']){
                        $array[]= $vv;
                    }
                    $val['son'] = $array;
                }
            }
        }
        return $data;
//        return $tree;
    }

    //添加分级属性
    public function sort($datas,$pid=0,$level=0){
        global $arr;
        foreach ($datas as $key=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]= $v;
                $this->sort($datas,$v['id'],$level+1);
            }
        }
        // 转换数据类型
        $array = array();
        foreach ($arr as $k => $v){
            $object = json_decode(json_encode($v),true);
            $array[] = $object;
        }
        return $array;
    }

    // 无限分级列表
    public function generateTree($array)
    {
        $items = array();

        foreach ($array as $value) {
            $items[$value['id']] = $value;
        }

        // 遍历数据 生成树状结构
        $tree = array();
        foreach ($items as $key => $item) {
            //若不是顶级分类，则将其本身作为son放置在父类中，
            //注意：此时放置的是引用，
            //也就是说，当儿子再次出现儿子的时候，儿子与孙子重新组合成父亲与儿子的形象
            //但是，在顶级父类中存放的是儿子的引用，所以，当儿子与孙子被重新组合时，顶级父类中也被修改
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['son'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }
}