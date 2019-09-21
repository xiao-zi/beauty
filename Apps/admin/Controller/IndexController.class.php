<?php
namespace admin\Controller;
use Think\Controller;

class IndexController extends CommonController {
    /**
     * 后台首页
     */
    public function index(){
        $menu = $this->getMenu();
        $this->assign('menu',$menu);
        $this->display('Public/base/index');
    }

    /**
     * 后台的导航栏菜单
     * @return array
     */
    public function getMenu(){
        //获取存储在session中的后台管理员信息
        $user = session('admin');
        $menu = M('AdminMenu');
        //获取cookie中的语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'id,pid,title,url,node_url,type,icon,sort';break;
            case 'eh':$field = 'id,pid,english as title,url,node_url,type,icon,sort';break;
            default: $field = 'id,pid,title,url,node_url,type,icon,sort';break;
        }
        if($user['grouping'] == 1){//如果用户的管理权限为1的话，则他拥有所有的权限
            $list = $menu->order('sort')->field($field)->select();
        }else{
            $group = M('AdminGroup');
            $rules = $group->where(array('id'=>$user['grouping']))->getField('rules');
            $list = $menu->where(array('id'=>array('in',$rules),'status'=>'activation'))->order('sort')->field($field)->select();
        }
        $menuData = getTree($list,'id','pid');
        return $menuData;
    }
}