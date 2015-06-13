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
define('THISPAGENAME', 'blogFriend');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//分页模块
global $iPageNum, $iPageSize, $aSystem;
$sSqlStatements = "SELECT tg_id FROM tg_user";
funcPagingParameters($sSqlStatements, $aSystem['blog']);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据
$sSqlStatements = "
    SELECT tg_id, tg_username, tg_sex, tg_avatar 
    FROM tg_user 
    ORDER BY tg_reg_time DESC 
    LIMIT $iPageNum, $iPageSize";
$rResult = funcSqlQuery($sSqlStatements);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/blogFriend.js"></script>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="blogFriend">
        <h2>博友列表</h2>
        <?php 
        $aWebPageData = array();
            while(!!$aResult = funcFetchArrayList($rResult)){
                $aWebPageData['id'] = $aResult['tg_id'];
                $aWebPageData['username'] = $aResult['tg_username'];
                $aWebPageData['sex'] = $aResult['tg_sex'];
                $aWebPageData['avatar'] = $aResult['tg_avatar'];
                $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
        ?>
        <dl>
            <dd class="friend"><?php echo $aWebPageData['username']?>(<?php echo $aWebPageData['sex']?>)</dd>
            <dt><img src="<?php echo $aWebPageData['avatar']?>" alt="炎日" /></dt>
            <dd class="sendMessage"><a href="javascript:;" name="sendMessage" title="<?php echo $aWebPageData['id']?>">发信息</a></dd>
            <dd class="addFriend"><a href="javascript:;" name="addFriend" title="<?php echo $aWebPageData['id']?>">加为好友</a></dd>
            <dd class="leaveMessage"><a href="javascript:;" name="leaveMessage" title="<?php echo $aWebPageData['id']?>">>写留言</a></dd>
            <dd class="sendFlower"><a href="javascript:;" name="sendFlower" title="<?php echo $aWebPageData['id']?>">给他送花</a></dd>
        </dl>
        <?php }?>
        <?php
            funcFreeMysqlResult($rResult);
            //分页调用函数；默认为false，调用数字分页；若为true，则调用文本分页
            funcPaging(true);
        ?>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>