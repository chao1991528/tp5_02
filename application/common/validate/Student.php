<?php

namespace app\common\validate;

use think\Validate;

class Student extends Validate {

    protected $rule = [
        'name' => 'require|length:2,10',
        'num' => 'require|number',
        'klass_id' => 'require|number',
        'sex' => 'require|number',
        'email' => 'email'
    ];

}
