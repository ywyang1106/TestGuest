<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月4日
*/
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'memberMessageDetail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//判断是否登录
if(!isset($_COOKIE['username'])){
    funcAlertReturn('请先登录');
}
//删除单条信息
if($_GET['action'] == 'delete' && isset($_GET['id'])){
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    //验证信息是否合法
    $sSqlStatements = "
        SELECT tg_id 
        FROM tg_message
        WHERE tg_id='{$_GET['id']}'
        LIMIT 1";
    $aResult1 = funcFetchArray($sSqlStatements);
    if(!!$aResult1){
        //危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        $sSqlStatements = "
            SELECT tg_uniqid
            FROM tg_user
            WHERE tg_username='{$_COOKIE['username']}'
            LIMIT 1";
        $aResult2 = funcFetchArray($sSqlStatements);
        if(!!$aResult2){
            funcVerifyUniqid($aResult2['tg_uniqid'],$_COOKIE['uniqid']);
            //删除单个信息
            $sSqlStatements = "
                DELETE 
                FROM tg_message 
                WHERE tg_id='{$_GET['id']}' 
                LIMIT 1";
            funcSqlQuery($sSqlStatements);
            if(funcAffectRows() == 1){
                funcCloseMysql();
                funcAlertJump('短信删除成功','memberCheckMessage.php');
            } 
            else{
                funcCloseMysql();
                funcAlertReturn('短信删除失败');
            }
        }
        else{
            funcAlertReturn('非法登录');
        }
    }
    else{
        funcAlertReturn('此信息不存在');
    }       
}
//读取信息内容
if(isset($_GET['id']) ){
    //从数据库获取数据
    $sSqlStatements = "
        SELECT tg_id, tg_state, tg_fromUser, tg_content, tg_time 
        FROM tg_message
        WHERE tg_id='{$_GET['id']}'
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if($aResult){
        //将state状态设置为1即可
        if(empty($aResult['tg_state'])){
            $sSqlStatements = "
                UPDATE tg_message
                SET tg_state=1
                WHERE tg_id='{$_GET['id']}'
                LIMIT 1";   
            funcSqlQuery($sSqlStatements);
            if(!funcAffectRows()){
                funcAlertReturn('异常');
            }
        }
        $aWebPageData = array();
        $aWebPageData['id'] = $aResult['tg_id'];
        $aWebPageData['fromUser'] = $aResult['tg_fromUser'];
        $aWebPageData['content'] = $aResult['tg_content'];
        $aWebPageData['time'] = $aResult['tg_time'];
        $aWebPageData = funcConvertHtml($aWebPageData);
    }
    else{
        funcAlertReturn('此信息不存在');
    }
}
else{
    funcAlertReturn('非法登录');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/memberMessageDetail.js"></script>
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
            <h2>信息详情</h2>
            <dl>
                <dd>发 信 人：<?php echo $aWebPageData['fromUser']?></dd>
			    <dd>内　　容：<strong><?php echo $aWebPageData['content']?></strong></dd>
			    <dd>发信时间：<?php echo $aWebPageData['time']?></dd>
                <dd class="button">
                    <input type="button" value="返回列表" id="returnList" /> 
                    <input type="button" value="删除信息" id= "deleteMessage" name="<?php echo $aWebPageData['id']?>"/>
                </dd>
            </dl>
        </div>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>