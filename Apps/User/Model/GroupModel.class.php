<?php
namespace User\Model;
use Think\Model;

class GroupModel extends Model{

	protected $trueTableName = 'admin_group';


	/**
	 * 创建操作，创建新的权限组
	 */
	public function create($data){
		$rule = array(
			'module'=>array(
				array('unique','',GSL('english-not-repeat')),
				array('request','',GSL('english-must-fill')),
				array('regular','/^[a-zA-Z]+([a-zA-Z]|\s)*$/',GSL('english-must-letters')),
			),
			'title'=>array(
				array('request','',GSL('chinese-must-fill')),
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
	 * 修改操作，修改权限组
	 */
	public function update($id,$data){
		/**
		 * 验证数据是否正确
		 */
		$rule = array(
			'module'=>array(
				array('request','',GSL('english-must-fill')),
				array('regular','/^[a-zA-Z]+([a-zA-Z]|\s)*$/',GSL('english-must-letters')),
			),
			'title'=>array(
				array('request','',GSL('chinese-must-fill')),
			),
		);
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$result = $this->where(array('id'=>$id))->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}
}


?>