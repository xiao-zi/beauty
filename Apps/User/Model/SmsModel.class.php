<?php
namespace User\Model;
use Think\Model;

class SmsModel extends Model{

	protected $trueTableName = 'sms_log';

	/**
	 * 搜索短信发送消息
	 * @param $where
	 * @param $order
	 * @param $limit
	 * @return mixed
	 */
	public function selectSMS($where,$order,$limit){
		$result = $this->where($where)->order($order)->limit($limit)->select();
		return $result;
	}
	/**
	 * 创建操作，创建新的权限组
	 */
	public function createSMS($data){
		$rule = array(
			'phone_code'=>array(
				array('request','',GSL('Mobile-phone-must-selected')),
				array('select','86,1,886,850,852,61,64,44,34,39,33,49,32,41',GSL('Mobile-phone-selected')),
			),
			'phone'=>array(
				array('request','',GSL('mobile-phone-must-filled')),
			),
			'message'=>array(
				array('request','',GSL('Content-must-filled')),
			),
			'status'=>array(
				array('select','0',GSL('Content-must-filled')),
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
	 * 统计查询结果
	 * @param $where
	 * @return mixed
	 */
	public function countSMS($where){
		$count = $this->where($where)->count();
		return $count;
	}
	/**
	 * 查询指定的唯一的数据
	 * @param $where
	 * @param $order
	 * @return mixed
	 */
	public function findSMS($where,$order){
		$result = $this->where($where)->order($order)->find();
		return $result;
	}

	/**
	 * 修改操作，修改权限组
	 */
	public function updateSMS($where,$data){
		$result = $this->where($where)->save($data);
		return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
	}
}


?>