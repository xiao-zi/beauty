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
use User\Model\PackageModel;

class PackageApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new PackageModel();
    }

    /**
     * @param $where
     * @return mixed
     */
    public function packageFind($where){
        return $this->model->packageFind($where);
    }
    /**
     * @param string $where 条件
     * @param string $order 排序
     * @param string $limit 几条数据
     * @param string $field 字段
     * @return mixed
     */
    public function packageSelect($where='',$order='',$limit='',$field=''){
        return $this->model->packageSelect($where,$order,$limit,$field);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function packageCreate($data){
        return $this->model->packageCreate($data);
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     */
    public function packageUpdate($where,$data){
        return $this->model->packageUpdate($where,$data);
    }

    /**
     * @param $where
     * @return mixed
     */
    public function packageDelete($where){
        return $this->model->packageDelete($where);
    }

    public function CustomerPackageSelect($where,$order='',$limit='',$field=''){
        return $this->model->CustomerPackageSelect($where,$order,$limit,$field);
    }

    /**
     * 客户购买套餐操作
     * @param $data
     */
    public function CustomerPackage($data){
        return $this->model->CustomerPackage($data);
    }

    /**
     * 用户和套餐的联动
     * @param $cid 用户的ID
     * @return mixed
     */
    public function getCustomerPackage($cid,$field){
        return $this->model->getCustomerPackage($cid,$field);
    }

    /**
     * 查看用户套餐详情
     * @param $where
     * @return mixed
     */
    public function FindCustomerPackage($where){
        return $this->model->FindCustomerPackage($where);
    }

    /**
     * 删除用户套餐列表并且删除支付记录
     * @param $where 条件
     */
    public function delCustomerPackage($where){
        return $this->model->delCustomerPackage($where);
    }
}
