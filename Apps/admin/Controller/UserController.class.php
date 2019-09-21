<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\UserApi;

class UserController extends CommonController {
    /**
     * 获取后台管理员列表
     */
    public function index(){
        $this->display('User/index');
    }

    /**
     * 搜索后台管理员
     */
    public function ajaxUser(){
        $data = I('post.','',false);//获取搜索的数据
        $user = M('AdminUser');
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['username'] = array('like', '%' . $keywords . '%');
            $map['realname'] = array('like', '%' . $keywords . '%');
            $map["_logic"] = 'or';
        }
        $count = $user->where($map)->count();// 查询满足要求的总记录数
        $Page  = new  \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show  = $Page->show();// 分页显示输出
        $data = $user
            ->join('admin_group on admin_group.id = admin_user.grouping')
            ->where($map)->limit($Page->firstRow.','.$Page->listRows)
            ->field('admin_user.*,admin_group.title as groups')
            ->order('admin_user.id asc')
            ->select();
        $back['pagenum'] = $count;
        $back['pages'] = 20;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$data);
        $back['html'] = $this->fetch('User/ajaxUser');
        $this->ajaxReturn($back);
    }

    /**
     * 修改状态
     */
    public function updateStatus(){
        $data = I('post.','',false);
        $id = $data['id'];
        $status = $data['status'];
        $user = new UserApi();
        $result = $user->updateUserStatus($id,array('status'=>$status));
        if($result){
            $back['rel'] = 1;
            $back['msg'] = GSL('update-success');
        }else{
            $back['rel'] = 2;
            $back['msg'] = GSL('update-failure');
        }
        $this->ajaxReturn($back);
    }

    /**
     * 创建后台管理员账户页面
     */
    public function createUser(){
        $group = M('AdminGroup');
        $groups = $group->select();
        $this->assign('group',$groups);
        $this->display('User/createUser');
    }

    /**
     * 上传头像
     */
    public function handleUpload(){
        $file = $_FILES['file'];
        if($file == ''){
            $res = array(
                'code' => -1,
                'msg'  =>GSL('please-select-file'). '...'
            );
        }else{
            $url = "./Uploads/head/";
            $info = uploadFile($file,$url,false);
            if(!$info) {
                $res['code'] = -1;
                $res['msg'] = GSL('Upload-failure');
            }else{
                $res['code'] = 0;
                $res['msg'] = GSL('Upload-success');
                $res['src'] = "/Uploads/head/".$info;// 上传成功 获取上传文件信息
            }
        }
        $this->ajaxReturn($res);
    }

    /**
     * 创建后台管理人员数据
     */
    public function createUserData(){
        $data = I('post.','',false);
        $user = new UserApi();
        $result = $user->createUser($data);
        $this->ajaxReturn($result);
    }

    /**
     *修改管理员的账户信息
     * @param $id 管理员的id
     */
    public function updateUser($id){
        $user = M('AdminUser');
        $info = $user->where('id='.$id)->find();
        $group = M('AdminGroup');
        $data = $group->select();
        $this->assign('data',$data);
        $this->assign('info',$info);
        $this->display('User/updateUser');
    }

    /**
     * 修改后台管理人员的数据
     */
    public function updateUserData(){
        $data = I('post.','',false);
        $id = $data['id'];
        $saveData = array(
            'username'=>$data['username'],
            'realname'=>$data['realname'],
            'phone'=>$data['phone'],
            'email'=>$data['email'],
            'image'=>$data['image'],
            'qq'=>$data['qq'],
            'wechat'=>$data['wechat'],
            'describe'=>$data['describe'],
            'status'=>$data['status'],
            'grouping'=>$data['grouping'],
        );
        $user = new UserApi();
        $result = $user->updateUser($id,$saveData);
        $this->ajaxReturn($result);
    }

    /**
     * 超级管理员可以在后台直接登录其他账户
     */
    public function login(){
        $id = I('post.id');
        $user = M('AdminUser');
        $info = $user->where('id='.$id)->find();
        $data  = array(
            'id'=>$info['id'],
            'username'=>$info['username'],
            'realname'=>$info['realname'],
            'image'=>$info['image'],
            'grouping'=>$info['grouping'],
        );
        $_SESSION['admin'] = $data;
        header("location:/admin.php/Index/index.html");
    }

    /**
     * 修改密码的页面
     * @param $id
     */
    public function changePassword($id){
        $this->assign('id',$id);
        $this->display('User/changePassword');
    }

    /**
     * 修改密码数据
     */
    public function changePasswordData(){
        $data = I('post.','',false);
        $id = $data['id'];
        $password = $data['password'];
        $user = new UserApi();
        $result = $user->changePassword($id,$password);
        $this->ajaxReturn($result);
    }
}