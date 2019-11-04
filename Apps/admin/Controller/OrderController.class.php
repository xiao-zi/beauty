<?php
namespace admin\Controller;
use Think\Controller;
use Think\Model;
use User\Api\OrderApi;
use User\Api\CustomerApi;
use User\Api\PackageApi;
use User\Api\PaymentApi;
use User\Api\ProductApi;
use User\Api\ServiceApi;
use User\Api\UserApi;

class OrderController extends CommonController {
    /**
     * 订单的列表
     */
    public function index(){
        //获取所有的用户信息
        $customerAPI = new CustomerApi();
        $customerGroup = $customerAPI->selectCustomer('','','','id,username,cartnum');
        //获取所有后台人员信息
        $userAPI = new UserApi();
        $userGroup = $userAPI->selectUser('','','','id,realname');
        $this->assign('customerGroup',$customerGroup);
        $this->assign('userGroup',$userGroup);

        $get = I('get.','',false);
        $map = array();
        if(!empty($get['cid'])){//客户订单查询
            $map['cid'] = $get['cid'];
        }
        if(!empty($get['aid'])){//后台添加人员订单查询
            $map['aid'] = $get['aid'];
        }
        if(!empty($get['sn'])){//客户订单查询
            $map['sn'] = $get['sn'];
        }
        if(!empty($get['paymend'])){//支付方式查询
            $map['paymend'] = $get['paymend'];
        }
        if(!empty($get['status'])){//支付状态查询
            $map['status'] = $get['status'];
        }
        /*时间筛选*/
        $begin = $get['start'];
        $end = $get['end'];
        $begin != '' ? $begin = strtotime($begin) : $begin = strtotime(date('Y-1'));
        $end != '' ? $end = strtotime($end) : $end = time();
        if(!empty($get['start']) &&!empty($get['end'])){//支付状态查询
            $map['create_at'] = array('between',"$begin,$end");
        }
        $this->assign('get',$get);// 赋值分页输出
        /**订单的类**/
        $orderApi = new OrderApi();
        if(!empty($get['p'])){//第几页数据
            $page = $get['p'];
        }else{
            $page = 1;
        }
        $limit = ($page-1)*10 .','.$page*10;
        $data = $orderApi->OrderSelect($map,'create_at desc',$limit,'');
        $user = M('AdminUser');
        $customer = M('Customer');
        foreach($data as $key=>$value){
            $data[$key]['admin'] = $user->where(array('id'=>$value['aid']))->getField(['realname']);
            $data[$key]['customer'] = $customer->where(array('id'=>$value['cid']))->getField(['username']).'('.$customer->where(array('id'=>$value['cid']))->getField(['cartnum']).')';
        }
        $back['pagenum'] = $orderApi->OrderCount($map);
        $back['pages'] = 10;
        $back['page'] = $page;
        $this->assign('page',$back);// 赋值分页输出
        $this->assign('data',$data);
        $this->display('Order/index');
    }

    /**
     *创建新的订单
     */
    public function createOrder(){
        //判断是否是提交数据还是打开页面
        if(!IS_POST){
            //用户
            $customerAPI = new CustomerApi();
            $customerGroup = $customerAPI->selectCustomer('','','','id,username,cartnum');
            $this->assign('customerGroup',$customerGroup);

            $this->assign('customer',json_encode($customerGroup));
            //项目
            $projectAPI = new ProductApi();
            //获取cookie中的语言
            $type = $_COOKIE['language'];
            switch($type){
                case 'zh':$field = 'id,chinese as title,price,discount';break;
                case 'eh':$field = 'id,english as title,price,discount';break;
                default:$field = 'id,chinese as title,price,discount';
            }
            $projectDroup = $projectAPI->selectProduct('','','',$field);

            $this->assign('projectGroup',json_encode($projectDroup));

            //查询技师
            $adminUserApi = new UserApi();
            $userGroup = $adminUserApi->selectUser(array('grouping'=>3,'status'=>'activation'),'id','','id,realname');

            $this->assign('user',json_encode($userGroup));
            $this->display('Order/create');
        }else{
            $data = I('post.data','',false);

//            $this->ajaxReturn($back);
        }
    }

