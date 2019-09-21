<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\ConfigApi;

class ConfigController extends CommonController {
    /**
     * 后台配置的页面
     */
    public function index(){
        $config = M('AdminConfig');//后台配置数据库
        $data = $config->order('create_time')->select();
        $this->assign('data',$data);
        $this->display('Config/index');
    }

    /**
     * 创建后台配置页面
     */
    public function createConfig(){
        $this->display('Config/createConfig');
    }

    /**
     * 检查后台配置的变量名是否使用过，确保每个变量都是唯一的
     */
    public function inspectVariable(){
        $variable = I('post.variable');//变量名称
        $config = M('AdminConfig');
        $result = $config->where(array('name'=>strtoupper($variable)))->find();
        if($result){
            $back['rel'] = 1;
            $back['msg'] = GSL('variable-exists');
        }else{
            $back['rel'] = 2;
            $back['msg'] = GSL('variable-not-exists');
        }
        $this->ajaxReturn($back);
    }

    /**
     * 添加后台配置数据
     */
    public function createConfigData(){
        $data = I('post.','',false);
        $createData = array(
            'title'=>$data['title'],
            'name'=>strtoupper($data['name']),//把字母全部转为大写
            'value'=>$data['value'],
            'describe'=>$data['describe'],
            'create_time'=>date("Y-m-d H:i:s",time()),
            'update_time'=>date("Y-m-d H:i:s",time()),
        );
        $config = M('AdminConfig');
        $result = $config->add($createData);
        if($result){
            $back['rel'] = 1;
            $back['msg'] = GSL('create-success');
        }else{
            $back['rel'] = 2;
            $back['msg'] =GSL('create-failure');
        }
        $this->ajaxReturn($back);
    }
    /**
     * 修改后台配置信息
     */
    public function updateConfig(){
        $config = M('AdminConfig');
        $id = I('get.id');
        $info = $config->where(array('id'=>$id))->find();
        $this->assign('info',$info);
        $this->display('Config/updateConfig');
    }
    /**
     * 添加后台配置数据
     */
    public function updateConfigData(){
        $data = I('post.','',false);
        $createData = array(
            'title'=>$data['title'],
            'value'=>$data['value'],
            'describe'=>$data['describe'],
            'update_time'=>date("Y-m-d H:i:s",time()),
        );
        $config = M('AdminConfig');
        $result = $config->where(array('id'=>$data['id']))->save($createData);
        if($result){
            $back['rel'] = 1;
            $back['msg'] = GSL('update-success');
        }else{
            $back['rel'] = 2;
            $back['msg'] = GSL('update-failure');
        }
        $this->ajaxReturn($back);
    }

    public function SpecialConfig(){
        $this->display('Config/SpecialConfig');
    }

    /**
     * 上传网站的特殊图片
     */
    public function handleUpload(){
        $file = $_FILES['file'];
        if($file == ''){
            $res = array(
                'code' => -1,
                'msg'  =>GSL('please-select-file'). '...'
            );
        }else{
            $url = "./Uploads/icon/";
            $info = uploadFile($file,$url,false);
            if(!$info) {
                $res['code'] = -1;
                $res['msg'] = GSL('Upload-failure');
            }else{
                $res['code'] = 0;
                $res['msg'] = GSL('Upload-success');
                $res['src'] = "/Uploads/icon/".$info;// 上传成功 获取上传文件信息
            }
        }
        $this->ajaxReturn($res);
    }

    public function SpecialConfigData(){
        $data = I('post.','',false);
        $config = new ConfigApi();
        $result = $config->updateSpecialConfig($data);
        $this->ajaxReturn($result);
    }
}