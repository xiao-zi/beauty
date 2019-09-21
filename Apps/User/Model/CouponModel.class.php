<?php
namespace User\Model;
use admin\Controller\CommonController;
use Think\Model;
use User\Api\CustomerApi;

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
	 * 用户的优惠券
	 * @param string $where
	 * @param string $order
	 * @param string $limit
	 * @return mixed
	 */
	public function customerCoupon($where,$order,$limit){
		$CustomerCoupon = M('CustomerCoupon');
		$data = $CustomerCoupon->where($where)->order($order)->limit($limit)->select();
		return $data;
	}

	/**
	 * 赠送客户优惠券操作
	 * @param $id 优惠券id
	 * @param $arr 用户数组
	 * @return mixed 返回结果
	 */
	public function giveCoupon($id,$arr){
		//开始事务
		$model = new Model();
		$model->startTrans();
		$customerCoupon = M('CustomerCoupon');
		$coupon = M('Coupon');
		$customerApi = new CustomerApi();
		$common = new CommonController();
		//优惠券信息
		$couponInfo = $this->where(array('id'=>$id))->find();
		for($i=0;$i<count($arr);$i++){
			$addData = array(
				'customer_id'=>$arr[$i],
				'coupon_id'=>$id,
				'status'=>1,
				'create_at'=>time(),
				'over_time'=>$couponInfo['end']
			);
			$result = $customerCoupon->add($addData);
			if($result){
				$customer = $customerApi->findCustomer(array('id'=>$arr[$i]),'id,username,phoneCode,phone');
				$smsData = array(
					'phone_code'=>$customer['phonecode'],//手机号前缀
					'phone'=>$customer['phone'],//手机号
					'cid'=>$customer['id'],//客户的id
					'aid'=>session('admin.id'),//发送短信的人员
					'message'=>$this->give_coupon_message($id,$customer['id']),//短信内容
					'status'=>0,//状态 0 未发送，1发送成功 2发送失败
					'created_time'=>time(),
					'updated_time'=>time(),
				);
				$resultSms = $common->createSms($smsData);
				$resultCoupon = $coupon->where('id =' . $id)->setInc('sum');
				if($resultCoupon && $resultSms){
					continue;
				}else{
					break;
				}
			}
		}
		if($resultCoupon && $resultSms){
			//成功则提交
			$model->commit();
			return array('rel'=>1,'msg'=>GSL('create-success'));
		}else{
			//失败则回滚
			$model->rollback();
			return array('rel'=>0,'msg'=>GSL('fill-in-sent'));
		}
	}
	/**
	 * 获取配置文件中赠送优惠券的短信通知内容
	 * @param $coupon 优惠价id
	 * @param $customer 用户id
	 * @return mixed
	 */
	public function give_coupon_message($coupon,$customer){
		//优惠券信息
		$couponInfo = $this->where(array('id'=>$coupon))->find();
		//处理优惠券信息
		$time = date('Y-m-d',$couponInfo['start']).'~'.date('Y-m-d',$couponInfo['end']);
		/**1为立减，2：为打折**/
		$ruleStr = '';
		$rule = json_decode($couponInfo['rule'],true);
		if($couponInfo['type'] == 1){
			foreach($rule as $key=>$value){
				if($value['money'] == 0){
					$ruleStr .= '立减'.$value['discount'].C('MONEY');break;
				}else{
					$ruleStr .= '满'.$value['money'].C('MONEY'). '立减'.$value['discount'].C('MONEY').',';continue;
				}
			}
		}else{
			foreach($rule as $key=>$value){
				if($value['money'] == 0){
					$ruleStr .= $value['discount']/10 .'折';break;
				}else{
					$ruleStr .= '满'.$value['money'].C('MONEY'). '打'.$value['discount']/10 .'折'.',';continue;
				}
			}
		}
		//用户信息
		$customerApi = new CustomerApi();
		$customerInfo = $customerApi->findCustomer(array('id'=>$customer),'id,username,phoneCode,phone');
		//获取发送优惠券短信通知配置信息
		$config = C('SHORT_MESSAGE');
		$content = $config['GIVE_COUPON_MESSAGE'];
		$content = str_replace('#USER#',$customerInfo['username'],$content);//替换用户名
		$content = str_replace('#TIME#',$time,$content);//替换时间
		$content = str_replace('#CONTENT#',$ruleStr,$content);//替换内容
		$content = str_replace('#TITLE#',$couponInfo['title'],$content);//替换优惠券标题
		return $content;
	}
}


?>