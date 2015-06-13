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
//防止恶意调用
if(!defined('ERRORCALL')){
    exit('Access Deny!');
}
//判断函数是否存在
if(!(function_exists('funcAlertReturn'))){
    exit('funcAlertReturn()函数不存在，请检查！');
}
/**
 * funcVerifyUniqid函数对唯一标示符进行匹配，若不匹配则标示符异常，有攻击行为
 * @access public
 * @param string $sUniqid1
 * @param string $sUniqid2
 * @return string
 */
function funcVerifyUniqid($sUniqid1, $sUniqid2){
    if(strlen($sUniqid1) != 40 || ($sUniqid1 != $sUniqid2)){
        funcAlertReturn('唯一标示符异常');
    }
    return funcMysqlString($sUniqid1);
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
    $sCharPattern = '/[<>\'\"\ ]/';
    if(preg_match($sCharPattern, $sString)){
        funcAlertReturn('用户名不得包含敏感字符');
    }
    //限制敏感用户名
    global $aSystem;
    $sSensitiveName = explode('|', $aSystem['string']);
    //告诉用户，有哪些不能注册
    foreach($sSensitiveName as $value){
        $sSensitiveNames .= '['.$value.']'.'\n';
    }
    //这里暂时采用绝对匹配
    if(in_array($sString, $sSensitiveName)){
        funcAlertReturn($sSensitiveNames.'敏感用户名不得注册');
    }
    //将用户名转义输入
    return funcMysqlString($sString);
}
/**
 * funcVerifyPassword密码验证
 * @access public
 * @param string $sFirstPassword
 * @param string $sSecondPassword
 * @param int $iMinNum
 * @param int $iMaxNum
 * @return string $sFirstPassword返回一个加密后的密码
 */
function funcVerifyPassword($sFirstPassword, $sSecondPassword, $iMinNum=6, $iMaxNum=32){
    //判断密码长度是否符号要求
    if(strlen($sFirstPassword) < $iMinNum || strlen($sFirstPassword) > $iMaxNum){
        funcAlertReturn('密码不得小于'.$iMinNum.'位或大于'.$iMaxNum.'位！');
    }
    //密码和确认密码必须一致
    if($sFirstPassword != $sSecondPassword){
        funcAlertReturn('密码和确认密码不一致！');
    }
    return funcMysqlString(sha1($sFirstPassword));
}
/**
 * funcVerifyModifyPassword修改密码验证
 * @access public
 * @param string $sPassword
 * @param int $iMinNum
 * @param int $iMaxNum
 * @return string $sPassword返回一个加密后的密码
 */
function funcVerifyModifyPassword($sPassword, $iMinNum=6, $iMaxNum=32){
    //判断密码长度是否符号要求
    if(!empty($sPassword)){
        if(strlen($sPassword) < $iMinNum || strlen($sPassword) > $iMaxNum){
            funcAlertReturn('密码不得小于'.$iMinNum.'位或大于'.$iMaxNum.'位！');
        }
    }
    else{
        return null;
    }
    return funcMysqlString(sha1($sPassword));
}
/**
 * funcVerifyQuestion函数返回密码提示
 * @access public
 * @param string $sQuestion
 * @param int $iMinNum
 * @param int $iMaxNum
 * @return string 返回密码提示
 */
