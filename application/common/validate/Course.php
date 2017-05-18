<?php

namespace app\common\validate;

use think\Validate;
use app\common\model\KlassCourse;

/**
 * 课程验证器类
 */
class Course extends Validate {

    protected $rule = [
        'name' => 'require|length:2,20',
    ];    
}
