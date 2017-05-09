<?php
namespace app\index\controller;

use think\Db;
use think\Controller;
use app\common\model\Teacher;

class IndexController extends Controller {

    public function __construct() {
        parent::__construct();
        if(!Teacher::isLogin()){
            return $this->error('你尚未登录，请先登录！', 'login/index');
        }
    }

}
