<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月3日
*/
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'addFriend');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//判断是否登录
if(!isset($_COOKIE['username'])){
    funcAlertClose('请先登录');
}
//添加好友信息
if($_GET['action'] == 'add'){
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
        //创建一个空数组，用来存放提交过来的数据；
        $aClean = array();
        $aClean['toUser'] = $_POST['toUser'];
        $aClean['fromUser'] = $_COOKIE['username'];
        $aClean['content'] = funcVerifyContent($_POST['content']);
        $aClean = funcMysqlString($aClean);
        //不能添加自己
        if ($aClean['toUser'] == $aClean['fromUser']) {
            funcAlertClose('请不要添加自己！');
        }
        //数据库验证好友是否已经添加
        $sSqlStatements = "
            SELECT tg_id
            FROM tg_friend
            WHERE (tg_toUser='{$aClean['toUser']}' AND tg_fromUser='{$aClean['fromUser']}')
            OR (tg_toUser='{$aClean['fromUser']}' AND tg_fromUser='{$aClean['toUser']}')
            LIMIT 1";
        $aResult2 = funcFetchArray($sSqlStatements);
        if(!!$aResult2){//判定数据库是否有选择的数据，若有再进行数据更改
            funcAlertClose('你们已经是好友了！或者是未验证的好友！无需添加！');
        }
        else{//添加好友信息
            $sSqlStatements = "
                INSERT INTO tg_friend
                    (tg_toUser, tg_fromUser, tg_content, tg_time)
                VALUES
                    ('{$aClean['toUser']}', '{$aClean['fromUser']}', '{$aClean['content']}', NOW())";
            funcSqlQuery($sSqlStatements);
            //新增成功
            if(funcAffectRows() == 1){
                funcCloseMysql();
                //funcSessionDestroy();
                funcAlertClose('好友添加消息发送成功！请等待验证！');
            }
            else{
                funcCloseMysql();
                //funcSessionDestroy();
                funcAlertReturn('好友添加失败！');
            }   
        }
    }
}
//获取数据
if(isset($_GET['id'])){
    //从数据库获取数据
    $sSqlStatements = "
        SELECT tg_username 
        FROM tg_user 
        WHERE tg_id='{$_GET['id']}' 
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        $aWebPageData = array();
        $aWebPageData['toUser'] = $aResult['tg_username'];
        $aWebPageData = funcConvertHtml($aWebPageData);
    }
    else{
        funcAlertReturn('不存在此用户');
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
<script type="text/javascript" src="js/addFriend.js"></script>
</head>
<body>
    <div id="sendMessage">
        <h3>添加好友</h3>
        <form method="post" action="?action=add">
        <input type="hidden" name="toUser" value="<?php echo $aWebPageData['toUser']?>" />
            <dl>
                <dd><input type="text" readonly="readonly" value="To:<?php echo $aWebPageData['toUser']?>"class="text" /></dd>
                <dd><textarea name="content">我非常想和你交个朋友！</textarea></dd>
                <dd>验 证 码：<input type="text" name="captcha" class="text captcha" />
                    <img src="captcha.php" id="captcha" />
                    <input type="submit" class="submit" value="添加好友" />
                </dd>
            </dl>
        </form>
    </div>
</body>
</html>