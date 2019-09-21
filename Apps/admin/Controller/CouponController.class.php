<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/26 0026
 * Time: 9:24
 */

namespace admin\Controller;


use User\Api\CategoryApi;
use User\Api\CouponApi;
use User\Api\CustomerApi;
use User\Api\ProductApi;

class CouponController extends CommonController
{
    /**
     * 优惠券的列表
     */
    public function index(){
        $this->display('Coupon/index');
    }

    public function ajaxCoupon(){
        $data = I('post.','',false);//获取搜索的数据
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['title'] = array('like', '%' . $keywords . '%');
        }
        //优惠券是否过期
        switch($data['status']){
            case 1:$map['end'] = array('gt',time());break;
            case 2:$map['end'] = array('lt',time());break;
        }
        //获取当前所有的优惠券
        $couponApi = new CouponApi();
        //总条数
        $count = M('coupon')->where($map)->count();
        //分页类
        $Page = new \Think\Page($count,10);
        $show  = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;
        $data = $couponApi->CouponSelect($map,'id',$limit,'');
        foreach($data as $key=>$value){
            $data[$key]['rule'] = json_decode($value['rule'],true);
        }
        $back['pagenum'] = $count;
        $back['pages'] = 10;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$data);
        $back['html'] = $this->fetch();
        $this->ajaxReturn($back);
    }

    /**
     * 创建新的优惠券
     */
    public function createCoupon(){
        //判断是否是提交数据还是打开页面
        if(!IS_POST){
            //产品
            $product = new ProductApi();
            $map = array(
                'status'=>'activation'
            );
            $productData = $product->selectProduct($map,'','','');
            $this->assign('product',$productData);
            //产品分类
            $category = new CategoryApi();
            $where['type'] = 1;
            $data = $category->CategorySelect($where);
            $this->assign('category',$data);
            $this->display('Coupon/create');
        }else{
            $data = I('post.data','',false);

            //优惠券使用时间处理
            $data['start'] = strtotime(substr($data['date'],0,10));//开始时间
            $data['end'] = strtotime(substr($data['date'],-10));//结束时间
            //产品分类处理
            $data['category'] = implode(',',$data['category']);
            //产品处理
            $data['product'] = implode(',',$data['product']);
            //消费金额从小到大品排序
            if(!empty($data['rule'])){
                $data['rule'] = arraySort($data['rule'],'money','asc');
            }
            //验证优惠券使用规则是否正确
            if($data['type'] == 1){
                //满减 折扣不能大于消费金额
                foreach($data['rule'] as $key=>$value){
                    if($value['money'] > 0){
                        if($value['discount'] >= $value['money']){
                            $back['rel'] = 0;
                            $back['msg'] = GSL('errors-coupon-rules');
                            $this->ajaxReturn($back);
                        }
                    }
                }
            }elseif($data['type'] == 2){
                //打折 折扣取值范围在0~100之间
                foreach($data['rule'] as $key=>$value){
                    if($value['discount'] >= 100 || $value['discount'] <= 0){
                        $back['rel'] = 0;
                        $back['msg'] = GSL('errors-coupon-rules');
                        $this->ajaxReturn($back);
                    }
                }
            }
            $data['rule'] = json_encode($data['rule']);
            $data['create_at'] = time();
            $data['update_at'] = time();
            $coupon = new CouponApi();
            $back = $coupon->CouponCreate($data);
            $this->ajaxReturn($back);
        }
    }

    /**
     * 修改优惠券信息
     */
    public function updateCoupon($id){
        //判断是否是提交数据还是打开页面
        if(!IS_POST){
            //产品
            $product = new ProductApi();
            $map = array(
                'status'=>'activation'
            );
            $productData = $product->selectProduct($map,'','','');
            $this->assign('product',$productData);
            //产品分类
            $category = new CategoryApi();
            $where['type'] = 1;
            $categoryData = $category->CategorySelect($where);
            $this->assign('category',$categoryData);
            //优惠券
            $coupon = new CouponApi();
            $couponData = $coupon->CouponFind(array('id'=>$id),'');
            //产品处理
            $couponData['product'] = explode(',',$couponData['product']);
            //产品分类处理
            $couponData['category'] = explode(',',$couponData['category']);
            //时间处理
            $couponData['date'] = date('Y-m-d',$couponData['start']).' - '.date('Y-m-d',$couponData['end']);
            //优惠券使用规则处理
            $couponData['rule'] = json_decode($couponData['rule'],true);
            $this->assign('coupon',$couponData);
            $this->display('Coupon/update');
        }else{
            $data = I('post.data','',false);
            //优惠券使用时间处理
            $data['start'] = strtotime(substr($data['date'],0,10));//开始时间
            $data['end'] = strtotime(substr($data['date'],-10));//结束时间
            //产品分类处理
            $data['category'] = implode(',',$data['category']);
            //产品处理
            $data['product'] = implode(',',$data['product']);
            //消费金额从小到大品排序
            if(!empty($data['rule'])){
                $data['rule'] = arraySort($data['rule'],'money','asc');
            }
            //验证优惠券使用规则是否正确
            if($data['type'] == 1){
                //满减 折扣不能大于消费金额
                foreach($data['rule'] as $key=>$value){
                    if($value['money'] > 0){
                        if($value['discount'] >= $value['money']){
                            $back['rel'] = 0;
                            $back['msg'] = GSL('errors-coupon-rules');
                            $this->ajaxReturn($back);
                        }
                    }
                }
            }elseif($data['type'] == 2){
                //打折 折扣取值范围在0~100之间
                foreach($data['rule'] as $key=>$value){
                    if($value['discount'] >= 100 || $value['discount'] <= 0){
                        $back['rel'] = 0;
                        $back['msg'] = GSL('errors-coupon-rules');
                        $this->ajaxReturn($back);
                    }
                }
            }
            $data['rule'] = json_encode($data['rule']);
            $data['update_at'] = time();
            $coupon = new CouponApi();
            $back = $coupon->CouponUpdate(array('id'=>$id),$data);
            $this->ajaxReturn($back);
        }
    }

    /**
     * 删除优惠券信息
     */
    public function deleteCoupon($id){
        $coupon = new CouponApi();
        $back = $coupon->deleteCoupon($id);
        $this->ajaxReturn($back);
    }

    /**
     * 给客户赠送优惠券页面
     */
    public function give(){
        //优惠券
        $coupon = new CouponApi();
        $map = array(
            'end'=>array('gt',time())
        );
        $couponData = $coupon->CouponSelect($map,'id','','');
        $this->assign('coupon',$couponData);

        $category = new CategoryApi();
        //获取cookie中的语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'id,chinese as title,type';break;
            case 'eh':$field = 'id,english as title,type';break;
            default:$field = 'id,chinese as title,type';
        }
        //客户国家
        $country = $category->CategorySelect(array('type'=>2,'status'=>'activation'),'id','',$field);
        //客户来源
        $source = $category->CategorySelect(array('type'=>3,'status'=>'activation'),'id','',$field);
        //客户类别
        $type = $category->CategorySelect(array('type'=>4,'status'=>'activation'),'id','',$field);
        //获取当前所有的客户
        $customerApi = new CustomerApi();
        $customerGroup = $customerApi->selectCustomer('','','','id,username,cartnum');
        $this->assign('country',$country);
        $this->assign('source',$source);
        $this->assign('type',$type);
        $this->assign('customerGroup',$customerGroup);

        $this->display('Coupon/give');
    }

    /**
     * 搜索客户列表
     */
    public function ajaxCustomer(){
        $data = I('post.','',false);//获取搜索的数据
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['cartnum'] = array('like', '%' . $keywords . '%');
            $map['username'] = array('like', '%' . $keywords . '%');
            $map['phone'] = array('like', '%' . $keywords . '%');
            $map['email'] = array('like', '%' . $keywords . '%');
            $map["_logic"] = 'or';
        }
        $data['ActivityLevel'] != '' ? $map['ActivityLevel'] = $data['ActivityLevel'] : false;
        $data['source'] != '' ? $map['source'] = $data['source'] : false;
        $data['country'] != '' ? $map['country'] = $data['country'] : false;
        $data['recommender'] != '' ? $map['recommender'] = $data['recommender'] : false;
        $data['birthday'] != '' ? $map['birthday'] = substr($data['birthday'],5) : false;
        //获取当前所有的客户
        $customerApi = new CustomerApi();
        //总条数
        $count = M('Customer')->where($map)->count();
        //分页类
        $Page = new \Think\Page($count,10);
        $show  = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;
        $customer = $customerApi->selectCustomer($map,'id',$limit,'id,username,cartnum,phoneCode,phone,email,birth,sex,ActivityLevel,register_time');
        $back['pagenum'] = $count;
        $back['pages'] = 10;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$customer);
        $back['html'] = $this->fetch();
        $this->ajaxReturn($back);
    }

    /**
     * 给客户赠送优惠券的操作
     */
    public function giveCoupon(){
        $data = I('post.','',false);
        $arr = $data['arr'];//用户id数组
        $id = $data['id'];//优惠券id
        $coupon = new CouponApi();
        $result = $coupon->giveCoupon($id,$arr);
        $this->ajaxReturn($result);
    }
    /**
     * 上传网站的优惠卷图片
     */
    public function handleUpload(){
        $file = $_FILES['file'];
        if($file == ''){
            $res = array(
                'code' => -1,
                'msg'  =>GSL('please-select-file'). '...'
            );
        }else{
            $url = "./Uploads/coupon/";
            $info = uploadFile($file,$url,false);
            if(!$info) {
                $res['code'] = -1;
                $res['msg'] = GSL('Upload-failure');
            }else{
                $res['code'] = 0;
                $res['msg'] = GSL('Upload-success');
                $res['src'] = "/Uploads/coupon/".$info;// 上传成功 获取上传文件信息
            }
        }
        $this->ajaxReturn($res);
    }
}