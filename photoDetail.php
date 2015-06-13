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
define('THISPAGENAME', 'photoDetail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//评论
if($_GET['action'] == 'rephoto'){
    //为了防止恶意注册，跨站攻击
    funcVerifyCaptcha($_POST['captcha'], $_SESSION['captcha']);
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
        //接受回帖内容
        $aClean = array();
        $aClean['sid'] = $_POST['sid'];
        $aClean['title'] = $_POST['title'];
        $aClean['content'] = $_POST['content'];
        $aClean['username'] = $_COOKIE['username'];
        $aClean = funcMysqlString($aClean);
        //写入数据库
        $sSqlStatements = "
            INSERT INTO tg_photo_comment
                (tg_sid, tg_username, tg_title, tg_content, tg_date)
            VALUES
                ('{$aClean['sid']}', '{$aClean['username']}', '{$aClean['title']}', '{$aClean['content']}', NOW())";
        funcSqlQuery($sSqlStatements);
        if(funcAffectRows() == 1){
            $sSqlStatements = "
                UPDATE tg_photo
                SET tg_commentcount=tg_commentcount+1
                WHERE tg_id='{$aClean['sid']}'";
            funcSqlQuery($sSqlStatements);
            funcCloseMysql();
            funcAlertJump('评论成功！','photoDetail.php?id='.$aClean['sid']);
        } 
        else{
            funcCloseMysql();
            funcAlertReturn('评论失败！');
        }
    }
    else{
        funcAlertReturn('非法登录');
    }
}
//取值
if(isset($_GET['id'])){
    $sSqlStatements = "
        SELECT tg_id, tg_sid, tg_name, tg_url, tg_username, tg_readcount, tg_commentcount,tg_date,tg_content
        FROM tg_photo
        WHERE tg_id='{$_GET['id']}'
        Limit 1";
    $aResult1 = funcFetchArray($sSqlStatements);
    if(!!$aResult1){
        //防止加密相册图片穿插访问
        //可以先取得这个图片的sid，也就是它的目录，
        //然后再判断这个目录是否是加密的，
        //如果是加密的，再判断是否有对应的cookie存在，并且对于相应的值
        //管理员不受这个限制
        if(!isset($_SESSION['admin'])){
            $sSqlStatements = "
                SELECT tg_type,tg_id,tg_name 
                FROM tg_dir 
                WHERE tg_id='{$aResult1['tg_sid']}'";
            $aDir = funcFetchArray($sSqlStatements);
            if(!!$aDir){
                if(!empty($_dirs['tg_type']) && $_COOKIE['photo'.$aDir['tg_id']] != $aDir['tg_name']){
                    funcAlertReturn('非法操作！');
                }    
            } 
            else{
                funcAlertReturn('相册目录表出错了！');
            }
        }
        //累计阅读量
        $sSqlStatements = "
            UPDATE tg_photo
            SET tg_readcount=tg_readcount+1
            WHERE tg_id='{$_GET['id']}'";
        funcSqlQuery($sSqlStatements);
        $aWebPageData = array();
        $aWebPageData['id'] = $aResult1['tg_id'];
        $aWebPageData['sid'] = $aResult1['tg_sid'];
        $aWebPageData['name'] = $aResult1['tg_name'];
        $aWebPageData['url'] = $aResult1['tg_url'];
        $aWebPageData['username'] = $aResult1['tg_username'];
        $aWebPageData['readcount'] = $aResult1['tg_readcount'];
        $aWebPageData['commentcount'] = $aResult1['tg_commentcount'];
        $aWebPageData['date'] = $aResult1['tg_date'];
        $aWebPageData['content'] = $aResult1['tg_content'];
        $aWebPageData = funcConvertHtml($aWebPageData);
        //创建全局变量，做一个带参数的分页
        global $iGlobalId;
        $iGlobalId = 'id='.$aWebPageData['id'].'&';
        //读取评论
        global $iPageNum, $iPageSize, $iPage;
        $sSqlStatements = "
            SELECT tg_id
            FROM tg_photo_comment
            WHERE tg_sid='{$aWebPageData['id']}'";
        funcPagingParameters($sSqlStatements, 2);
        $sSqlStatements = "
            SELECT
            tg_username, tg_title, tg_content, tg_date
            FROM tg_photo_comment
            WHERE tg_sid='{$aWebPageData['id']}'
            ORDER BY tg_date ASC
            LIMIT $iPageNum, $iPageSize";
        $rResult7 = funcSqlQuery($sSqlStatements);
        
        //上一页，取得比自己大的ID中，最小的那个即可。
        $sSqlStatements = "
            SELECT min(tg_id) AS id
            FROM tg_photo
            WHERE tg_sid='{$aWebPageData['sid']}' AND tg_id>'{$aWebPageData['id']}'
            LIMIT 1";
        $aWebPageData['preid'] = funcFetchArray($sSqlStatements);   
        if(!empty($aWebPageData['preid']['id'])){
            $aWebPageData['pre'] = '<a href="photoDetail.php?id='.$aWebPageData['preid']['id'].'#pre">上一页</a>';
        } 
        else{
            $aWebPageData['pre'] = '<span>到头了</span>';
        }
        //下一页，取得比自己小的ID中，最大的那个即可。
        $sSqlStatements = "
            SELECT max(tg_id) AS id
            FROM tg_photo
            WHERE tg_sid='{$aWebPageData['sid']}' AND tg_id<'{$aWebPageData['id']}'
            LIMIT 1";
        $aWebPageData['nextid'] = funcFetchArray($sSqlStatements);
        $aWebPageData['preid'] = funcFetchArray($sSqlStatements);
        if(!empty($aWebPageData['nextid']['id'])){
            $aWebPageData['next'] = '<a href="photoDetail.php?id='.$aWebPageData['nextid']['id'].'#next">下一页</a>';
        }
        else{
            $aWebPageData['next'] = '<span>到尾了</span>';
        }     
    } 
    else{
        funcAlertReturn('不存在此图片！');
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
<script type="text/javascript" src=""></script>
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
    <div id="photoDetail">       
        <h2>图片详情</h2>
        <a name="pre"></a>
        <a name="next"></a>
        <dl class="detail">            
            <dd class="name"><?php echo  $aWebPageData['name']?></dd>
            <dt>
                <?php echo $aWebPageData['pre']?><img src="<?php echo $aWebPageData['url']?>" /><?php echo $aWebPageData['next']?>                
            </dt>
            <dd>[<a href="photoShow.php?id=<?php echo $aWebPageData['sid']?>">返回列表</a>]</dd>
            <dd>浏览量(<strong><?php echo $aWebPageData['readcount']?></strong>) 
                                                评论量(<strong><?php echo $aWebPageData['commentcount']?></strong>) 
                                                发表于：<?php echo $aWebPageData['date']?> 
                                                上传者：<?php echo $aWebPageData['username']?>
            </dd>
            <dd>简介：<?php echo $aWebPageData['content']?></dd>
        </dl>
        <?php 
            $iFloorNum = 1;
            while(!!$aResult = funcFetchArrayList($rResult7)){
                $aWebPageData['username'] = $aResult['tg_username'];
                $aWebPageData['type'] = $aResult['tg_type'];
                $aWebPageData['content'] = $aResult['tg_content'];
                $aWebPageData['time'] = $aResult['tg_time'];
                $aWebPageData['reTitle'] = $aResult['tg_title'];
                $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
                //拿出用户名，去查找用户信息
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
                }
                else{
                    //这个用户可能已经被删除了
                }
        ?>
        <p class="line"></p>
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
    			<h3>主题：<?php echo $aWebPageData['reTitle']?></h3>
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
        <?php $iFloorNum++;}?>
        <?php
            funcFreeMysqlResult($rResult7);
            //分页调用函数；默认为false，调用数字分页；若为true，则调用文本分页
            funcPaging(true);
        ?>
        <?php if(isset($_COOKIE['username'])){?>
        <p class="line"></p>
        <form method="post" action="?action=rephoto">
            <input type="hidden" name="sid" value="<?php echo $aWebPageData['id']?>" />
            <dl class="rePhoto">  
                <dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $aWebPageData['name']?>"/>(*必填，2-40位)</dd>
                <dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a> <a href="javascript:;">Q图系列[2]</a> <a href="javascript:;">Q图系列[3]</a></dd>
                <dd><?php include ROOT_PATH.'includes/ubb.inc.php'?><textarea name="content" rows="9"></textarea></dd>
                <dd> 验 证 码：
                    <input type="text" name="captcha" class="text captcha" />
                    <img src="captcha.php" id="captcha" />
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