function funcVerifyQuestion($sQuestion, $iMinNum=4, $iMaxNum=20){
    $sQuestion = trim($sQuestion);
    //长度小于4位或者大于20位
    if(mb_strlen($sQuestion, 'utf-8') < $iMinNum || mb_strlen($sQuestion, 'utf-8') > $iMaxNum){
        funcAlertReturn('密码提示长度不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    //返回密码提示
    return funcMysqlString($sQuestion);
}
/**
 * funcVerifyAnswer函数返回加密的回答
 * @access public
 * @param string $sAnswer
 * @param string $sQuestion
 * @param int $iMinNum
 * @param int $iMaxNum
 * @return string 返回加密的回答
 */
function funcVerifyAnswer($sAnswer, $sQuestion, $iMinNum=4, $iMaxNum=20){
    $sAnswer = trim($sAnswer);
    //长度小于4位或者大于20位
    if(mb_strlen($sAnswer, 'utf-8') < $iMinNum || mb_strlen($sAnswer, 'utf-8') > $iMaxNum){
        funcAlertReturn('密码回答长度不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    //密码提示与回答不能一致
    if($sAnswer == $sQuestion){
        funcAlertReturn('密码提示与回答不能一致');
    }
    //加密返回
    return funcMysqlString(sha1($sQuestion));
}
/**
 * funcVerifySex对性别进行处理
 * @access public
 * @param boolean $sSex
 * @return string
 */
function funcVerifySex($sSex){
    return funcMysqlString($sSex);
}
/**
 * funcVerifyAvatar对头像进行处理
 * @access public
 * @param string $sAvatar
 * @return string
 */
function funcVerifyAvatar($sAvatar){
    return funcMysqlString($sAvatar);
}
/**
 * funcVerifEmail函数对邮件格式进行审查
 * @access public
 * @param string $sEmail
 * @return NULL|string 若为空返回NULL，否则返回电子邮箱
 */
function funcVerifyEmail($sEmail, $iMinNum=4, $iMaxNum=40){
    //参考bnbbs@163.com.net.cn
    //任意字符[a-zA-Z0-9] =>\w
    $pattern = '/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/';
    if(!preg_match($pattern, $sEmail)){
        funcAlertReturn('邮件格式不正确');
    }
    if(strlen($sEmail) < $iMinNum || strlen($sEmail) > $iMaxNum){
        funcAlertReturn('邮件长度不合法');
    }
    return funcMysqlString($sEmail);
}
/**
 * funcVerifQQ函数对邮件格式进行审查
 * @access public
 * @param string $sQQ
 * @return NULL|string 若为空返回NULL，否则返回QQ号码
 */
function funcVerifyQQ($sQQ, $iMinNum=5, $iMaxNum=10){
    if(empty($sQQ)){
        return null;
    }
    else{
        $pattern = '/^[1-9]{1}[0-9]{4,9}$/';
        if(!preg_match($pattern, $sQQ)){
            funcAlertReturn('QQ号码不正确');
        }
        if(strlen($sQQ) < $iMinNum || strlen($sQQ) > $iMaxNum){
            funcAlertReturn('QQ长度不合法');
        }
    }
    return funcMysqlString($sQQ);
}
/**
 * funcVerifUrl函数对邮件格式进行审查
 * @access public
 * @param string $sQQ
 * @return NULL|string 若为空返回NULL，否则返回网址
 */
function funcVerifyUrl($sUrl, $iMinNum=6, $iMaxNum=40){
    if(empty($sUrl) || ($sUrl == 'http://')){
        return null;
    }
    else{
        //https://github.com/ywyang1106
        //?匹配任何包含0个或一个前导字符
        $pattern = '/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/';
        if(!preg_match($pattern, $sUrl)){
            funcAlertReturn('网址不正确');
        }
        if(strlen($sUrl) < $iMinNum || strlen($sUrl) > $iMaxNum){
            funcAlertReturn('网址长度不合法');
        }
    }
    return funcMysqlString($sUrl);
}
/**
 * funcVerifyContent函数对传入字符串判断长度是否符号要求
 * @access public
 * @param string $sString
 * @param number $iMinNum
 * @param number $iMaxNum
 * @return string
 */
function funcVerifyContent($sString, $iMinNum=10, $iMaxNum=200){
    //去掉首尾空格
    $sString = trim($sString);
    //长度小于10位或者大于200位
    if(mb_strlen($sString, 'utf-8') < $iMinNum || mb_strlen($sString, 'utf-8') > $iMaxNum){
        funcAlertReturn('信息长度不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    return $sString;
}
/**
 * funcVerifyAutograph函数对传入字符串判断长度是否符号要求
 * @access public
 * @param string $sString
 * @param number $iMinNum
 * @param number $iMaxNum
 * @return string
 */
function funcVerifyAutograph($sString, $iMinNum=0, $iMaxNum=200){
    //去掉首尾空格
    $sString = trim($sString);
    //长度小于10位或者大于200位
    if(mb_strlen($sString, 'utf-8') < $iMinNum || mb_strlen($sString, 'utf-8') > $iMaxNum){
        funcAlertReturn('信息长度不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    return $sString;
}
/**
 * funcVerifyDirName函数对传入字符串判断长度是否符号要求
 * @access public
 * @param string $sString
 * @param number $iMinNum
 * @param number $iMaxNum
 * @return string
 */
function funcVerifyDirName($sString, $iMinNum=0, $iMaxNum=200){
    //去掉首尾空格
    $sString = trim($sString);
    //长度小于10位或者大于200位
    if(mb_strlen($sString, 'utf-8') < $iMinNum || mb_strlen($sString, 'utf-8') > $iMaxNum){
        funcAlertReturn('名称长度不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    return $sString;
}
/**
 * funcVerifyDirPassword密码验证
 * @access public
 * @param string $sFirstPassword
 * @param string $sSecondPassword
 * @param int $iMinNum
 * @param int $iMaxNum
 * @return string $sFirstPassword返回一个加密后的密码
 */
function funcVerifyDirPassword($sFirstPassword, $iMinNum=6, $iMaxNum=32){
    //判断密码长度是否符号要求
    if(strlen($sFirstPassword) < $iMinNum || strlen($sFirstPassword) > $iMaxNum){
        funcAlertReturn('密码不得小于'.$iMinNum.'位或大于'.$iMaxNum.'位！');
    }
    return funcMysqlString(sha1($sFirstPassword));
}
/**
 * funcVerifyPostTitle函数对传入字符串判断长度是否符号要求
 * @access public
 * @param string $sString
 * @param number $iMinNum
 * @param number $iMaxNum
 * @return string
 */
function funcVerifyPostTitle($sString, $iMinNum=2, $iMaxNum=40){
    //去掉首尾空格
    $sString = trim($sString);
    //长度小于10位或者大于200位
    if(mb_strlen($sString, 'utf-8') < $iMinNum || mb_strlen($sString, 'utf-8') > $iMaxNum){
        funcAlertReturn('帖子标题不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    return $sString;
}
/**
 * funcVerifyPostContent函数对传入字符串判断长度是否符号要求
 * @access public
 * @param string $sString
 * @param number $iMinNum
 * @param number $iMaxNum
 * @return string
 */
function funcVerifyPostContent($sString, $iMinNum=10, $iMaxNum=40000000){
    //去掉首尾空格
    $sString = trim($sString);
    //长度小于10位或者大于200位
    if(mb_strlen($sString, 'utf-8') < $iMinNum || mb_strlen($sString, 'utf-8') > $iMaxNum){
        funcAlertReturn('帖子内容不得小于'.$iMinNum.'位或者大于'.$iMaxNum.'位');
    }
    return $sString;
}
function funcVerifyPhotoUrl($sString){
    if(empty($sString)){
        funcAlertReturn('地址不能为空');
    }
    return $sString;
}
?>
