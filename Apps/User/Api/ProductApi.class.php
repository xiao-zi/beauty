<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/18 0018
 * Time: 14:09
 */

namespace User\Api;
use User\Api\Api;
use User\Model\ProductModel;


class ProductApi extends Api
{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new ProductModel();
    }

    /**
     * 查询产品表的信息
     * @param $where 条件
     * @param $order 排序
     * @param $limit 查询个数
     * @param $filed 查询字段
     * @return mixed
     */
    public function selectProduct($where,$order,$limit,$filed){
        return $this->model->selectProduct($where,$order,$limit,$filed);
    }

    /**
     * 查询产品信息
     * @param $where
     * @param $filed
     * @return mixed
     */
    public function findProduct($where,$filed){
        return $this->model->findProduct($where,$filed);
    }
    /**
     * 添加产品数据
     * @param $data
     * @return mixed
     */
    public function createProduct($data){
        return $this->model->createProduct($data);
    }

    /**
     * 修改产品信息
     * @param $where 条件
     * @param $data 数据
     * @return mixed
     */
    public function updateProduct($where,$data){
        return $this->model->updateProduct($where,$data);
    }

    /**
     * 修改产品状态
     * @param $where
     * @param $status
     * @return mixed
     */
    public function productStatus($where,$status){
        return $this->model->ProductStatus($where,$status);
    }
}