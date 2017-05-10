<?php

namespace app\index\controller;

use app\index\controller\IndexController;
use think\Request;
use app\common\model\Course;
use app\common\model\Klass;

/**
 * 课程控制器类
 */
class CourseController extends IndexController {

    public function index() {
        $name = Request::instance()->get('name'); //获取查询信息

        $pageSize = 5; //每页显示5条

        $Course = new Course;
        if (!empty($name)) {
            $Course->where('name', 'like', '%' . $name . '%');
        }
        $Courses = $Course->paginate($pageSize, false, ['query' => ['name' => $name]]);

        $this->assign('Courses', $Courses);
        $htmls = $this->fetch();
        return $htmls;
    }

    //添加课程
    public function add() {
        $klasses = Klass::all();
        $this->assign('klasses', $klasses);
        
        return $this->fetch();
    }

    //课程信息插入到数据库
    public function insert() {
        $postData = Request::instance()->post();
        $Course = new Course();

        if (!$Course->validate(true)->allowField(true)->save($postData)) {
            return $this->error('添加失败' . $Course->getError());
        }
        return $this->success('添加成功', 'index');
    }

    //编辑课程信息
    public function edit() {
        $id = Request::instance()->param('id/d');

        // 获取用户操作的课程信息
        if (false === $Course = Course::get($id)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        $this->assign('Course', $Course);
        return $this->fetch();
    }

    //编辑班级信息保存到数据库
    public function update() {
        $postData = Request::instance()->post();
        if (false === $Course = Course::get($postData['id'])) {
            return $this->error('系统未找到ID为' . $postData['id'] . '的记录');
        }
        if (!$Course->validate()->allowField(true)->save($postData)) {
            return $this->error('更新错误：' . $Course->getError());
        }
        return $this->success('更新成功！', 'index');
    }

    //删除班级信息
    public function delete() {
        $id = Request::instance()->get('id/d');
        //查找是否存在该记录
        $Course = Course::get($id);
        if (!is_null($Course) && !$Course->delete()) {
            return $this->error('删除失败：' . $Course->getError());
        }
        return $this->success('删除成功！', 'index');
    }

}
