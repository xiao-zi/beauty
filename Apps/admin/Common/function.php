<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28 0028
 * Time: 16:10
 */


/**
 * 数状结构数据
 * @param $list
 * @param string $id
 * @param string $pid
 * @param string $child
 * @param int $root
 * @return array
 */
function getTree($list, $id='id', $pid = 'pid', $child = 'child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$id]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * @param $file 上传的文件
 * @param $url 文件的保存路径
 * @param string $autoSub 是否创建新的文件
 * @return string
 */
function uploadFile($file,$url,$autoSub = 'true')
{
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728000 ;// 设置附件上传大小
    $upload->exts      =     array('rmvb', 'wmv', 'mp4','jpg', 'gif', 'png', 'jpeg','doc','rar','zip');// 设置附件上传类型
    $upload->rootPath  =	 $url; // 设置附件上传根目录
    $upload->autoSub  =$autoSub;
    // 上传单个文件
    $info   =   $upload->uploadOne($file);
    if($info) {
        return $info['savepath'].$info['savename'];// 上传成功 获取上传文件信息
    }
}

/**
 * 获取网站的配置
 */
function getConfig(){
    $config = M('AdminConfig');
    $configData = $config->select();
    $data = array();
    foreach($configData as $key=>$value){
        $data[$value['name']] = $value['value'];
    }
    return $data;
}

/**
 * 验证字段
 * @param $table 数据库表的名称
 * @param $root 验证的规则
 * @param $data 验证的数据
 */
function Verification($table,$root,$data,$verify = true){
    $return = array();
    foreach($root as $key =>$value){
        for($i=0;$i<count($value);$i++){
            switch($value[$i][0]){
                case 'unique':unique($table,$key,$data[$key],$value[$i][2]) == ''? '':$return[]=unique($table,$key,$data[$key],$value[$i][2]);break;
                case 'request':request($data[$key],$value[$i][2]) == ''? '':$return[]=request($data[$key],$value[$i][2]);break;
                case 'regular':regular($data[$key],$value[$i][1],$value[$i][2]) == ''? '':$return[]=regular($data[$key],$value[$i][1],$value[$i][2]);break;
                case 'select':selectValue($data[$key],$value[$i][1],$value[$i][2]) == ''? '':$return[]=selectValue($data[$key],$value[$i][1],$value[$i][2]);break;
                default :
            }
        }
    }
    if($verify){
        return implode("|", $return);
    }else{
        return $return[0];
    }
}

/**
 * 验证是否唯一，系统会根据字段目前的值查询数据库来判断是否存在相同的值，当表单数据中包含主键字段时unique不可用于判断主键字段本身
 * @param $table 表名
 * @param $key 数据库字段
 * @param $str 检查的字符串
 * @param $msg 返回的错误信息
 * @return mixed 返回结果
 */
function unique($table,$key,$str,$msg){
    $map[$key] = $str;
    $result = $table->where($map)->find();
    if($result){
        return $msg;
    }
}

/**
 * 验证是否存在
 * @param $str 验证的字符串
 * @param $msg 返回的错误信息
 * @return mixed 返回结果
 */
function request($str,$msg){
    if(!isset($str) || $str == '' || $str == null){
        return $msg;
    }
}

/**
 * 使用正则表达式验证
 * @param $str 验证的字符串
 * @param $regular 正则表达式
 * @param $msg 返回的错误信息
 */
function regular($str,$regular,$msg){
    $result = preg_match($regular, $str);
    if(!$result){
        return $msg;
    }
}

/**
 * 验证填写的信息是否在选择之内
 * @param $str
 * @param $regular
 * @param $msg
 * @return mixed
 */
function selectValue($str,$regular,$msg){
    $arr = explode(',',$regular);
    if(!in_array($str,$arr)){
        return $msg;
    }
}

/**
 * 把数据库查找的信息转化成键值对
 * @param $data
 * @param $key
 * @param $value
 * @return array
 */
function getKeyValue($data,$key,$value){
    $arr = array();
    foreach($data as $k=>$val){
        $arr[$val[$key]] = $val[$value];
    }
    return $arr;
}
/**
 * 获取系统语言
 * @param int $type 那种语言
 * 1：中文，2：英文
 */
function getLanguage(){
    $language = M('AdminLanguage');
    $data = $language->select();
    return $data;
}
/**
 * 写入语言的json文件
 */
function writeLanguage(){
    $language = M('AdminLanguage');
    $data = $language->select();
    $data = json_encode($data);
    //设置路径目录信息
    $url = './json/language.json';
    $dir_name=dirname($url);
    //目录不存在就创建
    if(!file_exists($dir_name))
    {
        $res = mkdir(iconv("UTF-8", "GBK", $dir_name),0777,true);
    }
    $fp = fopen($url,"a");//打开文件资源通道 不存在则自动创建

    file_put_contents($url, $data);

    fwrite($fp,var_export($data,true)."\r\n");//写入文件
    fclose($fp);//关闭资源通道
}
/**
 * 读取语言的json文件
 */
function readLanguage(){
    //设置路径目录信息
    $url = './json/language.json';
    // 从文件中读取数据到PHP变量
    $json_string = file_get_contents($url);
    if(!$json_string){
        //没有找到语言的json文件则从新创建
        $language = M('AdminLanguage');
        $data = $language->select();
        $data = json_encode($data);
        $dir_name=dirname($url);
        //目录不存在就创建
        if(!file_exists($dir_name))
        {
            $res = mkdir(iconv("UTF-8", "GBK", $dir_name),0777,true);
        }
        $fp = fopen($url,"a");//打开文件资源通道 不存在则自动创建

        file_put_contents($url, $data);
        fclose($fp);//关闭资源通道
        $data = json_decode($data, true);
    }else{
        // 把JSON字符串转成PHP数组
        $data = json_decode($json_string, true);
    }
    return $data;
}
/**
 * 获取语言系统的key值
 * @param $key
 */
function GSL($key){
    $language = readLanguage();
    //获取cookie中的语言
    $type = $_COOKIE['language'];
    switch($type){
        case 'zh':$result = getKeyValue($language,'model','chinese');break;
        case 'eh':$result = getKeyValue($language,'model','english');break;
        default:$result = getKeyValue($language,'model','chinese');
    }
    return $result[$key];
}

/**
 *
 * 发送邮件
 * @param $to 发送的邮箱
 * @param $fname 发送人
 * @param $tname 发送对象
 * @param string $subject 发送标题
 * @param string $body 发送的内容
 * @param $attachment
 * @return bool
 */
function sendEmail($to, $fname,$tname, $subject = '', $body = '', $attachment){
    $config = C('EMAIL');
    Vendor('PHPMailer.PHPMailerAutoload');
    vendor('SMTP');
    $mail = new PHPMailer(); //PHPMailer对象

    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码

    $mail->IsSMTP(); // 设定使用SMTP服务

    $mail->SMTPDebug = 1;//调试邮件

    $mail->SMTPAuth = true; // 启用 SMTP 验证功能

    $mail->SMTPKeepAlive = true;  //保持连接,关闭则是SmtpClose()默认false.

    $mail->SMTPSecure = $config['SMTP_SECURE'];      // Outlook安全协议 常用协议tls与ssl

//    $mail->SMTPSecure = 'ssl'; // 使用安全协议

    $mail->Host = $config['SMTP_HOST']; // SMTP 服务器

    $mail->Port = $config['SMTP_PORT']; // SMTP服务器的端口号

    $mail->Username = $config['SMTP_USER']; // SMTP服务器用户名

    $mail->Password = $config['SMTP_PASS']; // SMTP服务器密码

    $mail->SetFrom($config['FROM_EMAIL'], $fname);

    $replyEmail = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];

    $replyName = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];

    $mail->AddReplyTo($replyEmail, $replyName);

    $mail->Subject = $subject;

    $mail->IsHTML(true); //支持html格式内容

    $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";

    $mail->MsgHTML($body);

    $mail->AddAddress($to,$tname);

    if(is_array($attachment)){ // 添加附件

        foreach ($attachment as $file){

            $mail->AddAttachment($file);

        }

    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
 * 检测图片文件是否存在
 * @param $url 图片链接
 */
function TestingImage($url){
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    //不下载
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    //设置超时
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code == 200) {
        return $url;
    }
    $config = getConfig();
    return $config['IMAGE'];
}

