<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月8日
*/
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'manageSet');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//必须是管理员才能登录
funcManageLogin(); 
//修改系统表
if($_GET['action'] == 'set'){
    $sSqlStatements = "
    SELECT tg_uniqid
    FROM tg_user
    WHERE tg_username='{$_COOKIE['username']}'
    LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        //引入验证函数文件
        include ROOT_PATH.'includes/verifyLegal.func.php';
        //为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        funcVerifyUniqid($aResult['tg_uniqid'], $_COOKIE['uniqid']);
		$aClean = array();
		$aClean['webname'] = $_POST['webname'];
		$aClean['article'] = $_POST['article'];
		$aClean['blog'] = $_POST['blog'];
		$aClean['photo'] = $_POST['photo'];
		$aClean['skin'] = $_POST['skin'];
		$aClean['post'] = $_POST['post'];
		$aClean['re'] = $_POST['re'];
		$aClean['captcha'] = $_POST['captcha'];
		$aClean['register'] = $_POST['register'];
		$aClean['string'] = $_POST['string'];
		$aClean = funcMysqlString($aClean);
		//写入数据库
		$sSqlStatements = "
		    UPDATE tg_system
		    SET
		        tg_webname='{$aClean['webname']}',
    			tg_article='{$aClean['article']}',
    			tg_blog='{$aClean['blog']}',
    			tg_photo='{$aClean['photo']}',
    			tg_skin='{$aClean['skin']}',
    			tg_post='{$aClean['post']}',
    			tg_re='{$aClean['re']}',
    			tg_captcha='{$aClean['captcha']}',
    			tg_register='{$aClean['register']}',
    			tg_string='{$aClean['string']}'
    	   WHERE tg_id=1
    	   LIMIT 1";
		funcSqlQuery($sSqlStatements);
		if(funcAffectRows() == 1){
			funcCloseMysql();
			//_session_destroy();
			funcAlertJump('恭喜你，修改成功！','manageSet.php');
		} 
		else{
			funcCloseMysql();
			//_session_destroy();
			funcAlertJump('很遗憾，没有任何数据被修改！', 'manageSet.php');
		}
	} 
	else{
		funcAlertReturn('异常！');
	}
}
//读取系统表
$sSqlStatements = "
    SELECT 
        tg_webname, tg_article, tg_blog, tg_photo, tg_skin,
		tg_string, tg_post, tg_re, tg_captcha, tg_register
    FROM tg_system
    WHERE tg_id=1
    LIMIT 1";
