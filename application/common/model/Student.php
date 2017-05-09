<?php

namespace app\common\model;

use think\Model;    //  导入think\Model类

/**
 * Student 学生表
 */

class Student extends Model {

    /**
     * 输出性别的属性
     * @return string 0男，1女
     */
    public function getSexAttr($value) {
        $sex_text = array('0' => '男', '1' => '女');
        $sex = $sex_text[$value];
        if (isset($sex)) {
            return $sex;
        } else {
            return $sex_text[0];
        }
    }
    
    /**
     * 显示班级信息
     * @return Klass 
     */
    public function klass(){
        return $this->belongsTo('Klass');
    }

}