/*
* parameter arr:排序数组,key:按什么排,type:升序降序
 * */
function arraySort($arr,$key,$type='asc'){
    $keyArr = []; // 初始化存放数组将要排序的字段值
    foreach ($arr as $k=>$v){
        $keyArr[$k] = $v[$key]; // 循环获取到将要排序的字段值
    }
    if($type == 'asc'){
        asort($keyArr); // 排序方式,将一维数组进行相应排序
    }else{
        arsort($keyArr);
    }
    foreach ($keyArr as $k=>$v){
        $newArray[$k] = $arr[$k]; // 循环将配置的值放入响应的下标下
    }
    $newArray = array_merge($newArray); // 重置下标
    return $newArray; // 数据返回
}


function text(){
    date_default_timezone_set('Asia/Shanghai');
    echo date("Y-m-d H:i:s",time());
    date_default_timezone_set('America/New_York');
    echo  $_SERVER['HTTP_HOST'];//获取当前域名
    echo date("Y-m-d H:i:s",time());
    $url = $_SERVER['HTTP_HOST'].'/Uploads/head/5cd2321ed91fb0.jpg';
    $ddd = TestingImage($url);
    dump($ddd);
}

function write_log($data){
    $data = json_encode($data);
    $years = date('Y-m');
    //设置路径目录信息
    $url = './public/'.$years.'/'.date('Ymd').'_request_log.json';
    $dir_name=dirname($url);
    //目录不存在就创建
    if(!file_exists($dir_name))
    {
        $res = mkdir(iconv("UTF-8", "GBK", $dir_name),0777,true);
    }
    $fp = fopen($url,"a");//打开文件资源通道 不存在则自动创建

    file_put_contents($url, $data);

        fwrite($fp,var_export($data,true)."\r\n");//写入文件
    fclose($fp);//关闭资源通道
}

