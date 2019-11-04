<?php
namespace admin\Controller;
use Think\Controller;
use Think\Model;
use User\Api\CustomerApi;
use User\Api\PackageApi;
use User\Api\PaymentApi;
use User\Api\ProductApi;

class PackageController extends CommonController {
    /**
     * 套餐首页
     */
    public function index(){
        $packageApi = new PackageApi();
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'id,chinese as title,original,present,date,create_at,update_at';break;
            case 'eh':$field = 'id,english as title,original,present,date,create_at,update_at';break;
            default:$field = 'id,chinese as title,original,present,date,create_at,update_at';
        }
        $data = $packageApi->packageSelect('','','',$field);
        $this->assign('data',$data);
        $this->display('Package/index');
    }

    /**
     * 创建套餐
     */
    public function create(){
        //判断是否是提交数据还是打开页面
        if(!IS_POST){
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
            $this->display('Package/create');
        }else{
            $data = I('post.','',false);
            for($i=0;$i<count($data['project']);$i++){
                $json[$i] = array(
                    'project'=>$data['project'][$i],
                    'price'=>$data['price'][$i],
                    'num'=>$data['num'][$i]
                );
            }
            $content = json_encode($json);
            $packageApi = new PackageApi();
            $addData = array(
                'image'=>$data['image'],
                'chinese'=>$data['chinese'],
                'english'=>$data['english'],
                'content'=>$content,
                'original'=>$data['total'],
                'present'=>$data['present'],
                'date'=>$data['date'],
                'create_at'=>time(),
                'update_at'=>time(),
            );
            $result = $packageApi->packageCreate($addData);
            $this->ajaxReturn($result);
        }
    }

    public function update($id){
        //判断是否是提交数据还是打开页面
        if(!IS_POST){
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
            $packageApi = new PackageApi();
            $info = $packageApi->packageFind(array('id'=>$id));
            $this->assign('info',$info);
            $this->display('Package/update');
        }else{
            $data = I('post.','',false);
            for($i=0;$i<count($data['project']);$i++){
                $json[$i] = array(
                    'project'=>$data['project'][$i],
                    'price'=>$data['price'][$i],
                    'num'=>$data['num'][$i]
                );
            }
            $content = json_encode($json);
            $packageApi = new PackageApi();
            $saveData = array(
                'image'=>$data['image'],
                'chinese'=>$data['chinese'],
                'english'=>$data['english'],
                'content'=>$content,
                'original'=>$data['total'],
                'present'=>$data['present'],
                'date'=>$data['date'],
                'update_at'=>time(),
            );
            $result = $packageApi->packageUpdate(array('id'=>$id),$saveData);
            $this->ajaxReturn($result);
        }
    }

    /**
     * @param $id 套餐详情展示
     */
    public function showDetail($id){
        $packageApi = new PackageApi();
        $info = $packageApi->packageFind(array('id'=>$id));
        $content = json_decode($info['content'],true);
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'chinese';break;
            case 'eh':$field = 'english';break;
            default:$field = 'chinese';
        }
        foreach($content as $key=>$value){
            $content[$key]['project'] = M('product')->where(array('id'=>$value['project']))->getField($field);
        }
        $info['content'] = $content;
        $this->assign('info',$info);
        $back = $this->fetch('Package/showDetail');
        $this->ajaxReturn($back);
    }

    /**
     * 删除套餐
     * @param $id
     */
    public function deletePackage($id){
        $packageApi = new PackageApi();
        $result = $packageApi->packageDelete(array('id'=>$id));
        $this->ajaxReturn($result);
    }

    /**
     * 用户套餐列表
     */
    public function userPackage(){
        $map = array();
        $packageApi = new PackageApi();
        $data = $packageApi->CustomerPackageSelect($map,'update_at desc','','id,cid,pid,aid,over_at,num,residue,payid,create_at,update_at');
        $customer = M('customer');
        $package = M('package');
        $admin = M('adminUser');
        //获取当前语言
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$packageField = 'chinese';break;
            case 'eh':$packageField = 'english';break;
            default:$packageField = 'chinese';
        }
        foreach($data as $key=>$value){
            $data[$key]['username'] = $customer->where(array('id'=>$value['cid']))->getField('username');
            $data[$key]['package'] = $package->where(array('id'=>$value['pid']))->getField($packageField);
            $data[$key]['admin'] = $admin->where(array('id'=>$value['aid']))->getField('realname');
            if($value['over_at'] == 0) {
                $data[$key]['term'] = GSL('No-deadline');
            }else{
                $data[$key]['term'] = date("Y-m-d",$value['over_at']);
            }
            $data[$key]['num'] = $value['num'];
            $data[$key]['residue'] = $value['residue'];
            $data[$key]['create_at'] = date("Y-m-d H:i:s",$value['create_at']);
            $data[$key]['update_at'] = date("Y-m-d H:i:s",$value['update_at']);
            unset($data[$key]['cid']);
            unset($data[$key]['pid']);
            unset($data[$key]['aid']);
            unset($data[$key]['over_at']);
        }
        $this->assign('data',json_encode($data));
        $this->display('Package/userPackage/index');
    }
    /**
     * 查看用户套餐详情
     * @param $where
     * @return mixed
     */
    public function showPackageDetail($id){
        $package = new PackageApi();
        $info = $package->FindCustomerPackage(array('id'=>$id));
        $content = json_decode($info['content'],true);
        $type = $_COOKIE['language'];
        switch($type){
            case 'zh':$field = 'chinese';break;
            case 'eh':$field = 'english';break;
            default:$field = 'chinese';
        }
        foreach($content as $key=>$value){
            $content[$key]['project'] = M('product')->where(array('id'=>$value['project']))->getField($field);
        }
        $payment = new PaymentApi();
        $payInfo = $payment->findPayment(array('id'=>$info['payid']));
        $back['content'] = $content;
        $pay_model = C('PAY_MODEL');//支付方式
        $pay_status = C('PAY_STATUS');//支付方式
        $back['sn'] = $payInfo['sn'];
        $back['status'] = $pay_status[$payInfo['status']];
        $back['money'] = $payInfo['money'];
        foreach($pay_model as $key=>$value){
            if($payInfo['mode'] == $value['type']){
                $back['mode'] = GSL($value['title']);
            }
        }
        $this->assign('info',$back);
        $backHtml = $this->fetch('Package/userPackage/showDetail');
        $this->ajaxReturn($backHtml);
    }

    /**
     * 删除用户的套餐列表，并且删除支付记录
     * @param $id
     */
    public function delCustomerPackage($id){
        $package = new PackageApi();
        $back = $package->delCustomerPackage(array('id'=>$id));
        $this->ajaxReturn($back);
    }

    /**
     * 购买套餐
     */
    public function buy(){
        $packageApi = new PackageApi();
        if(!IS_POST){
            //获取当前所有的客户
            $customerApi = new CustomerApi();
            $customerGroup = $customerApi->selectCustomer('','','','id,username,cartnum');
            $this->assign('customer',$customerGroup);
            //获取当前语言
            $type = $_COOKIE['language'];
            switch($type){
                case 'zh':$field = 'id,chinese as title';break;
                case 'eh':$field = 'id,english as title';break;
                default:$field = 'id,chinese as title';
            }
            $data = $packageApi->packageSelect('','','',$field);
            $this->assign('data',$data);
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
            $pay = GenerateSelectHtml('data[mode]','','',$new_array_pay_model,array('id','title'));
            $this->assign('pay',$pay);
            $this->display('Package/buy/index');
        }else{
            $data = I('post.data','',false);
            if(empty($data['cid'])){
                $back = array(
                    'rel'=>2,
                    'msg'=>GSL('Please-select-customers')
                );
            }elseif(empty($data['pid'])){
                $back = array(
                    'rel'=>3,
                    'msg'=>GSL('Please-select-package')
                );
            }elseif(empty($data['mode'])){
                $back = array(
                    'rel'=>3,
                    'msg'=>GSL('Please-select-payment')
                );
            }else{
                //开始事务
                $model = new Model();
                $model->startTrans();
                $aid = session('admin.id');//管理人员id
                //获取套餐信息
                $packageInfo = $packageApi->packageFind(array('id'=>$data['pid']));
                $residue = 0;
                $content = json_decode($packageInfo['content'],true);
                $info = array();
                foreach($content as $key=>$value){
                    $residue = $residue + $value['num'];
                    $info[$key] = array(
                        'project'=>$value['project'],
                        'sum'=>$value['num'],
                        'num'=>0
                    );
                }
                $infoJson = json_encode($info);//客户购买套餐信息
                //过期时间
                if($packageInfo['date'] == 0){
                    $dateTime = 0;
                }else{
                    $dateTime = time()+$packageInfo['date']*24*60*60;
                }
                //生成支付编号
                $sn = date("Ymd",time()).time().mt_rand(10000,99999);
                $paymentData = array(
                    'sn'=>$sn,
                    'cid'=>$data['cid'],
                    'aid'=>$aid,
                    'money'=>$packageInfo['present'],
                    'type'=>2,//2：套餐支付
                    'status'=>$data['status'],
                    'mode'=>$data['mode'],//支付方式：1；现金支付，2：刷卡支付，3：银行划账
                    'create_at'=>time(),
                    'update_at'=>time()
                );
                $paymentApi = new PaymentApi();
                $paymentResult =$paymentApi->createPayment($paymentData);
                $packageResult = 0;//初始化添加失败
                if($paymentResult['rel'] > 0){
                    $packageData = array(
                        'cid'=>$data['cid'],
                        'aid'=>$aid,
                        'pid'=>$data['pid'],
                        'content'=>$infoJson,
                        'over_at'=>$dateTime,
                        'num'=>0,
                        'residue'=>$residue,
                        'payid'=>$paymentResult['rel'],
                        'create_at'=>time(),
                        'update_at'=>time()
                    );
                    $packageResult = $packageApi->CustomerPackage($packageData);
                }
                if($packageResult){
                    //成功则提交
                    $model->commit();
                    $back = array('rel'=>1,'msg'=>GSL('success'));
                }else{
                    //失败则回滚
                    $model->rollback();
                    $back = array('rel'=>0,'msg'=>GSL('failed'));
                }
            }
            $this->ajaxReturn($back);
        }
    }

    public function Usage(){

    }
}