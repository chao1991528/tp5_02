<?php

namespace app\common\model;

use think\Model;    //  导入think\Model类

/**
 * Teacher 教师表
 */

class Teacher extends Model {

    /**
     * 用户登录
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool  成功返回true，失败返回false。
     */
    static public function login($username, $password) {
        $map = array('username' => $username);
        $Teacher = self::get($map);
        if (!is_null($Teacher)) {
            //验证密码是否正确
            if ($Teacher->checkPassword($password)) {
                session('teacher', $Teacher);
                return true;
            }
        }
        return false;
    }

    /**
     * 注销
     * @return bool  成功true，失败false。
     */
    static public function logOut() {
        // 销毁session中数据
        session('teacher', null);
        return true;
    }
    
     /**
     * 是否登录
     * @return bool  是true，不是false。
     */
    static public function isLogin(){
        return empty(session('teacher'))?false:true;
    }

    private function checkPassword($password) {
        return ($this->getData('passwd') == self::encryptPassword($password)) ? true : false;
    }

    static private function encryptPassword($password) {
        $passwordStr = md5($password);
        return $passwordStr;
    }

}
