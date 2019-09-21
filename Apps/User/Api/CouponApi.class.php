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
use User\Model\CouponModel;

class CouponApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new CouponModel();
    }

    /**
     * 分类的搜索
     * @param $where 条件
     * @param $order 排序
     * @param $limit 查询数量
     * @return mixed
     */
    public function CouponSelect($where='',$order='',$limit='',$field=''){
        return $this->model->CouponSelect($where,$order,$limit,$field);
    }

    /**
     * 分类的查询
     * @param string $where
     * @return mixed
     */
    public function CouponFind($where='',$field=''){
        return $this->model->CouponFind($where,$field);
    }

    /**
     * 分类的创建
     * @param $data
     * @return mixed
     */
    public function CouponCreate($data){
        return $this->model->CouponCreate($data);
    }

    /**
     * 分类的修改
     * @param $where 条件
     * @param $data 修改的数据
     * @return mixed
     */
    public function CouponUpdate($where,$data){
        return $this->model->CouponUpdate($where,$data);
    }

    /**
     * 删除优惠券
     * @param $id
     */
    public function deleteCoupon($id){
        return $this->model->deleteCoupon($id);
    }

    /**
     * 赠送客户优惠券操作
     * @param $id 优惠券id
     * @param $arr 用户数组
     * @return mixed 返回结果
     */
    public function giveCoupon($id,$arr){
        return $this->model->giveCoupon($id,$arr);
    }

    /**
     * 用户的优惠券
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return mixed
     */
    public function customerCoupon($where='',$order='',$limit=''){
        return $this->model->customerCoupon($where,$order,$limit);
    }


}
