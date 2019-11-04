<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\CategoryApi;
use User\Api\ProductApi;

class ProductController extends CommonController {
    /**
     * 产品列表
     */
    public function index(){
        $productAPI = new ProductApi();
        $data = $productAPI->selectProduct('','id','','');
        $category = new CategoryApi();
        foreach($data as $key=>$value){
            $data[$key]['category'] = $category->CategoryFind(array('id'=>$value['category']),'chinese,english');
        }
        $this->assign('data',$data);
        $this->display('Product/index');
    }

    /**
     * 创建产品页面
     */
    public function createProduct(){
        $category = new CategoryApi();
        $where['type'] = 1;
        $where = array(
            'type'=>1,
            'status'=>'activation'
        );
        $data = $category->CategorySelect($where);
        $this->assign('data',$data);
        $this->display('Product/create');
    }

    /**
     * 创建产品数据
     */
    public function createProductData(){
        $data = I('post.data','',false);
        $data['create_at'] = time();
        $data['update_at'] = time();
        $productAPI = new ProductApi();
        $result = $productAPI->createProduct($data);
        $this->ajaxReturn($result);
    }

    /**
     * 修改产品页面
     */
    public function updateProduct(){
        $id = I('get.id');
        $map = array('id'=>$id);
        $productApi = new ProductApi();
        $productData = $productApi->findProduct($map,'');
        $this->assign('product',$productData);
        $category = new CategoryApi();
        $where['type'] = 1;
        $where = array(
            'type'=>1,
            'status'=>'activation'
        );
        $categories = $category->CategorySelect($where);
        $this->assign('categories',$categories);
        $this->display('Product/update');
    }

    /**
     * 修改产品信息
     */
    public function updateProductData(){
        $data = I('post.data','',false);
        $id = I('get.id');
        $map = array('id'=>$id);
        $data['update_at'] = time();
        $productAPI = new ProductApi();
        $result = $productAPI->updateProduct($map,$data);
        $this->ajaxReturn($result);
    }

    /**
     * 产品状态的修改
     */
    public function ProductStatus(){
        $data = I('post.','',false);
        $data['update_at'] = time();
        $where = array('id'=>$data['id']);
        $productAPI = new ProductApi();
        $result = $productAPI->productStatus($where,$data);
        $this->ajaxReturn($result);
    }

    /**
     * 获取产品的价格
     * @param $id
     */
    public function getProductPrice($id){
        $productAPI = new ProductApi();
        $price = $productAPI->getPrice($id);
        $this->ajaxReturn($price);
    }

}