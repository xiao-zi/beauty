<?php
namespace admin\Controller;
use Think\Controller;
class MenuController extends CommonController {

    public function index(){
        $menu = M('AdminMenu');
        $data = $menu
            ->order('sort asc')
            ->select();
        $data = getTree($data,'id','pid');
        $this->assign('data',$data);
        $this->display('Menu/index');
    }

    /**
     * 搜索导航栏信息
     */
    public function ajaxMenu(){
        $data = I('post.','',false);//获取搜索的数据
        $menu = M('AdminMenu');
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['title'] = array('like', '%' . $keywords . '%');
            $map['english'] = array('like', '%' . $keywords . '%');
            $map["_logic"] = 'or';
        }
        $count = $menu->where($map)->count();// 查询满足要求的总记录数
        $Page  = new  \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show  = $Page->show();// 分页显示输出
        $data = $menu
            ->where($map)->limit($Page->firstRow.','.$Page->listRows)
            ->order('sort asc')
            ->select();
        $data = getTree($data,'id','pid');
        $back['pagenum'] = $count;
        $back['pages'] = 20;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$data);
        $back['html'] = $this->fetch('Menu/ajaxMenu');
        $this->ajaxReturn($back);
    }

    /**
     * 创建导航栏页面
     */
    public function createMenu(){
        $menu = M('AdminMenu');
        $data = $menu->where(array('pid'=>array('eq',0)))->field('id,title,english')->order('sort asc')->select();
        $this->assign('data',$data);
        $this->display('Menu/createMenu');
    }

    /**
     * 添加导航栏的数据
     */
    public function createMenuData(){
        $data = I('post.','',false);
        if($data['url'] != ''){
            $url = $data['url'];
            $node_url = '/admin.php/'.$data['url'];
        }else{
            $url = 'javascript:void(0);';
            $node_url = 'javascript:void(0);';
        }
        $createData = array(
            'pid'=>$data['pid'],
            'title'=>$data['title'],
            'english'=>$data['english'],
            'url'=>$url,
            'node_url'=>$node_url,
            'icon'=>$data['icon'],
            'sort'=>$data['sort'],
            'status'=>$data['status'],
            'type'=>$data['type'],
        );
        $menu = M('AdminMenu');
        $result = $menu->add($createData);
        if($result){
            $back['rel'] = 1;
            $back['msg'] = '创建成功';
        }else{
            $back['rel'] =  2;
            $back['msg'] = '创建失败';
        }
        $this->ajaxReturn($back);
    }
    /**
     * 修改导航栏数据页面
     */
    public function updateMenu(){
        $id = I('get.id');
        $menu = M('AdminMenu');
        $info = $menu->where(array('id'=>$id))->find();
        $data = $menu->where(array('pid'=>array('eq',0)))->field('id,title,english')->order('sort asc')->select();
        $this->assign('data',$data);
        $this->assign('info',$info);
        $this->display('Menu/updateMenu');
    }

    /**
     * 添加导航栏的数据
     */
    public function updateMenuData(){
        $data = I('post.','',false);
        $id = $data['id'];
        if($data['url'] != '' && $data['url'] != 'javascript:void(0);'){
            $url = $data['url'];
            $node_url = '/admin.php/'.$data['url'];
        }else{
            $url = 'javascript:void(0);';
            $node_url = 'javascript:void(0);';
        }
        $updateData = array(
            'pid'=>$data['pid'],
            'title'=>$data['title'],
            'english'=>$data['english'],
            'url'=>$url,
            'node_url'=>$node_url,
            'icon'=>$data['icon'],
            'sort'=>$data['sort'],
            'status'=>$data['status'],
            'type'=>$data['type'],
        );
        $menu = M('AdminMenu');
        $result = $menu->where(array('id'=>$id))->save($updateData);
        if($result){
            $back['rel'] = 1;
            $back['msg'] = '修改成功';
        }else{
            $back['rel'] = 2;
            $back['msg'] = '修改失败';
        }
        $this->ajaxReturn($back);
    }

    /**
     * 修改状态
     */
    public function updateStatus(){
        $data = I('post.','',false);
        $id = $data['id'];
        $status = $data['status'];
        $menu = M('AdminMenu');
        $result = $menu->where(array('id'=>$id))->save(array('status'=>$status));
        if($result){
            $back['rel'] = 1;
            $back['msg'] = '修改成功';
        }else{
            $back['rel'] = 2;
            $back['msg'] = '修改失败';
        }
        $this->ajaxReturn($back);
     }

}