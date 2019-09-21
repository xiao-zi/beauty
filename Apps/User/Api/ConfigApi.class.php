<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace User\Api;
use User\Api\Api;
use User\Model\ConfigModel;

class ConfigApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new ConfigModel();
    }

    /**
     * 创建操作，创建新的权限组
     */
    public function create($data){
        return $this->model->create($data);
    }
    /**
     * 修改操作，修改权限组
     */
    public function updateConfig($id,$data){
        return $this->model->updateConfig($id,$data);
    }

    /**
     * 修改配置项的一些特殊配置
     * @param $data
     * @return mixed
     */
    public function updateSpecialConfig($data){
        return $this->model->updateSpecialConfig($data);
    }
}
