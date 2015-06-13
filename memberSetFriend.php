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
define('THISPAGENAME', 'memberSetFriend');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//判断是否登录
if(!isset($_COOKIE['username'])){
    funcAlertReturn('请先登录');
}
//验证好友
if($_GET['action'] == 'verify' && isset($_GET['id'])){
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    //危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
    $sSqlStatements = "
        SELECT tg_uniqid
        FROM tg_user
        WHERE tg_username='{$_COOKIE['username']}'
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        funcVerifyUniqid($aResult['tg_uniqid'],$_COOKIE['uniqid']);
        //修改表里的state，从而通过验证
        $sSqlStatements = "
            UPDATE tg_friend
            SET tg_state=1
            WHERE tg_id='{$_GET['id']}'";
        funcSqlQuery($sSqlStatements);
        if(funcAffectRows() == 1){
            funcCloseMysql();
            funcAlertJump('好友验证成功','memberSetFriend.php');
        }
        else{
            funcCloseMysql();
            funcAlertReturn('好友验证失败');
        }
    }
    else{
        funcAlertReturn('非法登录');
    }
}
//批量删除好友
if($_GET['action'] == 'delete' && isset($_POST['operate'])){
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    $aClean = array();
	$aClean['operate'] = funcMysqlString(implode(',', $_POST['operate']));
	//危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
	$sSqlStatements = "
    	SELECT tg_uniqid
    	FROM tg_user
    	WHERE tg_username='{$_COOKIE['username']}'
    	LIMIT 1";
	$aResult = funcFetchArray($sSqlStatements);
	if(!!$aResult){
	    funcVerifyUniqid($aResult['tg_uniqid'],$_COOKIE['uniqid']);
	    //批量删除信息
	    $sSqlStatements = "
	        DELETE 
	        FROM tg_friend
            WHERE tg_id 
	        IN ({$aClean['operate']})";
	    funcSqlQuery($sSqlStatements);
	    if(funcAffectRows()){
    	    funcCloseMysql();
    	    funcAlertJump('好友删除成功','memberSetFriend.php');
	    }
	    else{
    	    funcCloseMysql();
    	    funcAlertReturn('好友删除失败');
	    }
	}
	else{
	    funcAlertReturn('非法登录');
	}
}
//分页模块
global $iPageNum, $iPageSize;
$sSqlStatements1 = "
    SELECT tg_id 
    FROM tg_friend 
    WHERE tg_toUser='{$_COOKIE['username']}'
    OR tg_fromUser='{$_COOKIE['username']}'";
funcPagingParameters($sSqlStatements1, 15);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据
$sSqlStatements = "
    SELECT tg_id, tg_state, tg_toUser, tg_fromUser, tg_content, tg_time
    FROM tg_friend
    WHERE tg_toUser='{$_COOKIE['username']}'
    OR tg_fromUser='{$_COOKIE['username']}'
    ORDER BY tg_time DESC
    LIMIT $iPageNum, $iPageSize";
$rResult = funcSqlQuery($sSqlStatements);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/memberCheckMessage.js"></script>
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
            <h2>好友设置中心</h2>
            <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr>
                    <th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th>
                </tr>
                <?php 
                    $aWebPageData = array();
                    while(!!$aResult = funcFetchArrayList($rResult)){
                        $aWebPageData['id'] = $aResult['tg_id'];
                        $aWebPageData['fromUser'] = $aResult['tg_fromUser'];
                        $aWebPageData['toUser'] = $aResult['tg_toUser'];
                        $aWebPageData['content'] = $aResult['tg_content'];
                        $aWebPageData['state'] = $aResult['tg_state'];
                        $aWebPageData['time'] = $aResult['tg_time'];
                        $aWebPageData = funcConvertHtml($aWebPageData);
                        if($aWebPageData['toUser'] == $_COOKIE['username']){
                            $aWebPageData['friend'] = $aWebPageData['fromUser'];
                            if(empty($aWebPageData['state'])){
                                $aWebPageData['relationState'] = '<a href="?action=verify&id='.$aWebPageData['id'].'" style="color:red;">你未验证</a>';
                            }
                            else{
                                $aWebPageData['relationState'] = '<span style="color:green;">你通过</span>';
                            }
                        }
                        elseif($aWebPageData['fromUser'] == $_COOKIE['username']){
                            $aWebPageData['friend'] = $aWebPageData['toUser'];
                            if(empty($aWebPageData['state'])){
                                $aWebPageData['relationState'] = '<span style="color:blue;">对方未验证</span>';
                            }
                            else{
                                $aWebPageData['relationState'] = '<span style="color:green;">对方通过</span>';
                            }
                        }    
                ?>
                <tr>
                    <td><?php echo $aWebPageData['friend']?></td>
                    <td title="<?php echo $aWebPageData['content']?>"><?php echo funcSummary($aWebPageData['content'])?></td>
                    <td><?php echo $aWebPageData['time']?></td>
                    <td><?php echo $aWebPageData['relationState']?></td>
                    <td><input name="operate[]" value="<?php echo $aWebPageData['id']?>" type="checkbox" /></td>
                </tr>
                <?php }?>
                <?php 
                    funcFreeMysqlResult($rResult);
                ?>
                <tr>
                    <td colspan="5">
                        <label for="selectAll">全选 <input type="checkbox" name="selectAll" id="selectAll" /></label> 
                        <input type="submit" value="批量删除" />
                    </td>
                </tr>
            </table>
            </form>
            <?php 
                //分页调用函数；默认为false，调用数字分页；若为true，则调用文本分页
                funcPaging(true);
            ?>
        </div>
     </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>