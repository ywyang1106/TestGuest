<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月6日
*/
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'article');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//处理精华帖
if($_GET['action'] == 'nice' && isset($_GET['id']) && isset($_GET['on'])){
    $sSqlStatements = "
        SELECT tg_uniqid
        FROM tg_user
        WHERE tg_username='{$_COOKIE['username']}'
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        //引入验证函数文件
        include ROOT_PATH.'includes/verifyLegal.func.php';
        funcVerifyUniqid($aResult['tg_uniqid'],$_COOKIE['uniqid']);
		//设置精华帖，或者取消精华帖
		$sSqlStatements = "
		      UPDATE tg_article
		      SET tg_nice='{$_GET['on']}' 
		      WHERE tg_id='{$_GET['id']}'";
        funcSqlQuery($sSqlStatements);
        if(funcAffectRows() == 1){
            funcCloseMysql();
            funcAlertJump('精华帖操作成功！','article.php?id='.$_GET['id']);
        }
        else{
            funcCloseMysql();
            funcAlertReturn('精华帖设置失败！');
        }
    }
    else{
		funcAlertReturn('非法登录！');
	}
}
//处理回帖
if($_GET['action'] == 'rearticle'){
    if(!empty($aSystem['captcha'])){
    //为了防止恶意注册，跨站攻击
    funcVerifyCaptcha($_POST['captcha'], $_SESSION['captcha']);
    }
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    $sSqlStatements = "
        SELECT tg_uniqid, tg_reply_time
        FROM tg_user
        WHERE tg_username='{$_COOKIE['username']}'
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){//判定数据库是否有选择的数据，若有再进行数据更改
        //为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        funcVerifyUniqid($aResult['tg_uniqid'], $_COOKIE['uniqid']);
        //验证是否在规定的时间外发帖,1种为采用cookies，第二张采用数据库
        global $aSystem;
        funcExpiredTime(time(), $aResult['tg_reply_time'], $aSystem['re']);
        $aClean['time'] = time();
        $sSqlStatements = "
            UPDATE tg_user
            SET tg_reply_time='{$aClean['time']}'
            WHERE tg_username='{$_COOKIE['username']}'";
            funcSqlQuery($sSqlStatements);
        //接受回帖内容
        $aClean = array();
        $aClean['reid'] = $_POST['reid'];
		$aClean['type'] = $_POST['type'];
		$aClean['title'] = $_POST['title'];
		$aClean['content'] = $_POST['content'];
		$aClean['username'] = $_COOKIE['username'];
		$aClean = funcMysqlString($aClean);
        //写入数据库
		$sSqlStatements = "
		    INSERT INTO tg_article
		      (tg_reid, tg_username, tg_title, tg_type, tg_content, tg_time)
		    VALUES 
		      ('{$aClean['reid']}', '{$aClean['username']}', '{$aClean['title']}', '{$aClean['type']}', '{$aClean['content']}', NOW())";
        funcSqlQuery($sSqlStatements);
		if(funcAffectRows() == 1){
		    //setcookie('article_time', time());
		    $sSqlStatements = "
		        UPDATE tg_article 
		        SET tg_commentcount=tg_commentcount+1 
		        WHERE tg_reid=0 AND tg_id='{$aClean['reid']}'";
		    funcSqlQuery($sSqlStatements);
    		funcCloseMysql();
    		//funcSessionDestroy();
    		funcAlertJump('回帖成功！','article.php?id='.$aClean['reid']);
        } 
        else{
            funcCloseMysql();
			//funcSessionDestroy();
            funcAlertReturn('回帖失败！');
        }
    }
    else{
        funcAlertReturn('非法登录');
    }
}
//读出数据
if(isset($_GET['id'])){
    $sSqlStatements = "
        SELECT tg_id, tg_username, tg_title, tg_type,
            tg_content, tg_readcount, tg_commentcount, tg_last_modify_time, tg_nice, tg_time
        FROM tg_article
        WHERE tg_reid=0
        AND tg_id='{$_GET['id']}'";
    $aResult3 = funcFetchArray($sSqlStatements);
    if(!!$aResult3){//判定数据库是否有选择的数据，若有再进行数据更改
        //累计阅读量
        $sSqlStatements = "
            UPDATE tg_article 
            SET tg_readcount=tg_readcount+1 
            WHERE tg_id='{$_GET['id']}'";
        funcSqlQuery($sSqlStatements);
        $aWebPageData = array();
        $aWebPageData['reid'] = $aResult3['tg_id'];
        $aWebPageData['username_subject'] = $aResult3['tg_username'];
        $aWebPageData['title'] = $aResult3['tg_title'];
        $aWebPageData['type'] = $aResult3['tg_type'];
        $aWebPageData['content'] = $aResult3['tg_content'];
        $aWebPageData['readcount'] = $aResult3['tg_readcount'];
        $aWebPageData['last_modify_time'] = $aResult3['tg_last_modify_time'];
        $aWebPageData['commentcount'] = $aResult3['tg_commentcount'];
        $aWebPageData['nice'] = $aResult3['tg_nice'];
        $aWebPageData['time'] = $aResult3['tg_time'];
        //拿出用户名，去查找用户信息
        $sSqlStatements = "
            SELECT tg_id, tg_sex, tg_avatar, tg_email, tg_url, tg_switch, tg_autograph
            FROM tg_user
            WHERE tg_username='{$aWebPageData['username_subject']}'";
        $aResult5 = funcFetchArray($sSqlStatements);
        if(!!$aResult5){
            //提取用户信息
            $aWebPageData['userid'] = $aResult5['tg_id'];
            $aWebPageData['sex'] = $aResult5['tg_sex'];
            $aWebPageData['avatar'] = $aResult5['tg_avatar'];
            $aWebPageData['email'] = $aResult5['tg_email'];
            $aWebPageData['url'] = $aResult5['tg_url'];
            $aWebPageData['switch'] = $aResult5['tg_switch'];
            $aWebPageData['autograph'] = $aResult5['tg_autograph'];
            $aWebPageData = funcConvertHtml($aWebPageData);
            //创建全局变量，做一个带参数的分页
            global $iGlobalId;
            $iGlobalId = 'id='.$aWebPageData['reid'].'&';
            //主题帖子修改
            if($aWebPageData['username_subject'] == $_COOKIE['username'] || isset($_SESSION['admin'])){
                $aWebPageData[subjectModify] = '[<a href="articleModify.php?id='.$aWebPageData['reid'].'">修改</a>]';
            }
            //读取最后修改信息
            if ($aWebPageData['last_modify_time'] != '0000-00-00 00:00:00') {
                $aWebPageData['last_modify_time_string'] = '本贴已由['.$aWebPageData['username_subject'].']于'.$aWebPageData['last_modify_time'].'修改过！';
            }
            //给楼主回复
            if ($_COOKIE['username']) {
                $aWebPageData['reply'] = '<span>[<a href="#re" name="reply" title="回复1楼的'.$aWebPageData['username_subject'].'">回复</a>]</span>';
            }
            //个性签名
            if ($aWebPageData['switch'] == 1) {
                $aWebPageData['autograph_html'] = '<p class="autograph">'.funcConvertUbb($aWebPageData['autograph']).'</p>';
            }
            //读取回帖
            global $iPageNum, $iPageSize, $iPage;
            $sSqlStatements = "
                SELECT tg_id
                FROM tg_article
                WHERE tg_reid='{$aWebPageData['reid']}'";
            funcPagingParameters($sSqlStatements, 5);
            $sSqlStatements = "
                SELECT tg_username, tg_type, tg_title, tg_content, tg_time
                FROM tg_article
                WHERE tg_reid='{$aWebPageData['reid']}'
                ORDER BY tg_time ASC
                LIMIT $iPageNum, $iPageSize";
            $rResult7 = funcSqlQuery($sSqlStatements);
        } 
        else{
            //这个用户已被删除
        }
    }
    else{
        funcAlertReturn('不存在这个主题！');
    }
} 
else{
    funcAlertReturn('非法操作！');
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
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="article">
        <h2>帖子详情</h2>
        <?php 
            if(!empty($aWebPageData['nice'])){
        ?>
        <img src="images/nice.gif" alt="精华贴" class="nice" />
        <?php 
            }
            //浏览量达到400，并且评论量达到20即可为热帖
            if ($aWebPageData['readcount'] >= 100 && $aWebPageData['commentcount'] >= 10){     
        ?>
            <img src="images/hot.gif" alt="热贴" class="hot" />
        <?php }?>
        <?php 
            if($iPage == 1){//如果iPage等于1，则显示主体段       
        ?>
        <div id="subject">
            <dl>
    			<dd class="user"><?php echo $aWebPageData['username_subject']?>(<?php echo $aWebPageData['sex']?>)[楼主]</dd>
    			<dt><img src="<?php echo $aWebPageData['avatar']?>" alt="<?php echo $aWebPageData['username_subject']?>" /></dt>
    			<dd class="sendMessage"><a href="javascript:;" name="sendMessage" title="<?php echo $aWebPageData['userid']?>">发消息</a></dd>
    			<dd class="addFriend"><a href="javascript:;" name="addFriend" title="<?php echo $aWebPageData['userid']?>">加为好友</a></dd>
    			<dd class="leaveMessage">写留言</dd>
    			<dd class="sendFlower"><a href="javascript:;" name="sendFlower" title="<?php echo $aWebPageData['userid']?>">给他送花</a></dd>
    			<dd class="email">邮件：<a href="mailto:<?php echo $aWebPageData['email']?>"><?php echo $aWebPageData['email']?></a></dd>
    			<dd class="url">网址：<a href="<?php echo $aWebPageData['url']?>" target="_blank"><?php echo $aWebPageData['url']?></a></dd>
    		</dl>
            <div class="content">
                <div class="user">
    				<span>
    				<?php if(empty($aWebPageData['nice'])){?>
    				    [<a href="article.php?action=nice&on=1&id=<?php echo $aWebPageData['reid']?>">设置精华</a>]
    				<?php }else{ ?>
    				    [<a href="article.php?action=nice&on=0&id=<?php echo $aWebPageData['reid']?>">取消精华</a>]
    				<?php }?>
    				    <?php echo $aWebPageData[subjectModify]?> 1#</span><?php echo $aWebPageData['username_subject']?> | 发表于：<?php echo $aWebPageData['time']?>
    			</div>
    			<h3>主题：<?php echo $aWebPageData['title']?> <img src="images/icon<?php echo $aWebPageData['type']?>.gif" alt="icon" />
    			<?php echo $aWebPageData['reply']?>
    			</h3>
    			<div class="detail">
    				<?php echo funcConvertUbb($aWebPageData['content'])?>
    				<p class="autograph"><?php echo $aWebPageData['autograph_html']?></p>
    			</div>
    			<div class="read">
    			    <p><?php echo $aWebPageData['last_modify_time_string']?></p>
    				阅读量：(<?php echo $aWebPageData['readcount']?>) 评论量：(<?php echo $aWebPageData['commentcount']?>)
    			</div>
            </div>
        </div>
        <?php }?>
        <p class="line"></p>
        <?php 
            $iFloorNum = 2;
            while(!!$aResult = funcFetchArrayList($rResult7)){
                $aWebPageData['username'] = $aResult['tg_username'];
                $aWebPageData['type'] = $aResult['tg_type'];
                $aWebPageData['content'] = $aResult['tg_content'];
                $aWebPageData['time'] = $aResult['tg_time'];
                $aWebPageData['reTitle'] = $aResult['tg_title'];
                $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
                //拿出用户名，去查找用户信息
                $sSqlStatements = "
                    SELECT tg_id, tg_sex, tg_avatar, tg_email, tg_url, tg_username, tg_switch, tg_autograph
                    FROM tg_user
                    WHERE tg_username='{$aWebPageData['username']}'";
                $aResult5 = funcFetchArray($sSqlStatements);
                if(!!$aResult5){
                    //提取用户信息
                    $aWebPageData['userid'] = $aResult5['tg_id'];
                    $aWebPageData['sex'] = $aResult5['tg_sex'];
                    $aWebPageData['avatar'] = $aResult5['tg_avatar'];
                    $aWebPageData['email'] = $aResult5['tg_email'];
                    $aWebPageData['url'] = $aResult5['tg_url'];
                    $aWebPageData['switch'] = $aResult5['tg_switch'];
                    $aWebPageData['autograph'] = $aResult5['tg_autograph'];
                    $aWebPageData = funcConvertHtml($aWebPageData);
                    if( $iFloorNum ==2 && $iPage == 1){
                        if($aWebPageData['username'] != $aWebPageData['username_subject']){
                            $aWebPageData['sofas'] = '[沙发]';   
                        }
                        else{
                            $aWebPageData['sofas'] = '[楼主]';
                        }  
                    }
                    else{
                        $aWebPageData['sofas'] = '';
                    }
                }
                else{
                    //这个用户可能已经被删除了
                }
                //跟帖回复
                if($_COOKIE['username']){
                    $aWebPageData['reply'] = '<span>[<a href="#re" name="reply" title="回复'.($iFloorNum + (($iPage - 1) * $iPageSize)).'楼的'.$aWebPageData['username'].'">回复</a>]</span>';      
                }
        ?>
        <div class="re">
            <dl>
    			<dd class="user"><?php echo $aWebPageData['username']?>(<?php echo $aWebPageData['sex']?>)<?php echo $aWebPageData['sofas']?></dd>
    			<dt><img src="<?php echo $aWebPageData['avatar']?>" alt="<?php echo $aWebPageData['username']?>" /></dt>
    			<dd class="sendMessage"><a href="javascript:;" name="sendMessage" title="<?php echo $aWebPageData['userid']?>">发消息</a></dd>
    			<dd class="addFriend"><a href="javascript:;" name="addFriend" title="<?php echo $aWebPageData['userid']?>">加为好友</a></dd>
    			<dd class="leaveMessage">写留言</dd>
    			<dd class="sendFlower"><a href="javascript:;" name="sendFlower" title="<?php echo $aWebPageData['userid']?>">给他送花</a></dd>
    			<dd class="email">邮件：<a href="mailto:<?php echo $aWebPageData['email']?>"><?php echo $aWebPageData['email']?></a></dd>
    			<dd class="url">网址：<a href="<?php echo $aWebPageData['url']?>" target="_blank"><?php echo $aWebPageData['url']?></a></dd>
    		</dl>
            <div class="content">
                <div class="user">
    				<span><?php echo $iFloorNum + (($iPage - 1) * $iPageSize)?>#</span><?php echo $aWebPageData['username']?> | 发表于：<?php echo $aWebPageData['time']?>
    			</div>
    			<h3>主题：<?php echo $aWebPageData['reTitle']?> 
    			     <img src="images/icon<?php echo $aWebPageData['type']?>.gif" alt="icon" />
    			     <?php echo $aWebPageData['reply']?>
    			</h3>
    			<div class="detail">
                    <?php echo funcConvertUbb($aWebPageData['content'])?>
                    
                   <?php 
                   //个性签名
                   if ($aWebPageData['switch'] == 1) {
                      echo '<p class="autograph">'.funcConvertUbb($aWebPageData['autograph']).'</p>';
                   }
                   ?>
    			</div>
            </div>
        </div>
        <p class="line"></p>
        <?php $iFloorNum++;}?>
        <?php
            funcFreeMysqlResult($rResult7);
            //分页调用函数；默认为false，调用数字分页；若为true，则调用文本分页
            funcPaging(true);
        ?>
        <?php if(isset($_COOKIE['username'])){?>
        <a name="re"></a>
        <form method="post" action="?action=rearticle">
            <input type="hidden" name="reid" value="<?php echo $aWebPageData['reid']?>" />
            <input type="hidden" name="type" value="<?php echo $aWebPageData['type']?>" />
            <dl>
                <dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $aWebPageData['title']?>"/>(*必填，2-40位)</dd>
                <dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　
                    <a href="javascript:;">Q图系列[2]</a>　
                    <a href="javascript:;">Q图系列[3]</a>
                </dd>
                <dd>
                    <?php include ROOT_PATH.'includes/ubb.inc.php'?>
                    <textarea name="content" rows="9"></textarea>
                </dd>
                
                <dd>
                <?php if(!empty($aSystem['captcha'])){?>           
                                                             验 证 码：
                    <input type="text" name="captcha" class="text captcha" />
                    <img src="captcha.php" id="captcha" />
                    <?php }?>
                    <input type="submit" class="submit" value="发表帖子" />
                </dd>
                
            </dl>
        </form>
        <?php }?>
        </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>