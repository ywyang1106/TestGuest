<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年5月30日
*/
session_start();//会话开启
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//运行验证码函数
//默认验证码大小为：75*25，默认位数为4位，若6位，长度推荐125，若8位，则长度为175
//第四个参数，是否需要边框，默认为不需要false，若要，则为true
funcCaptcha();
?>