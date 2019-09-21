<?php
namespace User\Model;
use Think\Model;

class CategoryModel extends Model{

	protected $trueTableName = 'category';

	/**
	 * 分类的搜索
	 * @param $where
	 * @param $order
	 * @param $limit
	 * @param $field
	 * @return mixed
	 */
	public function CategorySelect($where,$order,$limit,$field){
		$data = $this->where($where)->order($order)->limit($limit)->field($field)->select();
		return $data;
	}

	/**
	 * 分类的查询
	 * @param $where
	 * @param $field
	 * @return mixed
	 */
	public function CategoryFind($where,$field){
		$data = $this->where($where)->field($field)->find();
		return $data;
	}

	/**
	 * 创建分类
	 * @param $data
	 * @return array
	 */
	public function CategoryCreate($data){
		$rule = array(
			'chinese'=>array(
				array('request','',GSL('chinese-must-fill')),
			),
			'english'=>array(
				array('request','',GSL('english-must-fill')),
			),
			'status'=>array(
				array('select','defaulted,activation',GSL('please-status')),
			),
			'type'=>array(
				array('select','1,2,3,4',GSL('please-type')),
			),
		);
		//验证字段
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$data['created_time'] = date("Y-m-d H:i:s",time());
			$data['updated_time'] = date("Y-m-d H:i:s",time());
			$result = $this->add($data);
			return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 修改分类
	 * @param $data
	 * @return array
	 */
	public function CategoryUpdate($where,$data){
		$rule = array(
			'chinese'=>array(
				array('request','',GSL('chinese-must-fill')),
			),
			'english'=>array(
				array('request','',GSL('english-must-fill')),
			),
			'status'=>array(
				array('select','defaulted,activation',GSL('please-status')),
			),
			'type'=>array(
				array('select','1,2,3,4',GSL('please-type')),
			),
		);
		//验证字段
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$data['updated_time'] = date("Y-m-d H:i:s",time());
			$result = $this->where($where)->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 修改分类状态
	 * @param $where
	 * @param $status
	 * @return array
	 */
	public function CategoryStatus($where,$status){
		$rule = array(
			'status'=>array(
				array('select','defaulted,activation',GSL('please-status')),
			),
		);
		//验证字段
		$back = Verification($this,$rule,$status,true);
		if(!$back){
			$data['updated_time'] = date("Y-m-d H:i:s",time());
			$result = $this->where($where)->save($status);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}
}


?>