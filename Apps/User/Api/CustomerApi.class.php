<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11 0011
 * Time: 10:42
 */

namespace User\Api;
use Think\Model;
use User\Model\CustomerModel;

class CustomerApi extends Api
{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new CustomerModel();
    }

    /**
     * 创建用户
     * @param $data
     * @return mixed
     */
    public function createCustomer($data){
        return $this->model->createCustomer($data);
    }

    /**
     * 查询用户群组
     * @param $where 条件
     * @param $order 排序
     * @param $limit 分页
     * @param $field 查询的字段
     * @return mixed
     */
    public function selectCustomer($where,$order,$limit,$field){
        return $this->model->selectCustomer($where,$order,$limit,$field);
    }

    /**
     * 查询用户信息
     * @param $where
     * @param $field
     * @return mixed
     */
    public function findCustomer($where,$field){
        return $this->model->findCustomer($where,$field);
    }

    /**
     * 修改用户数据
     * @param $where 条件
     * @param $data 修改的数据
     */
    public function updateCustomer($where,$data){
        return $this->model->updateCustomer($where,$data);
    }
}