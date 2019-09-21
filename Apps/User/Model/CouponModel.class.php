<?php
namespace User\Model;
use Think\Model;

class CouponModel extends Model{

	protected $trueTableName = 'coupon';

	/**
	 * 搜索优惠券列表
	 * @param $where
	 * @param $order
	 * @param $limit
	 * @return mixed
	 */
	public function CouponSelect($where,$order,$limit,$field){
		$data = $this->where($where)->order($order)->limit($limit)->field($field)->select();
		return $data;
	}
	/**
	 * 创建操作，创建新的权限组
	 */
	public function CouponCreate($data){
		$rule = array(
			'title'=>array(
				array('request','',GSL('Title-must-be-filled-in')),
			),
			'type'=>array(
				array('select','1,2',GSL('coupon-type-error')),
			),
			'rule'=>array(
				array('request','',GSL('Rules-must-have')),
			),
			'start'=>array(
				array('request','',GSL('start-time')),
			),
			'end'=>array(
				array('request','',GSL('end-time')),
			)
		);
		/**
		 * 验证数据是否正确
		 */
		$back = Verification($this,$rule,$data,false);
		if(!$back){
			$result = $this->add($data);
			return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 查询指定的唯一的数据
	 * @param $where
	 * @param $order
	 * @return mixed
	 */
	public function CouponFind($where,$order){
		$result = $this->where($where)->order($order)->find();
		return $result;
	}

	/**
	 * 修改操作，修改权限组
	 */
	public function CouponUpdate($where,$data){
		$rule = array(
			'title'=>array(
				array('request','',GSL('Title-must-be-filled-in')),
			),
			'type'=>array(
				array('select','1,2',GSL('coupon-type-error')),
			),
			'rule'=>array(
				array('request','',GSL('Rules-must-have')),
			),
			'start'=>array(
				array('request','',GSL('start-time')),
			),
			'end'=>array(
				array('request','',GSL('end-time')),
			)
		);
		/**
		 * 验证数据是否正确
		 */
		$back = Verification($this,$rule,$data,false);
		if(!$back){
			$result = $this->where($where)->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 删除优惠券
	 * @param $id 优惠券的id
	 */
	public function deleteCoupon($id){
		//开始事务
		$model = new Model();
		$model->startTrans();
		//删除优惠券需要把之前赠送的该优惠券及它的使用记录全部删除
		$couponResult = $this->where('id='.$id)->delete();
		if($couponResult){
			$customerCoupon = M('customer_coupon');//用户和优惠券的关系表
			$map = array('coupon_id'=>$id);
			$customerCoupon->where($map)->delete();
		}
		if($couponResult){
			//成功则提交
			$model->commit();
			return array('rel'=>1,'msg'=>GSL('Successful-deletion'));
		}else{
			//失败则回滚
			$model->rollback();
			return array('rel'=>0,'msg'=>GSL('Delete-failed'));
		}
	}

	/**
	 * 赠送客户优惠券操作
	 * @param $id 优惠券id
	 * @param $arr 用户数组
	 * @return mixed 返回结果
	 */
	public function giveCoupon($id,$arr){
		$customer = M('Customer');
//		$idStr = implode(",", $arr);
//		$map = array(
//			'id'=>array('in',$idStr),
//		);
//		$customerData = $customer->where($map)->select();
		//开始事务
		$model = new Model();
		$model->startTrans();
		$customerCoupon = M('CustomerCoupon');
		$coupon = M('Coupon');
		for($i=0;$i<count($arr);$i++){
			$addData = array(
				'customer_id'=>$arr[$i],
				'coupon_id'=>$id,
				'status'=>1,
				'create_at'=>time()
			);
			$result = $customerCoupon->add($addData);
			if($result){
				$resultCoupon = $coupon->where('id =' . $id)->setInc('sum');
				if($resultCoupon){
					continue;
				}else{
					break;
				}
			}
		}
		if($resultCoupon){
			//成功则提交
			$model->commit();
			return array('rel'=>1,'msg'=>GSL('Successful-deletion'));
		}else{
			//失败则回滚
			$model->rollback();
			return array('rel'=>0,'msg'=>GSL('Delete-failed'));
		}
//		foreach($customerData as $key=>$value){
//
//		}
//		return $customerData;
	}
}


?>