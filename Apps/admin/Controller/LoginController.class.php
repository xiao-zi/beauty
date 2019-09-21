<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\UserApi;

class LoginController extends Controller {
    public function _initialize(){
        header("Content-type: text/html; charset=utf-8");
    }
    /**
     * 后台的登录页
     */
    public function index(){
        $this->display('Login/login');
    }
    /**
     * 后台用户登录
     */
    public function login(){
        //是否使用post提交
        if(IS_POST){
            $data = I('POST.','',FALSE);
            $username = $data['username'];//用户名
            $password = $data['password'];//密码
            $check = $data['check'];//是否记住密码
            //用户名和密码都不能为空
            if(!empty($username) && !empty($password)){
                $user = new UserApi();
                $back = $user->login($username,$password,$check);
            }else{
                $back['rel'] = 4;
                $back['msg'] = '账户和密码不能为空';
            }
        }else{
            $back['rel'] = 5;
            $back['msg'] = '请求方式错误';
        }
        if($back['rel'] == 1){//登录成功跳转到后台
            header("location:/admin.php/Index/index.html");
        }else{//登录失败跳转到登录页面
            header("location:/admin.php/Login/index.html?rel=".$back['rel']."&msg=".$back['msg']."");
        }
    }

    /**
     * 退出登录
     */
    public function loginOut(){
        //删除用户的session
        unset($_SESSION);
        session_destroy();
        //删除用户的cookie
        cookie('Login',null);
        header("location:/admin.php/Login/index.html");
    }

}