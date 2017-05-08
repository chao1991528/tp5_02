<?php

namespace app\index\controller;

use app\common\model\Teacher;
use think\Controller;
use think\Request;

class TeacherController extends Controller {

    public function index() {
        $Teacher = new Teacher;
        $teachers = $Teacher->select();
        //获取第0个数据
//        $teacher = $teachers[0];

        $this->assign('teachers', $teachers);
        $htmls = $this->fetch();
        return $htmls;
    }

    public function insert() {
        //接收传入的数据
        $postData = Request::instance()->post();

        //实例化Teacher空对象
        $Teacher = new Teacher();

        //为对象赋值
        $Teacher->name = $postData['name'];
        $Teacher->sex = $postData['sex'];
        $Teacher->username = $postData['username'];
        $Teacher->email = $postData['email'];

        //执行对象插入操作
        $result = $Teacher->validate(true)->save($Teacher->getData());
        if (false === $result) {
            return '新增失败:' . $Teacher->getError();
        } else {
            return '新增成功。新增ID为:' . $Teacher->id;
        }
    }

    public function add() {
        $htmls = $this->fetch();
        return $htmls;
    }

}
