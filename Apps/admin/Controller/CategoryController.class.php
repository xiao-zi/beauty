<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\CategoryApi;

class CategoryController extends CommonController {
    /**
     * 产品的管理列表页面
     */
    public function product(){
        $category = new CategoryApi();
        $where['type'] = 1;
        $data = $category->CategorySelect($where);
        $this->assign('data',$data);
        $this->display('Category/product/index');
    }

    /**
     * 产品分类的创建页面
     */
    public function createProduct(){
         $this->display('Category/product/create');
    }
    /**
     * 产品分类的修改页面
     */
    public function updateProduct($id){
        $category = new CategoryApi();
        $where = array('id'=>$id,'type'=>1);
        $data = $category->CategoryFind($where);
        $this->assign('data',$data);
        $this->display('Category/product/update');
    }

    /**
     * 客户来源的管理列表页面
     */
    public function source(){
        $category = new CategoryApi();
        $where['type'] = 3;
        $data = $category->CategorySelect($where);
        $this->assign('data',$data);
        $this->display('Category/source/index');
    }

    /**
     * 客户来源的创建页面
     */
    public function createSource(){
        $this->display('Category/source/create');
    }
    /**
     * 客户来源的修改页面
     */
    public function updateSource($id){
        $category = new CategoryApi();
        $where = array('id'=>$id,'type'=>3);
        $data = $category->CategoryFind($where);
        $this->assign('data',$data);
        $this->display('Category/source/update');
    }

    /**
     * 客户国籍的管理列表页面
     */
    public function country(){
        $category = new CategoryApi();
        $where['type'] = 2;
        $data = $category->CategorySelect($where);
        $this->assign('data',$data);
        $this->display('Category/country/index');
    }

    /**
     * 客户国籍的创建页面
     */
    public function createCountry(){
        $this->display('Category/country/create');
    }
    /**
     * 客户国籍的修改页面
     */
    public function updateCountry($id){
        $category = new CategoryApi();
        $where = array('id'=>$id,'type'=>2);
        $data = $category->CategoryFind($where);
        $this->assign('data',$data);
        $this->display('Category/country/update');
    }

    /**
     * 客户国籍的管理列表页面
     */
    public function tag(){
        $category = new CategoryApi();
        $where['type'] = 4;
        $data = $category->CategorySelect($where);
        $this->assign('data',$data);
        $this->display('Category/tag/index');
    }

    /**
     * 客户国籍的创建页面
     */
    public function createTag(){
        $this->display('Category/tag/create');
    }
    /**
     * 客户国籍的修改页面
     */
    public function updateTag($id){
        $category = new CategoryApi();
        $where = array('id'=>$id,'type'=>4);
        $data = $category->CategoryFind($where);
        $this->assign('data',$data);
        $this->display('Category/tag/update');
    }

    /**
     * 创建分类
     */
    public function createCategory(){
        $data = I('post.data','',false);
        $category = new CategoryApi();
        $result = $category->CategoryCreate($data);
        $this->ajaxReturn($result);
    }

    /**
     * 修改分类
     */
    public function updateCategory(){
        $data = I('post.data','',false);
        $where = array('id'=>$data['id']);
        $category = new CategoryApi();
        $result = $category->CategoryUpdate($where,$data);
        $this->ajaxReturn($result);
    }
    /**
     * 修改分类状态
     */
    public function CategoryStatus(){
        $data = I('post.','',false);
        $where = array('id'=>$data['id']);
        $category = new CategoryApi();
        $result = $category->CategoryStatus($where,$data);
        $this->ajaxReturn($result);
    }

}