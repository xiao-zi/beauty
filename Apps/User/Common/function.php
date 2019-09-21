<?php
/**
 * 后台系统密码加密
 * @param  string $str 要加密的字符串
 * @return string
 */
function PasswordEncryption($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}




