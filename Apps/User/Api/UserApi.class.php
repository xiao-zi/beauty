<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace User\Api;
use User\Api\Api;
use User\Model\UserModel;

class UserApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new UserModel();
    }
    /**
     * 后台登录操作
     * @param $username
     * @param $password
     * @param $check
     * @return mixed
     */
    public function login($username,$password,$check){
        return $this->model->login($username,$password,$check);
    }

    /**
     * 查找后台管理人员信息
     * @param $where
     * @param $order
     * @param $limit
     * @param $field
     * @return mixed
     */
    public function selectUser($where,$order,$limit,$field){
        return $this->model->selectUser($where,$order,$limit,$field);
    }

    /**
     * 修改后台管理员状态信息
     * @param $id 修改的id
     * @param $arr 修改的数据
     * @return mixed
     */
    public function updateUserStatus($id,$data){
        return $this->model->updateUserStatus($id,$data);
    }
    /**
     * 添加后台管理员信息
     * @param $data 添加的数据
     * @return mixed
     */
    public function createUser($data){
        return $this->model->createUser($data);
    }
    /**
     * 修改后台管理员信息
     * @param $id 修改的id
     * @param $arr 修改的数据
     * @return mixed
     */
    public function updateUser($id,$data){
        return $this->model->updateUser($id,$data);
    }
    /**
     * 后台管理员修改密码
     */
    public function changePassword($id,$password){
        return $this->model->changePassword($id,$password);
    }

}
