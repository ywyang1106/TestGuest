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
define('THISPAGENAME', 'photoAddImage');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//非会员不可见
if(!$_COOKIE['username']){
    funcAlertReturn('非法登录');
}
//保存图片信息入表
if($_GET['action'] == 'addimg'){
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
		//接收数据
        $aClean = array();
        $aClean['name'] = funcVerifyDirName($_POST['name'],2,20);
        $aClean['url'] = funcVerifyPhotoUrl($_POST['url']);
        $aClean['content'] = $_POST['content'];
        $aClean['sid'] = $_POST['sid'];
        $aClean = funcMysqlString($aClean);
        //写入数据库
        $sSqlStatements = "
            INSERT INTO tg_photo 
                (tg_name, tg_url, tg_content, tg_sid, tg_username, tg_date)
            VALUES 
                ('{$aClean['name']}', '{$aClean['url']}', '{$aClean['content']}', '{$aClean['sid']}', '{$_COOKIE['username']}', NOW())";
        funcSqlQuery($sSqlStatements);
        if(funcAffectRows() == 1){
            funcCloseMysql();
            funcAlertJump('图片添加成功！','photoShow.php?id='.$aClean['sid']);
        } 
        else{
            funcCloseMysql();
            funcAlertReturn('图片添加失败！');
        }
    } 
    else{
        funcAlertReturn('非法登录！');
    }
}
//取值
if(isset($_GET['id'])){
    $sSqlStatements = "
        SELECT tg_id, tg_dir
        FROM tg_dir
        WHERE tg_id='{$_GET['id']}'
        Limit 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        $aWebPageData = array();
        $aWebPageData['id'] = $aResult['tg_id'];
        $aWebPageData['dir'] = $aResult['tg_dir'];
        $aWebPageData = funcConvertHtml($aWebPageData);
    }
    else{
        funcAlertReturn('不存在此相册！');
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
<script type="text/javascript" src="js/photoAddImage.js"></script>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="photoAddImage">       
        <h2>上传图片</h2>
        <form method="post" action="?action=addimg">
            <input type="hidden" name="sid" value="<?php echo $aWebPageData['id']?>" />
            <dl>
                <dd>图片名称：<input type="text" name="name" class="text"/></dd>
                <dd>图片地址：<input type="text" name="url" id="url" readonly="readonly" class="text"/><a href="javascript:;" title="<?php echo $aWebPageData['dir']?>" id="upload">上传</a></dd>
                <dd>图片描述：<textarea name="content"></textarea></dd>
                <dd><input type="submit" value="添加图片" class="submit"/></dd>
            </dl>
        </form>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>