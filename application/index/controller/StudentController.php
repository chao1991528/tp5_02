<?php

namespace app\index\controller;

use app\common\model\Student;
use app\common\model\Klass;
use app\index\controller\IndexController;
use think\Request;

class StudentController extends IndexController {

    public function index() {
        $name = Request::instance()->get('name'); //获取查询信息

        $pageSize = 5; //每页显示5条

        $Student = new Student;
        if (!empty($name)) {
            $Student->where('name', 'like', '%' . $name . '%');
        }
        $students = $Student->paginate($pageSize, false, ['query' => ['name' => $name]]);

        $this->assign('students', $students);
        $htmls = $this->fetch();
        return $htmls;
    }

    //添加学生
    public function add() {
        //获取所有班级
        $klasses = Klass::all();
        $this->assign('klasses', $klasses);

        return $this->fetch();
    }

    //班级信息插入到数据库
    public function insert() {
        $postData = Request::instance()->post();
        $Student = new Student();

        if (!$Student->validate(true)->allowField(true)->save($postData)) {
            return $this->error('添加失败' . $Student->getError());
        }
        return $this->success('添加学生成功', 'index');
    }

    //编辑学生信息
    public function edit() {
        $id = Request::instance()->param('id/d');

        // 获取用户操作的学生信息
        if (false === $Student = Student::get($id)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        $this->assign('Student', $Student);
        return $this->fetch();
    }

    //编辑班级信息保存到数据库
    public function update() {
        $postData = Request::instance()->post();
        if (false === $Student = Student::get($postData['id'])) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }
        if (!$Student->validate()->allowField(true)->save($postData)) {
            return $this->error('更新错误：' . $Student->getError());
        }
        return $this->success('更新成功！', 'index');
    }

    //删除班级信息
    public function delete() {
        $id = Request::instance()->get('id/d');
        //查找是否存在该记录
        $Student = Student::get($id);
        if (!is_null($Student) && !$Student->delete()) {
            return $this->error('删除失败：' . $Student->getError());
        }
        return $this->success('删除成功！', 'index');
    }

}
