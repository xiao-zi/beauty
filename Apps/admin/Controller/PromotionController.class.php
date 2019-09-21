<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\CustomerApi;
use User\Api\EmailApi;
use User\Api\SmsApi;
use User\Api\UserApi;

class PromotionController extends CommonController {

    public function message(){
        //获取所有的用户信息
        $customerAPI = new CustomerApi();
        $customerGroup = $customerAPI->selectCustomer('','','','id,username,cartnum');
        //获取所有后台人员信息
        $userAPI = new UserApi();
        $userGroup = $userAPI->selectUser('','','','id,realname');
        $this->assign('customerGroup',$customerGroup);
        $this->assign('userGroup',$userGroup);
        $this->display('Promotion/message');
    }

    /**
     * 搜索短信
     */
    public function ajaxMessage(){
        $data = I('post.','',false);//获取搜索的数据
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['phone'] = array('like', '%' . $keywords . '%');
        }

        $data['status'] != '' ? $map['status'] = $data['status'] : false;//短信状态
        $data['aid'] != '' ? $map['aid'] = $data['aid'] : false;//发送者
        $data['cid'] != '' ? $map['cid'] = $data['cid'] : false;//接受者

        /*时间筛选*/
        $begin = $data['start'];
        $end = $data['end'];
        $begin != '' ? $begin = strtotime($begin) : $begin = strtotime(date('Y-1'));
        $end != '' ? $end = strtotime($end) : $end = time();
        if($begin && $end){
            $map['created_time'] = array('between',"$begin,$end");
        }
        $sms = new SmsApi();
        //总条数
        $count = $sms->countSMS($map);
        //分页类
        $Page = new \Think\Page($count,10);
        $show  = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;
        $message = $sms->selectSMS($map,'created_time desc',$limit);
        $user = M('AdminUser');
        $customer = M('Customer');
        foreach($message as $key=>$value){
            $message[$key]['sender'] = $user->where(array('id'=>$value['aid']))->getField(['realname']);
            $message[$key]['receiver'] = $customer->where(array('id'=>$value['cid']))->getField(['username']).'('.$customer->where(array('id'=>$value['cid']))->getField(['cartnum']).')';
        }
        $back['pagenum'] = $count;
        $back['pages'] = 10;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$message);
        $back['html'] = $this->fetch();
        $this->ajaxReturn($back);
    }

    /**
     * 短信的重新发送
     */
    public function messageResend(){
        $id = I('id');
        $sms = new SmsApi();
        $status = array('status'=>0);
        $result = $sms->updateSMS(array('id'=>$id),$status);
        $this->ajaxReturn($result);
    }

    /**
     * 查看短信消息
     */
    public function showMessage(){
        $id = I('id');
        $sms = new SmsApi();
        $result = $sms->findSMS(array('id'=>$id),'');
        $this->ajaxReturn($result);
    }

    /**
     * 邮箱的管理列表
     */
    public function mail(){
        //获取所有的用户信息
        $customerAPI = new CustomerApi();
        $customerGroup = $customerAPI->selectCustomer('','','','id,username,cartnum');
        //获取所有后台人员信息
        $userAPI = new UserApi();
        $userGroup = $userAPI->selectUser('','','','id,realname');
        $this->assign('customerGroup',$customerGroup);
        $this->assign('userGroup',$userGroup);
        $this->display('Promotion/mail');
    }

    /**
     * 搜索邮箱列表
     */
    public function ajaxMail(){
        $data = I('post.','',false);//获取搜索的数据
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['email'] = array('like', '%' . $keywords . '%');
        }

        $data['status'] != '' ? $map['status'] = $data['status'] : false;//短信状态
        $data['aid'] != '' ? $map['aid'] = $data['aid'] : false;//发送者
        $data['cid'] != '' ? $map['cid'] = $data['cid'] : false;//接受者

        /*时间筛选*/
        $begin = $data['start'];
        $end = $data['end'];
        $begin != '' ? $begin = strtotime($begin) : $begin = strtotime(date('Y-1'));
        $end != '' ? $end = strtotime($end) : $end = time();
        if($begin && $end){
            $map['create_at'] = array('between',"$begin,$end");
        }
        $sms = new EmailApi();
        //总条数
        $count = $sms->countEmail($map);
        //分页类
        $Page = new \Think\Page($count,10);
        $show  = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;
        $message = $sms->selectEmail($map,'create_at desc',$limit);
        $user = M('AdminUser');
        $customer = M('Customer');
        foreach($message as $key=>$value){
            $message[$key]['sender'] = $user->where(array('id'=>$value['aid']))->getField(['realname']);
            $message[$key]['receiver'] = $customer->where(array('id'=>$value['cid']))->getField(['username']).'('.$customer->where(array('id'=>$value['cid']))->getField(['cartnum']).')';
        }
        $back['pagenum'] = $count;
        $back['pages'] = 10;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$message);
        $back['html'] = $this->fetch();
        $this->ajaxReturn($back);
    }


    /**
     * 邮箱的重新发送
     */
    public function mailResend(){
        $id = I('id');
        $sms = new EmailApi();
        $status = array('status'=>0);
        $result = $sms->updateEmail(array('id'=>$id),$status);
        $this->ajaxReturn($result);
    }

    /**
     * 查看邮箱消息
     */
    public function showMail(){
        $id = I('id');

        $sms = new EmailApi();
        $result = $sms->findEmail(array('id'=>$id),'content');

        $this->assign('data',htmlspecialchars_decode($result['content']));
        $this->display('Promotion/mailContent');
    }

}