<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/18 0018
 * Time: 14:10
 */
namespace User\Model;
use Think\Model;

class ProductModel extends Model{
    protected $trueTableName = 'product';

    /**
     * 查询产品表的信息
     * @param $where 条件
     * @param $order 排序
     * @param $limit 查询个数
     * @param $filed 查询字段
     * @return mixed
     */
    public function selectProduct($where,$order,$limit,$field){
        $result = $this->where($where)->order($order)->limit($limit)->field($field)->select();
        return $result;
    }
    /**
     * 查询产品信息
     * @param $where
     * @param $filed
     * @return mixed
     */
    public function findProduct($where,$field){
        $data = $this->where($where)->field($field)->find();
        return $data;
    }
    /**
     * 添加产品数据
     * @param $data
     * @return mixed
     */
    public function createProduct($data){
        $rule = array(
            'chinese'=>array(
                array('unique','',GSL('chinese-not-repeat')),
                array('request','',GSL('please-input-Chinese-title')),
            ),
            'english'=>array(
                array('unique','',GSL('english-not-repeat')),
                array('request','',GSL('please-input-English-title')),
            ),
            'price'=>array(
                array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
            ),
            'status'=>array(
                array('select','defaulted,activation',GSL('please-status')),
            ),
            'category'=>array(
                array('regular','/^\d+$/',GSL('Please-choose-category')),
            )
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
     * 修改产品信息
     * @param $where 条件
     * @param $data 数据
     * @return mixed
     */
    public function updateProduct($where,$data){
        $rule = array(
            'chinese'=>array(
                array('request','',GSL('please-input-Chinese-title')),
            ),
            'english'=>array(
                array('request','',GSL('please-input-English-title')),
            ),
            'price'=>array(
                array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
            ),
            'status'=>array(
                array('select','defaulted,activation',GSL('please-status')),
            ),
            'category'=>array(
                array('regular','/^\d+$/',GSL('Please-choose-category')),
            )
        );
        /**
         * 验证数据是否正确
         */
        $back = Verification($this,$rule,$data,true);
        if(!$back){
            $result = $this->where($where)->save($data);
            return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
        }else{
            return $back = array('rel'=>0,'msg'=>$back);
        }
    }

    /**
     * 修改产品状态
     * @param $where
     * @param $status
     * @return array
     */
    public function ProductStatus($where,$status){
        $rule = array(
            'status'=>array(
                array('select','defaulted,activation',GSL('please-status')),
            ),
        );
        //验证字段
        $back = Verification($this,$rule,$status,true);
        if(!$back){

            $result = $this->where($where)->save($status);
            return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
        }else{
            return $back = array('rel'=>0,'msg'=>$back);
        }
    }

}