$aResult = funcFetchArray($sSqlStatements);
if (!!$aResult){
    $aWebPageData = array();
    $aWebPageData['webname'] = $aResult['tg_webname'];
    $aWebPageData['article'] = $aResult['tg_article'];
    $aWebPageData['blog'] = $aResult['tg_blog'];
    $aWebPageData['photo'] = $aResult['tg_photo'];
    $aWebPageData['skin'] = $aResult['tg_skin'];
    $aWebPageData['string'] = $aResult['tg_string'];
    $aWebPageData['post'] = $aResult['tg_post'];
    $aWebPageData['re'] = $aResult['tg_re'];
    $aWebPageData['captcha'] = $aResult['tg_captcha'];
    $aWebPageData['register'] = $aResult['tg_register'];
    $aWebPageData = funcConvertHtml($aWebPageData);
    //文章
    if($aWebPageData['article'] == 10){
        $aWebPageData['article_html'] = '<select name="article"><option value="10" selected="selected">每页10篇</option><option value="15">每页15篇</option></select>';
    } 
    elseif($aWebPageData['article'] == 15){
        $aWebPageData['article_html'] = '<select name="article"><option value="10">每页10篇</option><option value="15" selected="selected">每页15篇</option></select>';
    }
    //博友
    if($aWebPageData['blog'] == 15){
        $aWebPageData['blog_html'] = '<select name="blog"><option value="15" selected="selected">每页15人</option><option value="20">每页20人</option></select>';
    } 
    elseif($aWebPageData['blog'] == 20){
        $aWebPageData['blog_html'] = '<select name="blog"><option value="20">每页15人</option><option value="20" selected="selected">每页20人</option></select>';
    }
    //相册
    if($aWebPageData['photo'] == 8){
        $aWebPageData['photo_html'] = '<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
    } 
    elseif($aWebPageData['photo'] == 12){
        $aWebPageData['photo_html'] = '<select name="photo"><option value="8">每页8张</option><option value="12" selected="selected">每页12张</option></select>';
    }
    //皮肤
    if($aWebPageData['skin'] == 1){
        $aWebPageData['skin_html'] = '<select name="skin"><option value="1" selected="selected">一号皮肤</option><option value="2">二号皮肤</option><option value="3">三号皮肤</option></select>';
    } 
    elseif ($aWebPageData['skin'] == 2){
        $aWebPageData['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2" selected="selected">二号皮肤</option><option value="3">三号皮肤</option></select>';
    } 
    elseif($aWebPageData['skin'] == 3){
        $aWebPageData['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2">二号皮肤</option><option value="3" selected="selected">三号皮肤</option></select>';
    }
    //发帖
    if($aWebPageData['post'] == 30){
        $aWebPageData['post_html'] = '<input type="radio" name="post" value="30" checked="checked" /> 30秒 <input type="radio" name="post" value="60" /> 1分钟 <input type="radio" name="post" value="180" /> 3分钟';
    } 
    elseif($aWebPageData['post'] == 60){
        $aWebPageData['post_html'] = '<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" checked="checked" /> 1分钟 <input type="radio" name="post" value="180" /> 3分钟';
    } 
    elseif($aWebPageData['post'] == 180){
        $aWebPageData['post_html'] = '<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" /> 1分钟 <input type="radio" name="post" value="180" checked="checked" /> 3分钟';
    }
    //回帖
    if($aWebPageData['re'] == 15){
        $aWebPageData['re_html'] = '<input type="radio" name="re" value="15" checked="checked" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" /> 45秒';
    } 
    elseif($aWebPageData['re'] == 30){
        $aWebPageData['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" checked="checked" /> 30秒 <input type="radio" name="re" value="45" /> 45秒';
    }
    elseif($aWebPageData['re'] == 45){
        $aWebPageData['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" checked="checked" /> 45秒';
    }
    //验证码
    if($aWebPageData['captcha'] == 1){
        $aWebPageData['captcha_html'] =  '<input type="radio" name="captcha" value="1" checked="checked" /> 启用 <input type="radio" name="captcha" value="0" /> 禁用';
    } 
    else{
        $aWebPageData['captcha_html'] =  '<input type="radio" name="captcha" value="1" /> 启用 <input type="radio" name="captcha" value="0" checked="checked"  /> 禁用';
    }
    //放开注册
    if($aWebPageData['register'] == 1){
        $aWebPageData['register_html'] =  '<input type="radio" name="register" value="1" checked="checked" /> 启用 <input type="radio" name="register" value="0" /> 禁用';
    } 
    else{
        $aWebPageData['register_html'] =  '<input type="radio" name="register" value="1" /> 启用 <input type="radio" name="register" value="0" checked="checked" /> 禁用';
    }
} 
else{
    funcAlertReturn('系统表读取错误！请联系管理员检查！');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
    <body>
    <?php 
	   require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="manage">
        <?php 
        	require ROOT_PATH.'includes/manage.inc.php';
        ?>
    	<div id="manageMainArea">
    		<h2>后台管理中心</h2>
    		<form method="post" action="?action=set">
    		<dl>
    			<dd>·网 站 名 称：<input type="text" name="webname" class="text" value="<?php echo $aWebPageData['webname']?>" /></dd>
        		<dd>·文章每页列表数：<?php echo $aWebPageData['article_html'];?></dd>
        		<dd>·博客每页列表数：<?php echo $aWebPageData['blog_html'];?></dd>
        		<dd>·相册每页列表数：<?php echo $aWebPageData['photo_html'];?></dd>
        		<dd>·站点 默认 皮肤：<?php echo $aWebPageData['skin_html'];?></dd>
        		<dd>·非法 字符 过滤：<input type="text" name="string" class="text" value="<?php echo $aWebPageData['string'];?>" /> (*请用|线隔开)</dd>
    			<dd>·每次 发帖 限制：<?php echo $aWebPageData['post_html'];?></dd>
    			<dd>·每次 回帖 限制：<?php echo $aWebPageData['re_html'];?></dd>
    			<dd>·是否 启用 验证：<?php echo $aWebPageData['captcha_html'];?></dd>
    			<dd>·是否 开放 注册：<?php echo $aWebPageData['register_html'];?></dd>
    			<dd><input type="submit" value="修改系统设置" class="submit" /></dd>
    		</dl>
    		</form>
    	</div>
    </div>
    <?php 
    	require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>