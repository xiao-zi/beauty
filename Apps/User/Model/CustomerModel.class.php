<?php
namespace User\Model;
use Think\Model;

class CustomerModel extends Model{

	protected $trueTableName = 'customer';

	/**
	 * 用户的搜索
	 * @param $where
	 * @param $order
	 * @param $limit
	 * @param $field
	 * @return mixed
	 */
	public function selectCustomer($where,$order,$limit,$field){
		$data = $this->where($where)->order($order)->limit($limit)->field($field)->select();
		return $data;
	}

	/**
	 * 用户的查询
	 * @param $where
	 * @param $field
	 * @return mixed
	 */
	public function findCustomer($where,$field){
		$data = $this->where($where)->field($field)->find();
		return $data;
	}

	/**
	 * 创建分类
	 * @param $data
	 * @return array
	 */
	public function createCustomer($data){
		$rule = array(
			'cartNum'=>array(
				array('request','',GSL('chinese-must-fill')),
				array('unique','',GSL('CarkUnique')),
			),
			'username'=>array(
				array('request','',GSL('username-must-filled')),
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
			'sex'=>array(
				array('select','male,female',GSL('Gender-selected-male-female')),
			),
			'ActivityLevel'=>array(
				array('select','active,inactive,masked',GSL('ActivityLevel')),
			),
			'source'=>array(
				array('request','',GSL('source-must-filled')),
			),
			'country'=>array(
				array('request','',GSL('country-must-filled')),
			),
			'type'=>array(
				array('request','',GSL('customer-type-must-filled')),
			),
		);
		//验证字段
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			//截取生日
			$data['birthday'] = substr($data['birth'],5);
			$data['register_time'] = date("Y-m-d H:i:s",time());
			$data['register_ip'] = get_client_ip();
			$data['login_time'] = date("Y-m-d H:i:s",time());
			$data['login_ip'] = get_client_ip();
			$result = $this->add($data);
			return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 修改用户
	 * @param $data
	 * @return array
	 */
	public function updateCustomer($where,$data){
		$rule = array(
			'username'=>array(
				array('request','',GSL('username-must-filled')),
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
			'sex'=>array(
				array('select','male,female',GSL('Gender-selected-male-female')),
			),
			'ActivityLevel'=>array(
				array('select','active,inactive,masked',GSL('ActivityLevel')),
			),
			'source'=>array(
				array('request','',GSL('source-must-filled')),
			),
			'country'=>array(
				array('request','',GSL('country-must-filled')),
			),
			'type'=>array(
				array('request','',GSL('customer-type-must-filled')),
			),
		);
		//验证字段
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$data['login_time'] = date("Y-m-d H:i:s",time());
			$data['login_ip'] = get_client_ip();
			$result = $this->where($where)->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}
}

?>