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
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'login');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//登录状态判定
funcLoginState();
global $aSystem;
//开始处理登录状态
if($_GET['action'] == 'login'){
    //为了防止恶意注册，跨站攻击
    if(!empty($aSystem['captcha'])){
        funcVerifyCaptcha($_POST['captcha'], $_SESSION['captcha']);
    }
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLogin.func.php';
    //创建一个空数组，用来存放提交过来的登录数据；
    $aClean = array();
    //开始验证
    $aClean['username'] = funcVerifyUsername($_POST['username'], 2, 20);
    $aClean['password'] = funcVerifyPassword($_POST['password'], 6, 32);
    $aClean['keeptime'] = funcVerifyKeeptime($_POST['keeptime']);
    //到数据库去验证
    $sSqlStatements = "
        SELECT tg_username, tg_uniqid, tg_level
        FROM tg_user 
        WHERE 
            tg_username='{$aClean['username']}' AND tg_password='{$aClean['password']}' AND tg_active='' 
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        //登录成功后，记录登录信息
        $sSqlStatements = "
            UPDATE tg_user 
            SET
                tg_last_login_time=NOW(),
                tg_last_login_ip='{$_SERVER["REMOTE_ADDR"]}',
                tg_login_count=tg_login_count+1
            WHERE
                tg_username='{$aResult['tg_username']}'";
        funcSqlQuery($sSqlStatements);
        //funcSessionDestroy();
        //生成cookie
        funcSetCookies($aResult['tg_username'], $aResult['tg_uniqid'], $aClean['keeptime']);
        if($aResult['tg_level'] == 1){
            $_SESSION['admin'] = $aResult['tg_username'];
        }
        funcCloseMysql();
        funcAlertJump(null, 'member.php');
    }
    else{
        funcCloseMysql();
        //funcSessionDestroy();//为了管理员的登录需要产生session
        funcAlertJump('用户名密码不正确或者该账户未被激活！','login.php');
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
<script type="text/javascript" src="js/captcha.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id='login'>
        <h2>登录</h2>
        <form method="post" name="login" action="login.php?action=login">
            <dl>
                <dt>　</dt>
                <dd>用 户 名：<input type="text" name="username" class="text"/></dd>
                <dd>密　　码：<input type="password" name="password" class="text"/></dd>
                <dd>保　　留：<input type="radio" name="keeptime" value="0" checked="checked"/>不保留
                    <input type="radio" name="keeptime" value="1"/>一天
                    <input type="radio" name="keeptime" value="2"/>一周
                    <input type="radio" name="keeptime" value="3"/>一月
                </dd>
                <?php if(!empty($aSystem['captcha'])){?>
                <dd>验 证 码：<input type="text" name="captcha" class="text captcha" />
                    <img src="captcha.php" id="captcha" />
                </dd>
                <?php }?>
                <dd><input type="submit" value="登录" class="button"/>
                    <input type="button" value="注册" id="jumptoreg" class="button jumptoreg"/>
                </dd>
            </dl>
         </form>
    </div>

    
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>