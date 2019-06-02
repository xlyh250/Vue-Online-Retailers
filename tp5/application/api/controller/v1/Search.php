<?php


namespace app\api\controller\v1;
use app\common\lib\exception\ApiException;
use think\image\Exception;
use think\Model;
class Search extends common
{
    public function index()
    {
        $keywords = input('get.');
        if (!$keywords['name']) {
            throw new ApiException(0,'提交数据不合法', 500);
        }

        $validate = validate('Search');
        if (!$validate->check($keywords)) {
            return show(0,$validate->getError(),'',500);
        }

        $res = implode(',', $keywords);
        $result=Model('categoods')->whereOr('name','like','%'.$res.'%')->
        whereOr('keywords','like','%'.$res.'%')->order('cateid','desc')->paginate(10);

        $res = json_decode(json_encode($result))->data;
        if (!empty($res)) {
            return show(1, '成功', $res, 200);
        } else {
            return show(1, '成功', '没有数据', 201);
        }
    }
}