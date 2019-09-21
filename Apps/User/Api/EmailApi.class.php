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
use User\Model\EmailModel;

class EmailApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new EmailModel();
    }

    /**
     * 搜索邮箱发送消息
     * @param $where
     * @param $order
     * @param $limit
     * @return mixed
     */
    public function selectEmail($where,$order,$limit){
        return $this->model->selectEmail($where,$order,$limit);
    }

    /**
     * 创建操作，创建新的权限组
     */
    public function createEmail($data){
        return $this->model->createEmail($data);
    }
    /**
     * 修改操作，修改权限组
     */
    public function updateEmail($where,$data){
        return $this->model->updateEmail($where,$data);
    }
    /**
     * 统计查询结果
     * @param $where
     * @return mixed
     */
    public function countEmail($where){
        return $this->model->countEmail($where);
    }

    /**
     * 查询指定的唯一的数据
     * @param $where
     * @param $order
     * @return mixed
     */
    public function findEmail($where,$order){
        return $this->model->findEmail($where,$order);
    }

}
