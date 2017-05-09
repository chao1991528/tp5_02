<?php

namespace app\index\controller;

use app\common\model\Klass;
use app\common\model\Teacher;
use app\index\controller\IndexController;
use think\Request;

class KlassController extends IndexController {

    public function index() {
        $name = Request::instance()->get('name'); //获取查询信息

        $pageSize = 5; //每页显示5条

        $Klass = new Klass;
        if (!empty($name)) {
            $Klass->where('name', 'like', '%' . $name . '%');
        }
        $Klasses = $Klass->paginate($pageSize, false, ['query' => ['name' => $name]]);

        $this->assign('classes', $Klasses);
        $htmls = $this->fetch();
        return $htmls;
    }
    
    //添加班级
    public function add(){
        //获取所有教师
        $teachers = Teacher::all();
        $this->assign('teachers', $teachers);
        
        return $this->fetch();
    }
    
    //班级信息插入到数据库
    public function insert(){
        $class = Request::instance()->post();
        $Klass = new Klass();
        $Klass->name = $class['name'];
        $Klass->teacher_id = $class['teacher_id'];
        
        if(!$Klass->validate(true)->save($Klass->getData())){
            return $this->error('添加失败'. $Klass->getError());
        }
        return $this->success('添加班级成功', 'index');
    }
    
    //编辑班级信息
    public function edit(){
        $id = Request::instance()->param('id/d');
        // 获取所有的教师信息
        $teachers = Teacher::all();
        $this->assign('teachers', $teachers);
        
        // 获取用户操作的班级信息
        if (false === $Klass = Klass::get($id))
        {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        $this->assign('Klass', $Klass);
        return $this->fetch();
    }
    
    //编辑班级信息保存到数据库
    public function update(){
        $id = Request::instance()->post('id/d');
        if(false === $Klass = Klass::get($id)){
            return $this->error('系统未找到ID为' . $id . '的记录');
        }
        $Klass->name = Request::instance()->post('name');
        $Klass->teacher_id = Request::instance()->post('teacher_id/d');
        if(!$Klass->validate()->save()){
            return $this->error('更新错误：'.$Klass->getError());
        }
        return $this->success('更新成功！', 'index');
    }
    
    //删除班级信息
    public function delete(){
        $id = Request::instance()->get('id/d');
        //查找是否存在该记录
        $Klass = Klass::get($id);
        if(!is_null($Klass) && !$Klass->delete()){
            return $this->error('删除失败：'.$Klass->getError());
        }
        return $this->success('删除成功！', 'index');
    }

}
