<?php

namespace app\common\validate;

use think\Validate;

/**
 * 课程验证器类
 */
class KlassCourse extends Validate {

    protected $rule = [
        'klass_id' => 'require',
        'course_id' => 'require'
    ];

}
