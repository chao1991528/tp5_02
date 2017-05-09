<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Teacher;

class LoginController extends Controller {

    public function index() {
        // 显示登录表单
        return $this->fetch();
    }
    
    public function doLogin() {
        //接收数据
        $info = Request::instance()->post();
        //验证用户是否存在
        if (Teacher::login($info['username'], $info['password'])) {
            $this->success('登录成功', 'Teacher/index');
        }
        $this->error('username or password incorrect', 'index'); //错误，跳转登录页面
    }
    
    public function logout(){
        if(Teacher::logOut()){
            return $this->success('退出成功', 'index');
        } else {
            return $this->error('退出失败', 'index');
        }
    }

}
