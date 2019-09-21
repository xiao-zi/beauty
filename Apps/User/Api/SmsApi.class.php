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
use User\Model\SmsModel;

class SmsApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new SmsModel();
    }
    /**
     * 搜索短信发送消息
     * @param $where
     * @param $order
     * @param $limit
     * @return mixed
     */
    public function selectSMS($where,$order,$limit){
        return $this->model->selectSMS($where,$order,$limit);
    }
    /**
     * 创建操作，创建新的权限组
     */
    public function createSMS($data){
        return $this->model->createSMS($data);
    }
    /**
     * 修改操作，修改权限组
     */
    public function updateSMS($where,$data){
        return $this->model->updateSMS($where,$data);
    }
    /**
     * 统计查询结果
     * @param $where
     * @return mixed
     */
    public function countSMS($where){
        return $this->model->countSMS($where);
    }

    /**
     * 查询指定的唯一的数据
     * @param $where
     * @param $order
     * @return mixed
     */
    public function findSMS($where,$order){
        return $this->model->findSMS($where,$order);
    }

}
