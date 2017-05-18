<?php

namespace app\common\model;

use think\Model;    //  导入think\Model类

/**
 * 课程表
 */

class Course extends Model {

    public function Klasses() {
        return $this->belongsToMany('Klass',  'klass_course');
    }

    /**
     * 获取是否存在相关关联记录
     * @param  object  班级
     * @return bool
     */
    public function getIsChecked(Klass &$Klass) {
        $courseId = (int) $this->id;
        $klassId = (int) $Klass->id;

        //查询条件
        $map = array('klass_id' => $klassId, 'course_id' => $courseId);

        $KlassCourse = KlassCourse::get($map);

        return empty($KlassCourse) ? false : true;
    }    
}
