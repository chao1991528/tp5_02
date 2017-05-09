<?php
namespace app\common\validate;
use think\Validate;

class Klass extends Validate{
    protected $rule = [
        'name' => 'require|length:2,20',
        'teacher_id' => 'require|number'
    ];
}
