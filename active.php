<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年5月31日
*/
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'active');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//开始激活处理
if(!isset($_GET['active'])){
    funcAlertReturn('非法操作active');
}
if(isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok'){
    $sActive = funcMysqlString($_GET['active']);
    //SQL查询语句
    $sSqlStatements = "
        SELECT tg_active 
        FROM tg_user 
        WHERE tg_active='$sActive' 
        LIMIT 1";
    if(funcFetchArray($sSqlStatements)){
        //将tg_acitve设置为空
        $sSqlStatements = "
            UPDATE tg_user 
            SET tg_active=NULL 
            WHERE tg_active='$sActive' 
            LIMIT 1";
        funcSqlQuery($sSqlStatements);
        if(funcAffectRows() == 1){
            funcCloseMysql();
            funcAlertJump('账户激活成功', 'login.php');
        }
        else{
            funcCloseMysql();
            funcAlertJump('账户激活失败', 'register.php');
        }
    }
    else{
        funcAlertReturn('非法操作');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="active">
        <h2>激活账户</h2>
        <p>本页面是为了模拟您的邮件的功能，点击以下超级链接激活您的账户</p>
        <p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active'] ?>">
            <?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>?action=ok&amp;active=<?php echo $_GET['active'] ?>
        </a></p>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>