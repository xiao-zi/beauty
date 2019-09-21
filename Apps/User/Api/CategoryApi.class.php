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
use User\Model\CategoryModel;

class CategoryApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new CategoryModel();
    }

    /**
     * 分类的搜索
     * @param $where 条件
     * @param $order 排序
     * @param $limit 查询数量
     * @return mixed
     */
    public function CategorySelect($where='',$order='',$limit='',$field=''){
        return $this->model->CategorySelect($where,$order,$limit,$field);
    }

    /**
     * 分类的查询
     * @param string $where
     * @return mixed
     */
    public function CategoryFind($where='',$field=''){
        return $this->model->CategoryFind($where,$field);
    }

    /**
     * 分类的创建
     * @param $data
     * @return mixed
     */
    public function CategoryCreate($data){
        return $this->model->CategoryCreate($data);
    }

    /**
     * 分类的修改
     * @param $where 条件
     * @param $data 修改的数据
     * @return mixed
     */
    public function CategoryUpdate($where,$data){
        return $this->model->CategoryUpdate($where,$data);
    }

    /**
     * 修改分类状态
     * @param $where
     * @param $status
     * @return mixed
     */
    public function CategoryStatus($where,$status){
        return $this->model->CategoryStatus($where,$status);
    }
}
