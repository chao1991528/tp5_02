<?php

namespace app\common\validate;

use think\Validate;

/**
 * 课程验证器类
 */
class Course extends Validate {

    protected $rule = [
        'name' => 'require|length:2,20',
    ];

}
