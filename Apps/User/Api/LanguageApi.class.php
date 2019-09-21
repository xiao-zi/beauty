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
use User\Model\LanguageModel;

class LanguageApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new LanguageModel();
    }

    /**
     * 创建语言系统数据
     * @param $data
     * @return mixed
     */
    public function createLanguage($data){
        return $this->model->createLanguage($data);
    }

    /**
     * 修改语言系统数据
     * @param $data
     * @return mixed
     */
    public function updateLanguage($id,$data){
        return $this->model->updateLanguage($id,$data);
    }

}
