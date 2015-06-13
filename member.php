<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月2日
*/
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'member');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//是否正常登录
if(isset($_COOKIE['username'])){
    //从数据库获取数据
    $sSqlStatements = "
        SELECT 
            tg_username, tg_sex, tg_avatar, tg_email, tg_qq, tg_url, tg_reg_time, tg_level 
        FROM tg_user 
        WHERE tg_username='{$_COOKIE['username']}' 
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if($aResult){
        $aWebPageData = array();
        $aWebPageData['username'] = $aResult['tg_username'];
        $aWebPageData['sex'] = $aResult['tg_sex']; 
        $aWebPageData['avatar'] = $aResult['tg_avatar'];
        $aWebPageData['email'] = $aResult['tg_email'];
        $aWebPageData['qq'] = $aResult['tg_qq'];
        $aWebPageData['url'] = $aResult['tg_url'];
        $aWebPageData['regtime'] = $aResult['tg_reg_time'];
        switch($aResult['tg_level']){
            case 0:
                $aWebPageData['level'] = '普通会员'; break;
            case 1:
                $aWebPageData['level'] = '管理员'; break;
            default: 
                $aWebPageData['level'] = '权限错误';
        }
        $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
    }
    else{
        echo '此用户不存在';
    }
}
else{
    echo '非法登录';
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
    <div id="member">
        <?php 
            require 'includes/member.inc.php';
        ?>
        <div id="memberMainArea">
            <h2>会员管理中心</h2>
            <dl>
    			<dd>用 户 名：<?php echo $aWebPageData['username']?></dd>
    			<dd>性　　别：<?php echo $aWebPageData['sex']?></dd>
    			<dd>头　　像：<?php echo $aWebPageData['avatar']?></dd>
    			<dd>电子邮件：<?php echo $aWebPageData['email']?></dd>
    			<dd>主　　页：<?php echo $aWebPageData['url']?></dd>
    			<dd>Q 　 　Q：<?php echo $aWebPageData['qq']?></dd>
    			<dd>注册时间：<?php echo $aWebPageData['regtime']?></dd>
    			<dd>身　　份：<?php echo $aWebPageData['level']?></dd>
    		</dl>
        </div>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>