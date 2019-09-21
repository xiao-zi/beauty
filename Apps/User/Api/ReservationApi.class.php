<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23 0023
 * Time: 16:20
 */

namespace User\Api;
use User\Api\Api;
use User\Model\ReservationModel;

class ReservationApi extends Api{
    protected function  _init(){
        $this->model = new ReservationModel();
    }

    /**
     * 创建预订数据
     * @param $data
     * @return mixed
     */
    public function createReservation($data){
        return $this->model->createReservation($data);
    }

    /**
     * 修改预订数据
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateReservation($where,$data){
        return $this->model->updateReservation($where,$data);
    }

    /**
     *修改备注
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateReservationRemark($where,$data){
        return $this->model->updateReservationRemark($where,$data);
    }

    /**
     * 修改预订的状态
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateReservationStatus($where,$data){
        return $this->model->updateReservationStatus($where,$data);
    }

    /**
     * 查询预订列表数据
     * @param $where
     * @param $order
     * @param $limit
     * @param $field
     * @return mixed
     */
    public function selectReservation($where,$order,$limit,$field){
        return $this->model->selectReservation($where,$order,$limit,$field);
    }

    /**
     * 查询单一的预订数据
     * @param $where
     * @param $field
     * @return mixed
     */
    public function findReservation($where,$field){
        return $this->model->findReservation($where,$field);
    }

}