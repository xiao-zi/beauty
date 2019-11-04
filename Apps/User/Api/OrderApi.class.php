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
use User\Model\OrderModel;

class OrderApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new OrderModel();
    }

    /**
     * 订单总数统计
     * @param $where
     */
    public function OrderCount($where){
        return $this->model->OrderCount($where);
    }
    /**
     * 查询订单表的信息
     * @param $where 条件
     * @param $order 排序
     * @param $limit 查询个数
     * @param $filed 查询字段
     * @return mixed
     */
    public function OrderSelect($where,$order,$limit,$field){
        return $this->model->OrderSelect($where,$order,$limit,$field);
    }

    /**
     * 创建新的订单
     * @param $data
     * @return mixed
     */
    public function OrderCreate($data){
        return $this->model->OrderCreate($data);
    }


}
