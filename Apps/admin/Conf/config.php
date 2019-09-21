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
);