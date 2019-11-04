<?php
namespace User\Model;
use Think\Model;

class OrderModel extends Model{

	protected $trueTableName = 'order';
	/**
	 * 订单总数统计
	 * @param $where
	 */
	public function OrderCount($where){
		return $this->where($where)->count();
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
		$result = $this->where($where)->order($order)->limit($limit)->field($field)->select();
		return $result;
	}

	/**
	 * 添加订单数据
	 * @param $data
	 * @return mixed
	 */
	public function OrderCreate($data){
		$rule = array(
			'sn'=>array(
				array('request','',GSL('Order-Number-Error')),
			),
			'cid'=>array(
				array('request','',GSL('Please-enter-customer-information')),
			),
			'total'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
			'price'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
			'tip'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
			'payment'=>array(
				array('select','1,2,3',GSL('please-payment-mode')),
			),
			'status'=>array(
				array('select','1,2',GSL('please-payment-status')),
			),
			'content'=>array(
				array('request','',GSL('Please-enter-customer-order')),
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
}
?>