    /**
     * 订单的套餐使用
     */
    public function package(){

        //判断是否是提交数据还是打开页面
        if(!IS_POST){
            //用户
            $customerAPI = new CustomerApi();
            $customerGroup = $customerAPI->selectCustomer('','','','id,username,cartnum');
            $this->assign('customerGroup',$customerGroup);

            $this->assign('customer',json_encode($customerGroup));
            //支付方式
            $pay_model = C('PAY_MODEL');
            $no_select = array('type'=>'','title'=>'Payment-method');
            array_unshift($pay_model,$no_select);
            $new_array_pay_model = array();
            foreach($pay_model as $key=>$value){
                $new_array_pay_model[] = array(
                    'id'=>$value['type'],
                    'title'=>GSL($value['title']),
                );
            }
            $pay = GenerateSelectHtml('mode','','',$new_array_pay_model,array('id','title'));
            $this->assign('pay',$pay);
            $this->display('Order/package/index');
        }else{
            $data = I('post.','',false);
            $aid = session('admin.id');//管理人员id
            //计算小费的总金额
            $money = 0;
            foreach($data['tip'] as $key=>$value){
                $money += $value;
            }
            //生成订单的json格式内容
            $jsonArr = array();
            for($i = 0;$i<count($data['project']);$i++){
                $jsonArr[] = array(
                    'project'=>$data['project'][$i],
                    'user'=>$data['user'][$i],
                    'tip'=>$data['tip'][$i],
                );
            }

            $json = json_encode($jsonArr);
            //生成支付编号和订单编号
            $sn = date("Ymd",time()).time().mt_rand(10000,99999);
            $paymentData = array(
                'sn'=>$sn,
                'cid'=>$data['cid'],
                'aid'=>$aid,
                'money'=>$money,
                'type'=>4,//4：小费支付
                'status'=>$data['status'],
                'mode'=>$data['mode'],//支付方式：1；现金支付，2：刷卡支付，3：银行划账
                'create_at'=>time(),
                'update_at'=>time()
            );
            //开始事务
            $model = new Model();
            $model->startTrans();
            $result = false;
            $paymentApi = new PaymentApi();
            $paymentResult =$paymentApi->createPayment($paymentData);
            if($paymentResult['rel']){//判断支付数据是否生成成功
                $orderData = array(
                    'sn'=>$sn,
                    'cid'=>$data['cid'],
                    'aid'=>$aid,
                    'payid'=>$paymentResult['rel'],
                    'total'=>$money,
                    'price'=>0,
                    'tip'=>$money,
                    'payment'=>$data['mode'],
                    'status'=>$data['status'],
                    'type'=>1,//套餐订单
                    'content'=>$json,
                    'remark'=>$data['remark'],
                    'create_at'=>time(),
                    'update_at'=>time()
                );
                $orderApi = new OrderApi();
                $orderResult = $orderApi->OrderCreate($orderData);
                if($orderResult){
                    $serviceApi = new ServiceApi();
                    for($j = 0;$j<count($data['project']);$j++){
                        $serviceData = array(
                            'aid'=>$data['user'][$j],
                            'pid'=>$data['project'][$j],
                            'oid'=>$orderResult['rel'],
                            'price'=>0,
                            'tip'=>$data['tip'][$j],
                            'type'=>1,//套餐订单
                            'date'=>date("Y-m-d",time()),
                            'create_at'=>time(),
                            'update_at'=>time()
                        );
                        $serviceResult = $serviceApi->createService($serviceData);
                        if($serviceResult){
                            $result = true;
                        }
                    }
                }
            }
            if($result){
                //成功则提交
                $model->commit();
                 $back = array('rel'=>1,'msg'=>GSL('create-success'));
            }else{
                //失败则回滚
                $model->rollback();
                 $back = array('rel'=>0,'msg'=>GSL('failed'));
            }
            $this->ajaxReturn($back);
        }
    }

    /**
     * 用户和套餐的联动
     * @param $cid 用户的ID
     */
    public function getCustomerPackage($cid){
        $package = new PackageApi();
        //获取当前语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'customer_package.id,package.chinese as title';break;
            case 'eh':$field = 'customer_package.id,package.english as title';break;
            default:$field = 'customer_package.id,package.chinese as title';
        }
        $data = $package->getCustomerPackage($cid,$field);
        $this->ajaxReturn($data);
    }

    /**
     * @param $id 用户套餐id
     */
    public function findCustomerPackage($id){
        //项目
        $projectAPI = new ProductApi();
        $packageApi = new PackageApi();

        //获取cookie中的语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'id,chinese as title';break;
            case 'eh':$field = 'id,english as title';break;
            default:$field = 'id,chinese as title';
        }

        $packageInfo = $packageApi->FindCustomerPackage(array('id'=>$id));
        $content = json_decode($packageInfo['content'],true);
        foreach($content as $key=>$value){
            $content[$key]['title'] = $projectAPI->findProduct(array('id'=>$value['project']),$field)['title'];
        }
        $this->assign('content',$content);
        $this->assign('content1',json_encode($content));

        $productArrID = getArrayKeyValue($content,'project');
        $projectStrID = implode(',',$productArrID);
        $projectDroup = $projectAPI->selectProduct(array('id'=>array('in',$projectStrID)),'','',$field);

        $this->assign('projectGroup',json_encode($projectDroup));

        //查询技师
        $adminUserApi = new UserApi();
        $userGroup = $adminUserApi->selectUser(array('grouping'=>3,'status'=>'activation'),'id','','id,realname');
        $this->assign('user',json_encode($userGroup));
        $back['json'] = $this->fetch('Order/package/package');
        $back['html'] = $this->fetch('Order/package/showPackage');
        $this->ajaxReturn($back);
    }
}