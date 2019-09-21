<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23 0023
 * Time: 16:25
 */

namespace User\Model;


use Think\Model;

class ReservationModel extends Model
{
    //预订表
    protected $trueTableName = 'reservation';

    /**
     * 查询预订表的信息
     * @param $where 条件
     * @param $order 排序
     * @param $limit 查询个数
     * @param $filed 查询字段
     * @return mixed
     */
    public function selectReservation($where,$order,$limit,$field){
        $data = $this->where($where)->order($order)->limit($limit)->field($field)->select();
        return $data;
    }
    /**
     * 查询预订信息
     * @param $where
     * @param $filed
     * @return mixed
     */
    public function findReservation($where,$field){
        $data = $this->where($where)->field($field)->find();
        return $data;
    }

    public function createReservation($data){
        $rule = array(
            'first_name'=>array(
                array('request','',GSL('Name-must-be-filled-in')),
            ),
            'last_name'=>array(
                array('request','',GSL('Name-must-be-filled-in')),
            ),
            'product'=>array(
                array('request','',GSL('Please-choose-the-product')),
            ),
            'phoneCode'=>array(
                array('request','',GSL('Mobile-phone-must-selected')),
                array('select','86,1,886,850,852,61,64,44,34,39,33,49,32,41',GSL('Mobile-phone-selected')),
            ),
            'phone'=>array(
                array('request','',GSL('mobile-phone-must-filled')),
            ),
            'email'=>array(
                array('request','',GSL('email').' '.GSL('must-fill-in')),
                array('regular','/^\w+([-.]\w+)*@\w+([-]\w+)*\.(\w+([-]\w+)*\.)*[a-z]{2,3}$/',GSL('email').' '.GSL('Non-conformity')),
            ),
            'date'=>array(
                array('request','',GSL('Please-choose-date')),
            ),
            'time'=>array(
                array('request','',GSL('Please-choose-time')),
            ),
        );
        /**
         * 验证数据是否正确
         */
        $back = Verification($this,$rule,$data,true);
        if(!$back){
            $result = $this->add($data);
            return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
        }else{
            return $back = array('rel'=>0,'msg'=>$back);
        }
    }
    /**
     * 修改预订数据
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateReservation($where,$data){
        $rule = array(
            'first_name'=>array(
                array('request','',GSL('Name-must-be-filled-in')),
            ),
            'last_name'=>array(
                array('request','',GSL('Name-must-be-filled-in')),
            ),
            'product'=>array(
                array('request','',GSL('Please-choose-the-product')),
            ),
            'phoneCode'=>array(
                array('request','',GSL('Mobile-phone-must-selected')),
                array('select','86,1,886,850,852,61,64,44,34,39,33,49,32,41',GSL('Mobile-phone-selected')),
            ),
            'phone'=>array(
                array('request','',GSL('mobile-phone-must-filled')),
            ),
            'email'=>array(
                array('request','',GSL('email').' '.GSL('must-fill-in')),
                array('regular','/^\w+([-.]\w+)*@\w+([-]\w+)*\.(\w+([-]\w+)*\.)*[a-z]{2,3}$/',GSL('email').' '.GSL('Non-conformity')),
            ),
            'date'=>array(
                array('request','',GSL('Please-choose-date')),
            ),
            'time'=>array(
                array('request','',GSL('Please-choose-time')),
            ),
        );
        //验证字段
        $back = Verification($this,$rule,$data,true);
        if(!$back){
            $result = $this->where($where)->save($data);
            return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
        }else{
            return $back = array('rel'=>0,'msg'=>$back);
        }
    }

    /**
     * @param $where
     * @param $data
     * @return array
     */
    public function updateReservationRemark($where,$data){
        $result = $this->where($where)->save($data);
        return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
    }
    /**
     * 修改预订的状态
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateReservationStatus($where,$data){
        $rule = array(
            'status'=>array(
                array('select','0,1,2',GSL('please-status')),
            ),
        );
        //验证字段
        $back = Verification($this,$rule,$data,true);
        if(!$back){
            $result = $this->where($where)->save($data);
            return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
        }else{
            return $back = array('rel'=>0,'msg'=>$back);
        }
    }

}