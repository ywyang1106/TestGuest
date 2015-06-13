<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月1日
*/
//防止恶意调用
if(!defined('ERRORCALL')){
    exit('Access Deny!');
}
//判断函数是否存在
if(!function_exists('funcAlertReturn')){
    exit('funcAlertReturn()函数不存在，请检查！');
}
if (!function_exists('funcMysqlString')){
    exit('funcMysqlString()函数不存在，请检查!');
}
/**
 * funcSetCookies函数生成登录cookies
 * @access public
 * @param string $sUsername
 * @param string $sUniqid
 */
function funcSetCookies($sUsername, $sUniqid, $sKeeptime){
    switch($sKeeptime){
        case '0'://浏览器进程时间，即关闭前
            setcookie('username', $sUsername);
            setcookie('uniqid', $sUniqid);
            break;
        case '1'://一天
            setcookie('username', $sUsername, time() + 86400);
            setcookie('uniqid', $sUniqid, time() + 86400);
            break;
        case '2'://一周
            setcookie('username', $sUsername, time() + 604800);
            setcookie('uniqid', $sUniqid, time() + 604800);
            break;
        case '3'://一月
            setcookie('username', $sUsername, time() + 2592000);
            setcookie('uniqid', $sUniqid, time() + 2592000);
            break;
    }
}
/**
 * funcVerifyUsername()函数表示检测并过滤用户名
 * @access public
 * @param string $sString 受污染的用户名
 * @param int $iMinNum  最小位数
 * @param int $iMaxNum 最大位数
 * @return string 过滤后的用户名
 */
function funcVerifyUsername($sString, $iMinNum=2, $iMaxNum=16){
    //去掉首尾空格
    $sString = trim($sString);
    //长度小于2位或者大于20位
    if(mb_strlen($sString, 'utf-8') < $iMinNum || mb_strlen($sString, 'utf-8') > $iMaxNum){
        funcAlertReturn('用户名长度不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    //限制敏感字符
    $sCharPattern = '/[<>\'\"\ \  ]/';
    if(preg_match($sCharPattern, $sString)){
        funcAlertReturn('用户名不得包含敏感字符');
    }
    //将用户名转义输入
    return funcMysqlString($sString);
}
/**
 * funcVerifyPassword密码验证
 * @access public
 * @param string $sFirstPassword
 * @param int $iMinNum
 * @param int $iMaxNum
 * @return string $sFirstPassword返回一个加密后的密码
 */
function funcVerifyPassword($sFirstPassword, $iMinNum=6, $iMaxNum=32){
    //判断密码长度是否符号要求
    if(strlen($sFirstPassword) < $iMinNum || strlen($sFirstPassword) > $iMaxNum){
        funcAlertReturn('密码不得小于'.$iMinNum.'位或大于'.$iMaxNum.'位！');
    }
    return funcMysqlString(sha1($sFirstPassword));
}
/**
 * funcVerifyKeeptime函数对保留值字段进行验证
 * @access public
 * @param string $sString
 * @return string
 */
function funcVerifyKeeptime($sString){
    $aKeeptimes = array('0', '1', '2', '3');
    if(!in_array($sString, $aKeeptimes)){
        funcAlertReturn('保留方式不正确');
    }
    return funcMysqlString($sString);
}
?>
