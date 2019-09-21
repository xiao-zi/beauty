<?php

namespace User\Model;
use Think\Model;


class LanguageModel extends Model{

	protected $trueTableName = 'admin_language';


	/**
	 * 创建操作，创建新的权限组
	 */
	public function createLanguage($data){
		//验证条件
		$rule = array(
			'model'=>array(
				array('unique','',GSL('model').' '.GSL('must-be-unique')),
				array('request','',GSL('model').' '.GSL('must-fill-in')),
				array('regular','/[\s\S]*/',GSL('model').' '.GSL('Non-conformity')),
			),
			'chinese'=>array(
				array('request','',GSL('chinese').' '.GSL('must-fill-in')),
			),
			'english'=>array(
				array('request','',GSL('english').' '.GSL('must-fill-in')),
			)
		);
		/**
		 * 验证数据是否正确
		 */
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$data['english'] = ' '.$data['english'];
			$data['create_time'] = date("Y-m-d H:i:s",time());
			$data['update_time'] = date("Y-m-d H:i:s",time());
			$result = $this->add($data);
			$this->updateLanguageS();
			return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 修改操作，修改权限组
	 */
	public function updateLanguage($id,$data){
		//验证条件
		$rule = array(
			'model'=>array(
				array('request','',GSL('model').' '.GSL('must-fill-in')),
				array('regular','/[\s\S]*/',GSL('model').' '.GSL('Non-conformity')),
			),
			'chinese'=>array(
				array('request','',GSL('chinese').' '.GSL('must-fill-in')),
			),
			'english'=>array(
				array('request','',GSL('english').' '.GSL('must-fill-in')),
			)
		);
		$back = Verification($this,$rule,$data,true);
		if(!$back){
			$data['update_time'] = date("Y-m-d H:i:s",time());
			$result = $this->where(array('id'=>$id))->save($data);
			$this->updateLanguageS();
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 更新语言系统缓存
	 */
	public function updateLanguageS(){
		//设置路径目录信息
		$url = './json/language.json';
		//删除语言json文件
		unlink($url);
		readLanguage();
	}

}


?>