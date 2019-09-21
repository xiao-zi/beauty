<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23 0023
 * Time: 15:55
 */

namespace admin\Controller;


use User\Api\ProductApi;
use User\Api\ReservationApi;

class ReservationController extends CommonController
{
    /**
     * 预订列表
     */
    public function index(){
        $this->display('Reservation/index');
    }

    public function ajaxReservation(){
        $data = I('post.','',false);
        /*关键字搜索*/
        $keywords = $data['keywords'];
        $map = array();
        if($keywords != ''){
            $map['CONCAT(first_name,last_name,phone,email)'] = array('like','%'.$keywords.'%');
        }
        $data['date'] != '' ? $map['date'] = $data['date'] : false;
        $data['time'] != '' ? $map['time'] = $data['time'] : false;
        $data['status'] != '' ? $map['status'] = $data['status'] : false;
        //获取当前所有的客户
        $ReservationApi = new ReservationApi();
        //总条数
        $count = M('reservation')->where($map)->count();
        //分页类
        $Page = new \Think\Page($count,10);
        $show  = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;
        $Reservation = $ReservationApi->selectReservation($map,'create_at',$limit,'id,aid,first_name,last_name,phone,email,date,time,status,create_at,update_at,remark,product,phone_code');
        $product = new ProductApi();
        $user = M('admin_user');
        foreach($Reservation as $key=>$value){
            $productMap = array('id'=>array('in',$value['product']));
            $productData = $product->selectProduct($productMap,'','','chinese,english');
            $Reservation[$key]['product'] = $productData;
            $Reservation[$key]['adminName'] = $user->where(array('id'=>$value['aid']))->getField('realname');
        }
        $back['pagenum'] = $count;
        $back['pages'] = 10;
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('data',$Reservation);
        $back['html'] = $this->fetch();
        $this->ajaxReturn($back);
    }

    /**
     * 创建预订页面
     */
    public function createReservation(){
        $product = new ProductApi();
        $map = array(
            'status'=>'activation'
        );
        $productData = $product->selectProduct($map,'','','');
        $this->assign('product',$productData);
        $this->display('Reservation/create');
    }

    /**
     * 创建预订数据
     */
    public function createReservationData(){
        $data = I('post.','',false);
        $data['aid'] = session('admin.id');
        $data['phone_code'] = $data['phoneCode'];
        $data['product'] = implode(',',$data['product']);
        $data['create_at'] = time();
        $data['update_at'] = time();
        $reservation = new ReservationApi();
        $result = $reservation->createReservation($data);
        $this->ajaxReturn($result);
    }

    /**
     * 修改预订信息
     * @param $id 修改的id
     */
    public function updateReservation($id){
        $ReservationApi = new ReservationApi();
        $map = array('id'=>$id);
        $Reservation = $ReservationApi->findReservation($map,'');
        $Reservation['product'] = explode(',',$Reservation['product']);
        $product = new ProductApi();
        $productMap = array(
            'status'=>'activation'
        );
        $productData = $product->selectProduct($productMap,'','','');
        $this->assign('product',$productData);
        $this->assign('data',$Reservation);
        $this->display('Reservation/update');
    }

    /**
     * 创建预订数据
     */
    public function updateReservationData($id){
        $data = I('post.','',false);
        $data['aid'] = session('admin.id');
        $data['phone_code'] = $data['phoneCode'];
        $data['product'] = implode(',',$data['product']);
        $data['update_at'] = time();
        $map = array('id'=>$id);
        $reservation = new ReservationApi();
        $result = $reservation->updateReservation($map,$data);
        $this->ajaxReturn($result);
    }

    /**
     *
     * @param $id 预订表的id
     */
    public function getPhone($id){
        $this->assign('id',$id);
        $this->display('Reservation/sendMessage');
    }

    /**
     * 添加发送短信记录
     * @param $id
     */
    public function sendReservationMessage($id){
        $data = I('post.','',false);
        $content = $data['content'];
        $ReservationApi = new ReservationApi();
        $map = array('id'=>$id);
        $Reservation = $ReservationApi->findReservation($map,'');
        $smsData = array(
            'phone_code'=>$Reservation['phone_code'],//手机号前缀
            'phone'=>$Reservation['phone'],//手机号
            'cid'=>0,//客户的id
            'aid'=>session('admin.id'),//发送短信的人员
            'message'=>$content,//短信内容
            'status'=>0,//状态 0 未发送，1发送成功 2发送失败
            'created_time'=>time(),
            'updated_time'=>time(),
        );
        $result = $this->createSms($smsData);
        $this->ajaxReturn($result);
    }

    /**
     * 预订的发送邮箱通知
     * @param $id
     */
    public function getEmail($id){
        $this->assign('id',$id);
        $this->display('Reservation/sendEmail');
    }
    /**
     * 添加发送邮箱录
     * @param $id
     */
    public function sendReservationEmail($id){
        $data = I('post.','',false);
        $content = $data['content'];
        $ReservationApi = new ReservationApi();
        $map = array('id'=>$id);
        $Reservation = $ReservationApi->findReservation($map,'');
        $emailData = array(
            'email'=>$Reservation['email'],//邮箱
            'content'=>$content,//邮箱内容
            'cid'=>0,//客户的id
            'aid'=>session('admin.id'),//发送邮件的人员
            'status'=>0,//状态 0 未发送，1发送成功 2发送失败
            'create_at'=>time(),
            'update_at'=>time(),
        );
        $result = $this->createEmail($emailData);
        $this->ajaxReturn($result);
    }

    /**
     * 修改预订状态
     * @param $id
     * @param $status
     */
    public function updateStatus($id,$status){
        $reservation = new ReservationApi();
        $map = array('id'=>$id);
        $data = array(
            'aid'=>session('admin.id'),//管理员
            'status'=>$status,
            'update_at'=>time()
        );
        $result = $reservation->updateReservationStatus($map,$data);
        $this->ajaxReturn($result);
    }

    /**
     * @param $id 获取备注信息
     */
    public function getRemark($id){
        $ReservationApi = new ReservationApi();
        $map = array('id'=>$id);
        $Reservation = $ReservationApi->findReservation($map,'id,remark');
        $this->assign('data',$Reservation);
        $this->display('Reservation/updateRemark');
    }

    public function updateRemark($id){
        $data = I('post.','',false);
        $data['aid'] = session('admin.id');
        $map = array('id'=>$id);
        $reservation = new ReservationApi();
        $result = $reservation->updateReservationRemark($map,$data);
        $this->ajaxReturn($result);
    }


}