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
    
    public function Klasses()
    {
        return $this->belongsToMany('Klass');
    }
    
    /**
     * 获取是否存在相关关联记录
     * @param  object  班级
     * @return bool
     */
    public function getIsChecked(Klass &$Klass)
    {
        $courseId = (int) $this->id;
        $klassId = (int)$Klass->id;
        
        //查询条件
        $map = array('klass_id'=>$klassId, 'course_id'=>$courseId);
        
        $KlassCourse = KlassCourse::get($map);
        
        return empty($KlassCourse)?false:true;
    }
    
}
