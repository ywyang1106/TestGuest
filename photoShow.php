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
define('THISPAGENAME', 'photoShow');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//删除相片

if(isset($_GET['id']) && $_GET['action'] == 'delete'){
    $sSqlStatements = "
        SELECT tg_uniqid
        FROM tg_user
        WHERE tg_username='{$_COOKIE['username']}'
        Limit 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        //引入验证函数文件
        include ROOT_PATH.'includes/verifyLegal.func.php';
        funcVerifyUniqid($aResult['tg_uniqid'],$_COOKIE['uniqid']);
        //取得这张图片的发布者
        $sSqlStatements = "
            SELECT tg_username, tg_url, tg_id, tg_sid
            FROM tg_photo
            WHERE tg_id='{$_GET['id']}'
            Limit 1";
        $aResult = funcFetchArray($sSqlStatements);
        if(!!$aResult){
            $aWebPageData = array();
            $aWebPageData['id'] = $aResult['tg_id'];
            $aWebPageData['sid'] = $aResult['tg_sid'];
            $aWebPageData['username'] = $aResult['tg_username'];
            $aWebPageData['url'] = $aResult['tg_url'];
            $aWebPageData = funcConvertHtml($aWebPageData);
            //判断删除图片的身份是否合法
            if($aWebPageData['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])){
                $sSqlStatements = "
                    DELETE 
                    FROM tg_photo
                    WHERE tg_id='{$aWebPageData['id']}'";
                funcSqlQuery($sSqlStatements);
                if(funcAffectRows() == 1){
                    //删除图片物理地址
                    if(file_exists($aWebPageData['url'])){
                        unlink($aWebPageData['url']);
                    }
                    else{
                        funcAlertReturn('磁盘里已不存在此图！');
                    }
                    funcCloseMysql();
                    funcAlertJump('图片删除成功！','photoShow.php?id='.$aWebPageData['sid']);
                }
                else{
                    funcCloseMysql();
                    funcAlertReturn('删除失败！');
                }
            }
            else{
                funcAlertReturn('非法操作！');
            }
        }
        else{
            funcAlertReturn('不存在此图片！');
        }
    }
    else{
        funcAlertReturn('非法登录！');
    }
}
//取值
if(isset($_GET['id'])){
    $sSqlStatements = "
        SELECT tg_id, tg_name, tg_type
        FROM tg_dir
        WHERE tg_id='{$_GET['id']}'
        Limit 1";
    $aResult1 = funcFetchArray($sSqlStatements);
    if(!!$aResult1){
        $aWebPageDataDir = array();
        $aWebPageDataDir['id'] = $aResult1['tg_id'];
        $aWebPageDataDir['name'] = $aResult1['tg_name'];
        $aWebPageDataDir['type'] = $aResult1['tg_type'];
        $aWebPageDataDir = funcConvertHtml($aWebPageDataDir);
        //对比加密相册的验证信息
        if($_POST['password']){
            $sSqlStatements = "
                SELECT tg_id
                FROM tg_dir
                WHERE tg_password='".sha1($_POST['password'])."'
                Limit 1";
            $aResult2 = funcFetchArray($sSqlStatements);
            if(!!$aResult2){
                //生成cookie
                setcookie('photo'.$aWebPageDataDir['id'], $aWebPageDataDir['name']);
                //重定向
                funcAlertJump(null,'photoShow.php?id='.$aWebPageDataDir['id']);
            }
            else{
                funcAlertReturn('相册密码不正确!');
            }
        }
    } 
    else{
        funcAlertReturn('不存在此相册！');
    }
} 
else{
    funcAlertReturn('非法操作！');
}
$fPercent = 0.3;
//分页模块
global $iPageNum, $iPageSize, $aSystem, $iGlobalId;
$iGlobalId = 'id='.$aWebPageDataDir['id'].'&';
$sSqlStatements = "
    SELECT tg_id 
    FROM tg_photo 
    WHERE tg_sid='{$aWebPageDataDir['id']}'";
funcPagingParameters($sSqlStatements, $aSystem['photo']);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据    WHERE tg_sid='{$aWebPageDataDir['id']}'
$sSqlStatements = "
    SELECT tg_id, tg_username, tg_name, tg_url, tg_readcount, tg_commentcount
    FROM tg_photo
    WHERE tg_sid='{$aWebPageDataDir['id']}' 
    ORDER BY tg_date
    DESC
    LIMIT $iPageNum, $iPageSize";
$rResult = funcSqlQuery($sSqlStatements);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src=""></script>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="photoShow">       
        <h2><?php echo $aWebPageDataDir['name']?></h2>
        <?php
            if(empty($aWebPageDataDir['type']) || $_COOKIE['photo'.$aWebPageDataDir['id']] == $aWebPageDataDir['name'] || isset($_SESSION['admin'])){
                $aWebPageData = array();
                while(!!$aResult = funcFetchArrayList($rResult)){
                    $aWebPageData['id'] = $aResult['tg_id'];
                    $aWebPageData['username'] = $aResult['tg_username'];
                    $aWebPageData['name'] = $aResult['tg_name'];
                    $aWebPageData['url'] = $aResult['tg_url'];
                    $aWebPageData['readcount'] = $aResult['tg_readcount'];
                    $aWebPageData['commentcount'] = $aResult['tg_commentcount'];
                    $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
        ?>
        <dl>
            <dt>
                <a href="photoDetail.php?id=<?php echo $aWebPageData['id']?>">
                <img src="thumb.php?filename=<?php echo $aWebPageData['url']?>&percent=<?php echo $fPercent?>" />
                </a>
            </dt>
            <dd><a href="photoDetail.php?id=<?php echo $aWebPageData['id']?>"><?php echo $aWebPageData['name']?></a></dd>
            <dd>阅(<strong><?php echo $aWebPageData['readcount']?></strong>评(<strong><?php echo $aWebPageData['commentcount']?></strong>)上传者：<?php echo $aWebPageData['username']?></dd>
            <?php if($aWebPageData['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])){?>
                <dd>[<a href="photoShow.php?action=delete&id=<?php echo $aWebPageData['id']?>">删除</a>]</dd>
            <?php }?>
        </dl>
       <?php }
            funcFreeMysqlResult($rResult);
            //分页调用函数；默认为false，调用数字分页；若为true，则调用文本分页
            funcPaging(true);
        ?>
        <p><a href="photoAddImage.php?id=<?php echo $aWebPageDataDir['id']?>">上传图片</a></p>
        <?php 
            }
            else{
                echo '<form method="post" action="photoShow.php?id='.$aWebPageDataDir['id'].'">';
		        echo '<p>请输入密码：<input type="password" name="password" /> <input type="submit" value="确认" /></p>';
		        echo '</form>';
            }
        ?>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>