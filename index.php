<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年5月29日
*/
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'index');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//读取XML文件
$aWebPageData = funcConvertHtml(funcGetXml('new.xml'));
//读取帖子列表
//分页模块
global $iPageNum, $iPageSize, $aSystem;
$sSqlStatements = "SELECT tg_id FROM tg_article WHERE tg_reid=0";
funcPagingParameters($sSqlStatements, $aSystem['article']);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据
$sSqlStatements = "
    SELECT tg_id, tg_title, tg_type, tg_readcount, tg_commentcount
    FROM tg_article
    WHERE tg_reid=0
    ORDER BY tg_time 
    DESC
    LIMIT $iPageNum, $iPageSize";
$rResult = funcSqlQuery($sSqlStatements);
//最新图片,找到时间点最后上传的那张图片，并且是非公开的
$sSqlStatements = "
    SELECT tg_id AS id, tg_name AS name, tg_url AS url
	FROM tg_photo
	WHERE tg_sid in (SELECT tg_id FROM tg_dir WHERE tg_type=0)
    ORDER BY tg_date DESC
    LIMIT 1";
$aPhoto = funcFetchArray($sSqlStatements);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/blogFriend.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="list">
    	<h2>帖子列表</h2>	
    	<a href="post.php" class="post">发表帖子</a>
    	<ul class="article">
    	    <?php 
    	    $aWebArticleData = array();
    	    while(!!$aResult = funcFetchArrayList($rResult)){
    	        $aWebArticleData['id'] = $aResult['tg_id'];
    	        $aWebArticleData['type'] = $aResult['tg_type'];
    	        $aWebArticleData['readcount'] = $aResult['tg_readcount'];
    	        $aWebArticleData['commentcount'] = $aResult['tg_commentcount'];
    	        $aWebArticleData['title'] = $aResult['tg_title'];
    	        $aWebArticleData = funcConvertHtml($aWebArticleData);
    	        echo '<li class="icon'.$aWebArticleData['type'].'"><em>阅读数(<strong>'.$aWebArticleData['readcount'].'</strong>) 评论数(<strong>'.$aWebArticleData['commentcount'].'</strong>)</em> <a href="article.php?id='.$aWebArticleData['id'].'">'.funcSummary($aWebArticleData['title'],20).'</a></li>';
    	    }
    	    funcFreeMysqlResult($rResult);
            ?>
    	</ul>
    	<?php funcPaging(true);?>
    </div> 
    <div id="user">
    	<h2>新进会员</h2>
    	<dl>
            <dd class="friend"><?php echo $aWebPageData['username']?>(<?php echo $aWebPageData['sex']?>)</dd>
            <dt><img src="<?php echo $aWebPageData['avatar']?>" alt="<?php echo $aWebPageData['username']?>" /></dt>
            <dd class="sendMessage"><a href="javascript:;" name="sendMessage" title="<?php echo $aWebPageData['id']?>">发信息</a></dd>
            <dd class="addFriend"><a href="javascript:;" name="addFriend" title="<?php echo $aWebPageData['id']?>">加为好友</a></dd>
            <dd class="leaveMessage">写留言</dd>
            <dd class="sendFlower"><a href="javascript:;" name="sendFlower" title="<?php echo $aWebPageData['id']?>">给他送花</a></dd>
            <dd class="email">邮件：<a href="mailto:<?php echo $aWebPageData['email']?>"><?php echo $aWebPageData['email']?></a></dd>
            <dd class="url">网址：<a href="<?php echo $aWebPageData['url']?>" target="_blank"><?php echo $aWebPageData['url']?></a></dd>
        </dl>	
    </div> 
    <div id="pics">
    	<h2>最新图片--<?php echo $aPhoto['name']?></h2>	
    	<a href="photoDetail.php?id=<?php echo $aPhoto['id']?>" >
    	<img src="thumb.php?filename=<?php echo $aPhoto['url']?>&percent=0.4" alt="<?php echo $aPhoto['name']?>" />
    	</a>
    </div> 
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>