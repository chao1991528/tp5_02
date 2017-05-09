<?php

namespace app\common\model;

use think\Model;
use app\common\model\Teacher;

/**
 * 班级表
 */
class Klass extends Model {

    /**
     * 获取教师信息
     * @return Teacher 教师
     */
    public function teacher() {
        return $this->belongsTo('Teacher');
    }

}
