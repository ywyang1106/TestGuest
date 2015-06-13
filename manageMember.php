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
define('THISPAGENAME', 'manageMember');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//必须是管理员才能登录
funcManageLogin();
global $iPageNum, $iPageSize;
$sSqlStatements = "SELECT tg_id FROM tg_user";
funcPagingParameters($sSqlStatements, 15);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据
$sSqlStatements = "
    SELECT tg_id, tg_username, tg_email, tg_reg_time
    FROM tg_user
    ORDER BY tg_reg_time
    DESC
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
    <div id="manage">
        <?php 
            require 'includes/manage.inc.php';
        ?>
        <div id="manageMainArea">
            <h2>会员管理中心</h2>
            <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr><th>ID号</th><th>会员名</th><th>邮箱</th><th>注册时间</th><th>操作</th></tr> 
                <?php 
                $aWebPageData = array();
                    while(!!$aResult = funcFetchArrayList($rResult)){
                        $aWebPageData['id'] = $aResult['tg_id'];
                        $aWebPageData['username'] = $aResult['tg_username'];
                        $aWebPageData['email'] = $aResult['tg_email'];
                        $aWebPageData['regtime'] = $aResult['tg_reg_time'];
                        $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
                ?>
                <tr>
                    <td><?php echo $aWebPageData['id']?></td>
                    <td><?php echo $aWebPageData['username']?></td>
                    <td><?php echo $aWebPageData['email']?></td>
                    <td><?php echo $aWebPageData['regtime']?></td>
                    <td>[<a href="?action=del&<?php echo $aWebPageData['id']?>">删</a>][<a>修</a>]</td>
                </tr>
                <?php }?>
            </table>
            </form>
            <?php 
                funcFreeMysqlResult($rResult);
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