function readJson(){
    $years = date('Y-m');
    // 从文件中读取数据到PHP变量
    $json_string = file_get_contents('./public/log/txlog/'.$years.'/'.date('Ymd').'_request_log.json');

    // 把JSON字符串转成PHP数组
    $data = json_decode($json_string, true);

    // 显示出来看看
    var_dump($data);
}

/**
 * 生成select选择器
 * @param string $name name
 * @param string $class class
 * @param $selected 选择的值
 * @param $data 选择的数据
 * @param array $arr 对应$data的值和value
 */
function GenerateSelectHtml($name = '',$class = '',$selected='',$data,$arr = array('id','title')){
    $html = '<select class="'.$class.'" name="'.$name.'" lay-search="" >';
    foreach($data as $key=>$value){
        if($selected == $value[$arr[0]]){
            $html .= '<option value="'.$value[$arr[0]].'" selected>'.$value[$arr[1]].'</option>';
        }else{
            $html .= '<option value="'.$value[$arr[0]].'">'.$value[$arr[1]].'</option>';
        }
    }
    $html .= '</select>';
    return $html;
}

/**
 * 重新生成新的一维数组
 * @param $array
 * @param $key
 */
function getArrayKeyValue($array,$key){
    $arr = array();
    foreach($array as $k=>$val){
        $arr[] = $val[$key];
    }
    return $arr;
}

