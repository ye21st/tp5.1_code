<?php
namespace app\index\validate;
use think\Validate;
class Cate extends Validate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule=[
        'catename'=>'unique:cate|require|max:25',
    ];

    /**
     * 错误提示信息
     * @var array
     */
    protected $message=[
        'catename.require'=>'栏目名称不得为空！',
        'catename.unique'=>'栏目名称不得重复！',
    ];

    /**
     * 验证场景
     * @var array
     */
    protected $scene=[
        'add'=>['catename'],
        'edit'=>['catename'],
    ];
}
