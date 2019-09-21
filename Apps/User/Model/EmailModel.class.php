<?php
namespace User\Model;
use Think\Model;

class EmailModel extends Model{

	protected $trueTableName = 'email_log';

	/**
	 * 搜索邮箱发送消息
	 * @param $where
	 * @param $order
	 * @param $limit
	 * @return mixed
	 */
	public function selectEmail($where,$order,$limit){
		$result = $this->where($where)->order($order)->limit($limit)->select();
		return $result;
	}
	/**
	 * 创建操作，创建新的权限组
	 */
	public function createEmail($data){
		$rule = array(
			'email'=>array(
				array('request','',GSL('email').' '.GSL('must-fill-in')),
				array('regular','/^\w+([-.]\w+)*@\w+([-]\w+)*\.(\w+([-]\w+)*\.)*[a-z]{2,3}$/',GSL('email').' '.GSL('Non-conformity')),
			),
			'content'=>array(
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
	public function countEmail($where){
		$count = $this->where($where)->count();
		return $count;
	}
	/**
	 * 查询指定的唯一的数据
	 * @param $where
	 * @param $order
	 * @return mixed
	 */
	public function findEmail($where,$order){
		$result = $this->where($where)->order($order)->find();
		return $result;
	}

	/**
	 * 修改操作，修改权限组
	 */
	public function updateEmail($where,$data){
		$result = $this->where($where)->save($data);
		return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
	}
}


?>