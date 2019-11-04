<?php

return array(
	//'配置项'=>'配置值'
    'LOAD_EXT_CONFIG' => 'Navigation',

    //邮箱配置
    'EMAIL' => array(

        'SMTP_HOST' => 'smtp.qq.com', //SMTP服务器

        'SMTP_PORT' => '465', //SMTP服务器端口

        'SMTP_USER' => 'hehangwei@foxmail.com', //SMTP服务器用户名

        'SMTP_PASS' => 'qwxqjqbqggwldjah', //SMTP服务器密码

        'SMTP_SECURE'=>'ssl',

        'FROM_EMAIL' => 'hehangwei@foxmail.com',

        'FROM_NAME' => '', //发件人名称

        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）

        'REPLY_NAME' => '', //回复名称（留空则为发件人名称）

        'SESSION_EXPIRE'=>'72',
    ),

    //价格单位的展示
    'MONEY' => '$',

    //短信的消息编辑
    'SHORT_MESSAGE' => array(
        //赠送优惠券的短信通知 在CouponModel写  #USER#:用户名，#TIME#:时间，#CONTENT#:优惠券内容，#TITLE#:优惠券标题
        'GIVE_COUPON_MESSAGE' => '尊敬的用户：#USER#，恭喜你获取了一张我们特意准备的一张#TITLE#，#CONTENT#，使用时间：#TIME#，请你及时使用',
    ),

    //支付方式
    'PAY_MODEL'=> array(
        array(
            'type'=>1,
            'title'=>'Cash-payment',
        ),
        array(
            'type'=>2,
            'title'=>'Credit-card-payment',
        ),
        array(
            'type'=>3,
            'title'=>'Bank-accounts',
        ),
    ),
    //支付状态
    'PAY_STATUS'=>array(
        1=>'未到账',
        2=>'已到账'
    ),
);