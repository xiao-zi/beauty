<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\CategoryApi;
use User\Api\CustomerApi;

class CustomerController extends CommonController {
    /**
     * 客户的管理列表页面
     */
    public function index(){
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
        $this->display('Customer/index');
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
        $count = M('customer')->where($map)->count();
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
     * 创建用户的页面
     */
    public function createCustomer(){
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
        $this->display('Customer/createCustomer');
    }
    /**
     * 添加用户的数据
     */
    public function createCustomerData(){
        $data = I('post.','',false);
        //生成用户的卡号
        $cartNum = date("Ymd",time()).time().mt_rand(10000,99999);
        $data['cartNum'] = $cartNum;
        $customerApi = new CustomerApi();
        $result = $customerApi->createCustomer($data);
        $this->ajaxReturn($result);
    }

    /**
     * 修改用户信息页面
     * @param $id 用户的id
     */
    public function updateCustomer($id){
        //获取用户信息
        $customerApi = new CustomerApi();
        $data = $customerApi->findCustomer(array('id'=>$id),'');
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
        $this->assign('country',$country);
        $this->assign('source',$source);
        $this->assign('type',$type);
        $this->assign('data',$data);
        $this->display('Customer/updateCustomer');
    }

    /**
     * 修改用户信息
     */
    public function updateCustomerData(){
        $data = I('post.','',false);
        $id = $data['id'];
        $customerApi = new CustomerApi();
        $result = $customerApi->updateCustomer(array('id'=>$id),$data);
        $this->ajaxReturn($result);
    }

    /**
     * 获取页面选择的客户的手机号 并且打开编辑短信的页面
     */
    public function getPhoneArr(){
        $id = I('get.id');
        $map = array('id'=>array('in',$id));
        $customerApi = new CustomerApi();
        $customer = $customerApi->selectCustomer($map,'id','','id,username,phoneCode,phone');
        $this->assign('data',$customer);
        $this->display('Customer/sendMessage');
    }

    /**
     * 添加到短信数据库中
     */
    public function GroupSMS(){
        $data = I('post.','',false);
        $idArr = $data['checkid'];
        $idStr = implode(',',$idArr);
        $content = $data['content'];
        $map = array('id'=>array('in',$idStr));
        $customerApi = new CustomerApi();
        $customer = $customerApi->selectCustomer($map,'id','','id,username,phoneCode,phone');
        foreach($customer as $key=>$value){
            $smsData = array(
                'phone_code'=>$value['phonecode'],//手机号前缀
                'phone'=>$value['phone'],//手机号
                'cid'=>$value['id'],//客户的id
                'aid'=>session('admin.id'),//发送短信的人员
                'message'=>$content,//短信内容
                'status'=>0,//状态 0 未发送，1发送成功 2发送失败
                'created_time'=>time(),
                'updated_time'=>time(),
            );
            $result = $this->createSms($smsData);
        }
        $this->ajaxReturn($result);
    }

    /**
     * 获取页面选择的客户的邮箱 并且打开编辑邮箱的页面
     */
    public function getEmailArr(){
        $id = I('get.id');
        $map = array('id'=>array('in',$id));
        $customerApi = new CustomerApi();
        $customer = $customerApi->selectCustomer($map,'id','','id,username,email');
        $this->assign('data',$customer);
        $this->display('Customer/sendEmail');
    }

    /**
     * 添加到发送邮箱数据库
     */
    public function GroupEmail(){
        $data = I('post.','',false);
        $idArr = $data['checkid'];
        $idStr = implode(',',$idArr);
        $content = $data['content'];
        $map = array('id'=>array('in',$idStr));
        $customerApi = new CustomerApi();
        $customer = $customerApi->selectCustomer($map,'id','','id,username,email');
        foreach($customer as $key=>$value){
            $emailData = array(
                'email'=>$value['email'],//邮箱
                'content'=>$content,//邮箱内容
                'cid'=>$value['id'],//客户的id
                'aid'=>session('admin.id'),//发送邮件的人员
                'status'=>0,//状态 0 未发送，1发送成功 2发送失败
                'create_at'=>time(),
                'update_at'=>time(),
            );
            $result = $this->createEmail($emailData);
        }
        $this->ajaxReturn($result);
    }
}