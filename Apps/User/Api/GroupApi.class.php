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
use User\Model\GroupModel;

class GroupApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new GroupModel();
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
    public function update($id,$data){
        return $this->model->update($id,$data);
    }
}
