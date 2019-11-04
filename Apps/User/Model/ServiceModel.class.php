<?php
namespace User\Model;
use Think\Model;

class ServiceModel extends Model{

	protected $trueTableName = 'service';

	/**
	 * 创建技师的服务项目数据
	 * @param $data
	 */
	public function createService($data)
	{
		$result = $this->add($data);
		return $result;
	}
}


?>