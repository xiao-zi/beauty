<?php
namespace admin\Controller;
use Think\Controller;
use User\Api\EmailApi;
use User\Api\SmsApi;

class CommonController extends Controller {
    public $language = array();
    /**
     * 后台控制器初始化
     * 查看用户是否登录
     */
    function _initialize()
    {
        header("Content-type: text/html; charset=utf-8");
        if(!session('admin.id')){
            //获取后台登录cookie
            $dataStr = $_COOKIE['Login'];
            if(!empty($dataStr)){
                $data = json_decode($dataStr,true);
                $_SESSION['admin'] = $data;
            }else{
                header("location:/admin.php/Login/index.html");
            }
            exit;
        }else{
            //获取网站的配置信息
            $configData = getConfig();
            /**
             * 设置时区
             */
            date_default_timezone_set($configData['WEBSITE-TIME-ZONE']);
            $this->assign('config',$configData);
            //获取当前用户的信息
            $userID = session('admin.id');
            $user = M('AdminUser');
            $userInfo = $user->join('admin_group on admin_group.id = admin_user.grouping')->where('admin_user.id='.$userID)->field('admin_user.*,admin_group.title as groups')->find();
            $this->assign('userInfo',$userInfo);
            //获取语言
            $this->getLanguage();
            $this->assign('language',$this->language);
        }
    }

    /**
     * 修改系统语言
     */
    public function changeLanguage($language){
        //语言的cookie设置成一年
        setcookie('language', $language,time()+60*60*24*365,'/');
        header("location:/admin.php/Index/index.html");
    }

    /**
     * 把语言数据库给全局变量
     */
    public function getLanguage(){
        //获取语言缓存
        $language = readLanguage();
        //获取cookie中的语言
        $type = $_COOKIE['language'];
        if($language == false || count($language) == 0){//如果没有缓存
            //重新生成语言缓存
            $language = getLanguage();
            //缓存时间设置成一年
            S('language',$language,3600*24*365);
        }
        switch($type){
            case 'zh':$result = getKeyValue($language,'model','chinese');break;
            case 'eh':$result = getKeyValue($language,'model','english');break;
            default:$result = getKeyValue($language,'model','chinese');
        }
        $this->language = $result ;
    }

    /**
     * 把短信信息添加到数据库中
     * @param $data 添加的数据
     * @return mixed
     */
    public function createSms($data){
        $sms = new SmsApi();
        $result = $sms->createSMS($data);
        return $result;
    }

    /**
     * 发送短信的定时任务，每两秒发送一次
     */
    public function messageTiming(){
        ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
        set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
        $interval=5;// 每隔2秒运行
        do{
            $sms = new SmsApi();
            $count = $sms->countSMS(array('status'=>0));//统计查询的未发送短信数量
            if($count){
                //查询到添加时间最早的短信
                $data = $sms->findSMS(array('status'=>0),'created_time asc');
                //发送短信的操作
                $result = $this->sendMessage($data['phone_code'].$data['phone'],$data['message']);
                if($result['status'] == 1){
                    $updateData = array(
                        'status'=>1,
                        'updated_time'=>date("Y-m-d H:i:s",time())
                    );
                    $sms->updateSMS(array('id'=>$data['id']),$updateData);
                }else{
                    $updateData = array(
                        'status'=>2,
                        'error_message'=>$result['msg'],
                        'updated_time'=>date("Y-m-d H:i:s",time())
                    );
                    $sms->updateSMS(array('id'=>$data['id']),$updateData);
                }
            }
            sleep($interval);
        }while(true);
    }

    /**
     * 发送短信的操作
     * @param $mobile 手机号
     * @param $content 短信内容
     */
    public function sendMessage($mobile, $content){
        $clapi  = new  \Think\SmsInt();
        $result = $clapi->sendInternational($mobile, $content);
        if(!is_null(json_decode($result))){
            $output=json_decode($result,true);
            if(isset($output['code'])  && $output['code']=='0'){
                return $result = ['status' => 1, 'msg' => '短信发送成功！', 'msgid' => $output['msgid']];
            }else{
                return $result = ['status' => -1, 'msg' => $output['error']];
            }
        }else{
            return $result = ['status' => -1, 'msg' => '短信发送失败！'];
        }
    }

    /**
     * 把发送邮箱的信息加入邮箱队列
     * @param $data
     * @return mixed
     */
    public function createEmail($data){
        $email = new EmailApi();
        $result = $email->createEmail($data);
        return $result;
    }
    /**
     * 发送邮箱的定时任务，每两秒发送一次
     */
    public function emailTiming(){
        ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
        set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
        $interval=10;// 每隔2秒运行
        do{
            $email = new EmailApi();
            $count = $email->countEmail(array('status'=>0));//统计查询的未发送短信数量
            if($count){
                //查询到添加时间最早的短信
                $data = $email->findEmail(array('status'=>0),'create_at asc');
                //发送短信的操作
                $result = $this->sendEmail($data['email'],$data['content']);
                if($result['status'] == 1){
                    $updateData = array(
                        'status'=>1,
                        'update_at'=>date("Y-m-d H:i:s",time())
                    );
                    $email->updateEmail(array('id'=>$data['id']),$updateData);
                }else{
                    $updateData = array(
                        'status'=>2,
                        'error_message'=>$result['msg'],
                        'update_at'=>date("Y-m-d H:i:s",time())
                    );
                    $email->updateEmail(array('id'=>$data['id']),$updateData);
                }
            }
            sleep($interval);
        }while(true);
    }

    /**
     * 发送邮箱的操作
     * @param $email 邮箱
     * @param $content 邮箱内容
     */
    public function sendEmail($email,$content){
        $fname = '北京纳美旅游社有限公司';
        $tname = '纳美会员';
        $title = '邀请函';
        $result = sendEmail($email,$fname,$tname, $title, $content);
        if($result){
            return $result = ['status' => 1, 'msg' => '发送成功'];
        }else{
            return $result = ['status' => -1, 'msg' => '发送失败'];
        }
    }


}