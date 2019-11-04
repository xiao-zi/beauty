<?php
namespace User\Model;
use Think\Model;

class PaymentModel extends Model{

	protected $trueTableName = 'payment';


	/**
	 * 创建操作，创建新的权限组
	 */
	public function createPayment($data){
		$rule = array(
			'sn'=>array(
				array('request','',GSL('chinese-must-fill')),
				array('unique','',GSL('CarkUnique')),
			),
			'cid'=>array(
				array('request','',GSL('Please-select-customers')),
			),
			'money'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
			'type'=>array(
				array('select','1,2,3,4',GSL('Please-select-payment')),
			),
			'mode'=>array(
				array('select','1,2,3',GSL('Please-select-payment')),
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
	 * 查看支付详情
	 * @param $where
	 * @return mixed
	 */
	public function findPayment($where){
		$result = $this->where($where)->find();
		return $result;
	}




}


?>