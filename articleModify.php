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
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'articleModify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//登录后才可发帖
if(!isset($_COOKIE['username'])){
    funcAlertJump('发帖前，必须登录', 'login.php');   
}
//将帖子写入数据库
if($_GET['action'] == 'modify'){
    //为了防止恶意注册，跨站攻击
    funcVerifyCaptcha($_POST['captcha'], $_SESSION['captcha']);
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    $sSqlStatements = "
        SELECT tg_uniqid
        FROM tg_user
        WHERE tg_username='{$_COOKIE['username']}'
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){//判定数据库是否有选择的数据，若有再进行数据更改
        //为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        funcVerifyUniqid($aResult['tg_uniqid'], $_COOKIE['uniqid']);
        //开始修改帖子内容
        $aClean = array();
		$aClean['id'] = $_POST['id'];
		$aClean['type'] = $_POST['type'];
		$aClean['title'] = funcVerifyPostTitle($_POST['title']);
		$aClean['content'] = funcVerifyPostContent($_POST['content']);
		$aClean = funcMysqlString($aClean);
        //写入数据库
		$sSqlStatements = "
		    UPDATE tg_article 
		    SET 
		      tg_type='{$aClean['type']}', tg_title='{$aClean['title']}', 
		      tg_content='{$aClean['content']}',tg_last_modify_time=NOW()     
		    WHERE tg_id='{$aClean['id']}'";
        funcSqlQuery($sSqlStatements);
		if(funcAffectRows() == 1){
    		funcCloseMysql();
    		//funcSessionDestroy();
    		funcAlertJump('帖子修改成功！','article.php?id='.$aClean['id']);
        } 
        else{
            funcCloseMysql();
			//funcSessionDestroy();
            funcAlertReturn('帖子修改失败！');
        }
    }
    else{
        funcAlertReturn('非法登录！');
    }
}

//读取数据
if(isset($_GET['id'])){
    $sSqlStatements = "
        SELECT tg_username, tg_title, tg_type, tg_content
        FROM tg_article
        WHERE tg_reid=0
        AND tg_id='{$_GET['id']}'";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        $aWebPageData = array();
        $aWebPageData['id'] = $_GET['id'];
        $aWebPageData['username'] = $aResult['tg_username'];
        $aWebPageData['title'] = $aResult['tg_title'];
        $aWebPageData['type'] = $aResult['tg_type'];
        $aWebPageData['content'] = $aResult['tg_content'];
        $aWebPageData = funcConvertHtml($aWebPageData);
        //判断权限
        if(!isset($_SESSION['admin'])){
            if($_COOKIE['username'] != $aWebPageData['username']){
                funcAlertReturn('你没有权限修改');
            }
        }	
    } 
    else{
        funcAlertReturn('不存在此帖子');
    }
} 
else{
    funcAlertReturn('非法操作');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/captcha.js"></script>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="post">
        <h2>修改帖子</h2>
        <form method="post" name="post" action="?action=modify">
            <input type="hidden" value="<?php echo $aWebPageData['id']?>" name="id" />
            <dl>
                <dt>请认真修改以下内容</dt>
                <dd>类　　型：
                    <?php 
                        foreach(range(1, 16) as $iNumber){
                            if($iNumber == $aWebPageData['type']){
                                echo '<label for="type'.$iNumber.'"><input type="radio" id="type'.$iNumber.'" name="type" value="'.$iNumber.'" checked="checked" /> ';
                            }
                            else{
                                echo '<label for="type'.$iNumber.'"><input type="radio" id="type'.$iNumber.'" name="type" value="'.$iNumber.'" /> ';
                            }
                            echo ' <img src="images/icon'.$iNumber.'.gif" alt="类型" /></label> ';
                            if($iNumber == 8){
                                echo '<br />　　　 　　';
                            }
                        }
                    ?>
                </dd>
                <dd>标　　题：<input type="text" name="title" value="<?php echo $aWebPageData['title']?>" class="text"/>(*必填，2-40位)</dd>
                <dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　
                    <a href="javascript:;">Q图系列[2]</a>　
                    <a href="javascript:;">Q图系列[3]</a>
                </dd>
                <dd>
                    <?php include ROOT_PATH.'includes/ubb.inc.php'?>
                    <textarea name="content" rows="9"><?php echo $aWebPageData['content']?></textarea>
                </dd>
                <dd>验 证 码：
                    <input type="text" name="captcha" class="text captcha" />
                    <img src="captcha.php" id="captcha" />
                    <input type="submit" class="submit" value="修改帖子" />
                </dd>
            </dl>
        </form>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>