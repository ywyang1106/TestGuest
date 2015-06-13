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
define('THISPAGENAME', 'memberCheckFlower');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//判断是否登录
if(!isset($_COOKIE['username'])){
    funcAlertReturn('请先登录');
}
//批量删除花朵
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
	        FROM tg_flower 
            WHERE tg_id 
	        IN ({$aClean['operate']})";
	    funcSqlQuery($sSqlStatements);
	    if(funcAffectRows()){
    	    funcCloseMysql();
    	    funcAlertJump('花朵删除成功','memberCheckFlower.php');
	    }
	    else{
    	    funcCloseMysql();
    	    funcAlertReturn('花朵删除失败');
	    }
	}
	else{
	    funcAlertReturn('非法登录');
	}
}
//分页模块
global $iPageNum, $iPageSize;
$sSqlStatements = "SELECT tg_id FROM tg_flower WHERE tg_toUser='{$_COOKIE['username']}'";
funcPagingParameters($sSqlStatements, 15);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据
$sSqlStatements = "
    SELECT tg_id, tg_fromUser, tg_count, tg_content, tg_time
    FROM tg_flower
    WHERE tg_toUser='{$_COOKIE['username']}'
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
            <h2>花朵管理中心</h2>
            <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr>
                    <th>送花人</th><th>花朵数目</th><th>感言</th><th>时间</th><th>操作</th>
                </tr>
                <?php 
                $aWebPageData = array();
                    while(!!$aResult = funcFetchArrayList($rResult)){
                        $aWebPageData['id'] = $aResult['tg_id'];
                        $aWebPageData['fromUser'] = $aResult['tg_fromUser'];
                        $aWebPageData['count'] = $aResult['tg_count'];
                        $aWebPageData['content'] = $aResult['tg_content'];
                        $aWebPageData['time'] = $aResult['tg_time'];
                        $aWebPageData = funcConvertHtml($aWebPageData);  
                        $aWebPageData['totalCount'] +=  $aWebPageData['count'];
                ?>
                <tr>
                    <td><?php echo $aWebPageData['fromUser']?></td>
                    <td><img src="images/x4.gif" alt="花朵"/>×<?php echo $aWebPageData['count']?>朵</td>
                    <td><?php echo funcSummary($aWebPageData['content'])?></td>     
                    <td><?php echo $aWebPageData['time']?></td>
                    <td><input name="operate[]" value="<?php echo $aWebPageData['id']?>" type="checkbox" /></td>
                </tr>
                <?php }?>
                <?php 
                    funcFreeMysqlResult($rResult);
                ?>
                <tr>
                    <td colspan="5">共<strong><?php echo $aWebPageData['totalCount']?></strong>朵花</td>
                </tr>
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