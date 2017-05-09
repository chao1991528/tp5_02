<?php

namespace app\index\controller;

use app\common\model\Teacher;
use app\index\controller\IndexController;
use think\Request;

class TeacherController extends IndexController {

    public function index() {
        $name = Request::instance()->get('name'); //获取查询信息

        $pageSize = 5; //每页显示5条

        $Teacher = new Teacher;
        if (!empty($name)) {
            $Teacher->where('name', 'like', '%' . $name . '%');
        }
        $teachers = $Teacher->paginate($pageSize, false, ['query' => ['name' => $name]]);

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

    //删除
    public function delete() {
        $id = Request::instance()->param('id/d');

        if (!$id) {
            return $this->error('参数id有误');
        }

        $Teacher = Teacher::get($id);

        //如果要删除的存在，删除
        if (!is_null($Teacher)) {
            if (!$Teacher->delete()) {
                return $this->error('删除失败:' . $Teacher->getError());
            }
        }

        return $this->success('删除成功', 'index'); 
    }

    public function edit() {
        $id = Request::instance()->get('id/d');
        if (!$id) {
            return $this->error('参数有误');
        }

        if (is_null($Teacher = Teacher::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        $this->assign('Teacher', $Teacher);
        $html = $this->fetch();
        return $html;
    }

    public function update() {
        //接收数据
        $teacher = Request::instance()->post();

        //将数据写入数据表
        $Teacher = new Teacher();
        $message = '更新成功';
        try {
            if (false === $Teacher->validate(true)->isUpdate(true)->save($teacher)) {
                $message = '更新失败：' . $Teacher->getError();
            }
        } catch (\Exception $e) {
            $message = '更新失败:' . $e->getMessage();
        }
        return $message;
    }

}
