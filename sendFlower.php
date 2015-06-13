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
define('THISPAGENAME', 'sendFlower');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//判断是否登录
if(!isset($_COOKIE['username'])){
    funcAlertClose('请先登录');
}
//送花 
if($_GET['action'] == 'send'){
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
        $aClean['count'] = $_POST['sendFlower'];
        $aClean['content'] = funcVerifyContent($_POST['content']);
        $aClean = funcMysqlString($aClean);
        //写入数据库
        $sSqlStatements = "
            INSERT INTO tg_flower
                (tg_toUser, tg_fromUser, tg_count, tg_content, tg_time)
            VALUES
                ('{$aClean['toUser']}', '{$aClean['fromUser']}', '{$aClean['count']}',
                '{$aClean['content']}', NOW())";
        funcSqlQuery($sSqlStatements);
        //新增成功
        if(funcAffectRows() == 1){
            funcCloseMysql();
            //funcSessionDestroy();
            funcAlertClose('送花成功');
        } 
        else{
            funcCloseMysql();
            //funcSessionDestroy();
            funcAlertReturn('送花失败');
        }
        exit();
    }
    else{
        funcAlertClose('非法登录');
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
<script type="text/javascript" src="js/sendMessage.js"></script>
</head>
<body>
    <div id="sendMessage">
        <h3>送花</h3>
        <form method="post" action="?action=send">
            <input type="hidden" name="toUser" value="<?php echo $aWebPageData['toUser']?>" />
            <dl>
                <dd>
                    <input type="text" readonly="readonly" value="To:<?php echo $aWebPageData['toUser']?>"class="text" />
                    <select name="sendFlower">
                        <?php 
                            foreach(range(1,100) as $iNumber){
                                echo '<option value="'.$iNumber.'">×'.$iNumber.'朵</option>';
                            }
                        ?>  
                    </select>
                </dd>
                <dd><textarea name="content">非常欣赏你，送你花啦~~~</textarea></dd>
                <dd>验 证 码：<input type="text" name="captcha" class="text captcha" />
                    <img src="captcha.php" id="captcha" /><input type="submit" class="submit" value="送花" />
                </dd>
            </dl>
        </form>
    </div>
</body>
</html>