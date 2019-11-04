<?php
namespace User\Model;
use Think\Model;

class PackageModel extends Model{

	protected $trueTableName = 'package';

	protected $customerPackage;

	protected $payment;

	protected function _initialize(){
		$this->customerPackage = M('customerPackage');
		$this->payment = M('payment');
	}
	/**
	 * @param $where
	 * @return mixed
	 */
	public function packageFind($where){
		$data = $this->where($where)->find();
		return $data;
	}
	/**
	 * @param string $where 条件
	 * @param string $order 排序
	 * @param string $limit 几条数据
	 * @param string $field 字段
	 * @return mixed
	 */
	public function packageSelect($where,$order,$limit,$field){
		$data = $this->where($where)->order($order)->limit($limit)->field($field)->select();
		return $data;
	}

	/**
	 * 创建套餐
	 * @param $data
	 * @return array
	 */
	public function packageCreate($data){
		$rule = array(
			'chinese'=>array(
				array('unique','',GSL('chinese-not-repeat')),
				array('request','',GSL('please-input-Chinese-title')),
			),
			'english'=>array(
				array('unique','',GSL('english-not-repeat')),
				array('request','',GSL('please-input-English-title')),
			),
			'original'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
			'present'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
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
	 * 修改套餐
	 * @param $where
	 * @param $data
	 * @return array
	 */
	public function packageUpdate($where,$data){
		$rule = array(
			'chinese'=>array(
				array('request','',GSL('please-input-Chinese-title')),
			),
			'english'=>array(
				array('request','',GSL('please-input-English-title')),
			),
			'original'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
			'present'=>array(
				array('regular','/\d+\.?\d{0,2}/',GSL('Please-fill-in-price')),
			),
		);
		/**
		 * 验证数据是否正确
		 */
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$result = $this->where($where)->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 根据条件删除套餐
	 * @param $where
	 * @return array
	 */
	public function packageDelete($where){
		$result = $this->where($where)->delete();
		if($result){
			return $back = array('rel'=>$result,'msg'=>GSL('Successful-deletion'));
		}else{
			return $back = array('rel'=>0,'msg'=>GSL('Delete-failed'));
		}
	}
	/**
	 * @param string $where 条件
	 * @param string $order 排序
	 * @param string $limit 几条数据
	 * @param string $field 字段
	 * @return mixed
	 */
	public function CustomerPackageSelect($where,$order,$limit,$field){
		$data = $this->customerPackage->where($where)->order($order)->limit($limit)->field($field)->select();
		return $data;
	}

	/**
	 * 客户购买套餐操作
	 * @param $data
	 * @return int|mixed
	 */
	public function CustomerPackage($data){
		$rule = array(
			'pid'=>array(
				array('request','',GSL('Please-select-package')),
			),
			'payid'=>array(
				array('request','',GSL('Please-select-payment')),
			),
		);
		/**
		 * 验证数据是否正确
		 */
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$result = M('customerPackage')->add($data);
			if($result){
				return $result;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	/**
	 * 用户和套餐的联动
	 * @param $cid 用户的ID
	 * @return mixed
	 */
	public function getCustomerPackage($cid,$field){
		//payment.status 1：未到账，2：已到账
		$where = ' (customer_package.cid = '.$cid.' AND payment.status = 2 AND customer_package.residue != 0 AND ( customer_package.over_at >'.time().' or customer_package.over_at = 0))';
		$data = $this->customerPackage
			->join('package ON package.id = customer_package.pid')
			->join('payment ON payment.id = customer_package.payid')
			->where($where)
			->field($field)
			->select();
		return $data;
	}
	/**
	 * 查看用户套餐详情
	 * @param $where
	 * @return mixed
	 */
	public function FindCustomerPackage($where){
		$result = $this->customerPackage->where($where)->find();
		return $result;
	}

	/**
	 * 删除用户套餐列表并且删除支付记录
	 * @param $where 条件
	 */
	public function delCustomerPackage($where){
		//开始事务
		$model = new Model();
		$model->startTrans();
		$payID = $this->customerPackage->where($where)->getField('payid');
		$result1 = $this->customerPackage->where($where)->delete();
		$result2 = $this->payment->where(array('id'=>$payID))->delete();
		if($result1 && $result2){
			//成功则提交
			$model->commit();
			return $back = array('rel'=>1,'msg'=>GSL('Successful-deletion'));
		}else{
			//失败则回滚
			$model->rollback();
			return $back = array('rel'=>0,'msg'=>GSL('Delete-failed'));
		}
	}
}


?>