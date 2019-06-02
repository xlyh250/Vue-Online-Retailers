<?php

namespace app\common\validate;

use think\Validate;

class Search extends Validate
{
    protected $rule = [
        'name' => 'require|max:20',
    ];

    protected $message = [
        'name.require' => '必须填写',
        'name.max' => '超出大小,最大为20'
    ];

//    protected $scene = [
//        'search' => ['name']
//    ];
}
