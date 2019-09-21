<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\GroupApi;

class GroupController extends CommonController {
    /**
     * 权限组首页
     */
    public function Jurisdiction(){
        /** @var  $group 权限组 */
        $group = M('AdminGroup');
        $groups = $group->order('id')->select();
        $this->assign('group',$groups);
        /** @var  $menu 路由列表 */
        $menu = M('AdminMenu');
        $list = $menu->order('sort')->select();
        $menuData = getTree($list,'id','pid');
        $this->assign('menu',$menuData);
        $this->display('Group/Jurisdiction');
    }

    /**
     * 创建权限组的页面
     */
    public function createGroup(){
        /** @var  $menu 路由列表 */
        $menu = M('AdminMenu');
        //获取cookie中的语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'id,pid,title,url,node_url,type,icon,sort';break;
            case 'eh':$field = 'id,pid,english as title,url,node_url,type,icon,sort';break;
            default: $field = 'id,pid,title,url,node_url,type,icon,sort';break;
        }
        $list = $menu->order('sort')->field($field)->select();
        $menuData = getTree($list,'id','pid');
        $this->assign('menu',$menuData);
        $this->display('Group/createGroup');
    }

    /**
     * 创建权限组数据
     */
    public function createGroupData(){
        $data = I('post.','',false);
        $data['rules'] = implode(',',$data['rules']);
        $group = new GroupApi();
        $result = $group->create($data);
        $this->ajaxReturn($result);
    }

    /**
     * 修改权限组页面
     */
    public function updateGroup($id){
        /** @var  $menu 路由列表 */
        $menu = M('AdminMenu');
        //获取cookie中的语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'id,pid,title,url,node_url,type,icon,sort';break;
            case 'eh':$field = 'id,pid,english as title,url,node_url,type,icon,sort';break;
            default: $field = 'id,pid,title,url,node_url,type,icon,sort';break;
        }
        $list = $menu->order('sort')->field($field)->select();
        $menuData = getTree($list,'id','pid');
        $this->assign('menu',$menuData);
        //找出当前权限组的权限
        $group = M('AdminGroup');
        $rules = $group->where('id='.$id)->getField('rules');
        if($rules == 'all'){//如果权限是all，代表是超级管理员
            $ruleArr = $menu->order('id')->field('id')->select();
            $rule = [];
            foreach($ruleArr as $key=>$value){
                $rule[] = $value['id'];
            }
            $rules = implode(',',$rule);
        }
        $this->assign('rule',$rules);
        $info = $group->where('id='.$id)->find();
        $this->assign('info',$info);
        $this->display('Group/updateGroup');
    }
    /**
     * 修改权限组数据
     */
    public function updateGroupData(){
        $data = I('post.','',false);
        $rules = implode(',',$data['rules']);
        $id = $data['id'];
        $group = new GroupApi();
        $saveData = array('module'=>$data['module'],'title'=>$data['title'],'description'=>$data['description'],'rules'=>$rules);
        $result = $group->update($id,$saveData);
        $this->ajaxReturn($result);
    }
}