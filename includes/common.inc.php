<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年5月29日
*/
//防止恶意调用
if(!defined('ERRORCALL')){
    exit('Access Deny!');
}
//设置字符集编码
header('Content-Type:text/html;charset=utf-8');
//转换硬路径常量
define('ROOT_PATH', substr(dirname(__FILE__), 0, -8));//8代表 includes的总字母数
//创建一个提示自动转义状态常量的状态
define('GPC', get_magic_quotes_gpc());
//拒绝PHP低版本
if(PHP_VERSION < '4.1.0'){
    exit('Version is too low!');
} 
//引入核心函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';
//程序开始时间
//define('START_TIME', funcRunTime());
$GLOBALS['sStartTime'] = funcRunTime();
//usleep(2000000);//代表延时2秒  
//数据库连接
//常量定义
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '19901106');
define('DB_NAME','testguest');
//初始化数据库，包含三个步骤
funcConnectMysql();//创建数据库连接
funcSelectDb();//选择数据库
funcSetCoding();//选择字符集
//新信息提醒
$sSqlStatements = "
    SELECT COUNT(tg_id) AS count 
    FROM tg_message 
    WHERE tg_state=0 AND tg_toUser='{$_COOKIE['username']}'";
$aNewMessage = funcFetchArray($sSqlStatements);
if(empty($aNewMessage['count'])){
    $GLOBALS['numNewMessage'] = '<strong class="noread"><a href="memberCheckMessage.php">(0)</a></strong>';
}
else{
    $GLOBALS['numNewMessage'] = '<strong class="read"><a href="memberCheckMessage.php">('.$aNewMessage['count'].')</a></strong>';
}
//网站系统设置初始化
$sSqlStatements = "
    SELECT
        tg_webname, tg_article, tg_blog, tg_photo, tg_skin,
		tg_string, tg_post, tg_re, tg_captcha, tg_register
    FROM tg_system
    WHERE tg_id=1
    LIMIT 1";
$aResult = funcFetchArray($sSqlStatements);
if(!!$aResult){
    $aSystem = array();
    $aSystem['webname'] = $aResult['tg_webname'];
    $aSystem['article'] = $aResult['tg_article'];
    $aSystem['blog'] = $aResult['tg_blog'];
    $aSystem['photo'] = $aResult['tg_photo'];
    $aSystem['skin'] = $aResult['tg_skin'];
    $aSystem['post'] = $aResult['tg_post'];
    $aSystem['re'] = $aResult['tg_re'];
    $aSystem['captcha'] = $aResult['tg_captcha'];
    $aSystem['register'] = $aResult['tg_register'];
    $aSystem['string'] = $aResult['tg_string'];
    $aSystem = funcConvertHtml($aSystem);
    //如果有skin的cookie那么就替代系统数据库的皮肤
    if ($_COOKIE['skin']) {
        $aSystem['skin'] = $_COOKIE['skin'];
    }
}
else{
    exit('系统表异常，请管理员检查！');
}
?>