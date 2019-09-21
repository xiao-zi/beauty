<?php
namespace admin\Controller;
use admin\Model\LanguageModel;
use Think\Controller;
use User\Api\LanguageApi;

class LanguageController extends CommonController {
    /**
     * 语言管理页面
     */
    public function index(){
        $this->display('Language/index');
    }

    /**
     * 搜索后台管理员
     */
    public function ajaxIndex(){
        $data = I('post.','',false);//获取搜索的数据
        $language = M('AdminLanguage');
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['model'] = array('like', '%' . $keywords . '%');
            $map['chinese'] = array('like', '%' . $keywords . '%');
            $map['english'] = array('like', '%' . $keywords . '%');
            $map["_logic"] = 'or';
        }
        $count = $language->where($map)->count();// 查询满足要求的总记录数
        $Page  = new  \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show  = $Page->show();// 分页显示输出
        $data = $language
            ->where($map)->limit($Page->firstRow.','.$Page->listRows)
            ->order('id asc')
            ->select();
        $back['pagenum'] = $count;
        $back['pages'] = 20;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$data);
        $back['html'] = $this->fetch('Language/ajaxIndex');
        $this->ajaxReturn($back);
    }

    /**
     * 语言系统的创建页面
     */
    public function createLanguage(){
        $this->display('Language/createLanguage');
    }

    /**
     * 添加语言系统数据
     */
    public function createLanguageData(){
        $data = I('post.','',false);
        $lang = new LanguageApi();
        $result = $lang->createLanguage($data);
        $this->ajaxReturn($result);
    }
    /**
     * 语言系统的修改页面
     */
    public function updateLanguage($id){
        $this->assign('id',$id);
        $language = M('AdminLanguage');
        $info = $language->where(array('id'=>$id))->find();
        $this->assign('info',$info);
        $this->display('Language/updateLanguage');
    }
    /**
     * 修改语言系统数据
     */
    public function updateLanguageData(){
        $data = I('post.','',false);
        $lang = new LanguageApi();
        $result = $lang->updateLanguage($data['id'],$data);
        $this->ajaxReturn($result);
    }
}