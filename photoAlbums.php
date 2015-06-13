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
define('THISPAGENAME', 'photoAlbums');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//删除目录
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
        //删除目录
        $sSqlStatements = "
            SELECT tg_dir
            FROM tg_dir
            WHERE tg_id='{$_GET['id']}'
            Limit 1";
        $aResult = funcFetchArray($sSqlStatements);
        if(!!$aResult){
            $aWebPageData = array();
            $aWebPageData['dir'] = $aResult['tg_dir'];
            $aWebPageData = funcConvertHtml($aWebPageData);
            //3.删除磁盘的目录
            if(file_exists($aWebPageData['dir'])){
                if(funcRemoveDir($aWebPageData['dir'])){
                    //1.删除目录里的数据库图片
                    funcSqlQuery("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
                    //2.删除这个目录的数据库
                    funcSqlQuery("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
                    funcCloseMysql();
                    funcAlertJump('目录删除成功！', 'photoAlbums.php');
                }
                else{
                    funcCloseMysql();
                    funcAlertReturn('目录删除失败！');
                }
            }
            else{
                funcAlertReturn('不存在此目录！');
            }
        }
        else{
            funcAlertReturn('非法登录！');
        }
    }   
}
global $iPageNum, $iPageSize, $aSystem;
$sSqlStatements = "SELECT tg_id FROM tg_dir";
funcPagingParameters($sSqlStatements, $aSystem['photo']);
//从数据库里提取数据获取结果集
//每次只是重新读取结果集，而不是重新执行从数据库里提取数据
$sSqlStatements = "
    SELECT tg_id, tg_name, tg_type, tg_covers
    FROM tg_dir
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
    <div id="photoAlubms">       
        <h2>相册列表</h2>
        <?php 
            $aWebPageData = array();
            while(!!$aResult = funcFetchArrayList($rResult)){
                $aWebPageData['id'] = $aResult['tg_id'];
                $aWebPageData['name'] = $aResult['tg_name'];
                $aWebPageData['type'] = $aResult['tg_type'];
                $aWebPageData['covers'] = $aResult['tg_covers'];
                $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
                if(empty($aWebPageData['type'])){
                    $aWebPageData['type_html'] = '(公开)';
                }
                else{
                    $aWebPageData['type_html'] = '(私密)';
                }
                if(empty($aWebPageData['covers'])){
                    $aWebPageData['covers_html'] = '';
                }
                else{
                    $aWebPageData['covers_html'] = '<img src="'.$aWebPageData['covers'].'" alt="'.$aWebPageData['name'].'">';
                }
                //统计相册里的照片数量
                $sSqlStatements = "
                    SELECT COUNT(*) AS count 
                    FROM tg_photo 
                    WHERE tg_sid={$aWebPageData['id']}";
                $aWebPageData['photo'] = funcFetchArray($sSqlStatements);
        ?>
        <dl>
            <dt><a href="photoShow.php?id=<?php echo $aWebPageData['id']?>"><?php echo $aWebPageData['covers_html']?></a></dt>
            <dd>
                <a href="photoShow.php?id=<?php echo $aWebPageData['id']?>">
                    <?php echo $aWebPageData['name']?><br/>
                    <?php echo  '['.$aWebPageData['photo']['count'].']'.$aWebPageData['type_html']?>
                </a>
            </dd>
            <?php if(isset($_SESSION['admin']) && isset($_COOKIE['username'])){?>
                <dd>[
                    <a href="photoDirModify.php?id=<?php echo $aWebPageData['id']?>">修改</a>][
                    <a href="photoAlbums.php?action=delete&id=<?php echo $aWebPageData['id']?>">删除</a>]
                </dd>
            <?php }?>
        </dl>
        <?php }?>
        <?php if(isset($_SESSION['admin']) && isset($_COOKIE['username'])){?>
            <p><a href="photoAddDir.php">添加目录</a></p>
        <?php }?>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>