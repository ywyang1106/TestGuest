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
define('THISPAGENAME', 'photoDirModify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//必须是管理员才能登录
funcManageLogin();
//修改数据
if($_GET['action'] == 'modify'){
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
        //接收数据
        //接受数据
        $aClean = array();
        $aClean['id'] = $_POST['id'];
        $aClean['name'] = funcVerifyDirName($_POST['name']);
        $aClean['type'] = $_POST['type'];
        if(!empty($aClean['type'])){
            $aClean['password'] = funcVerifyDirPassword($_POST['password']);
        }
        $aClean['covers'] = $_POST['covers'];
        $aClean['content'] = $_POST['content'];
        $aClean = funcMysqlString($aClean);
        //修改目录
        //把当前的目录信息写入数据库即可
        if(empty($aClean['type'])){
            $sSqlStatements = "
                UPDATE tg_dir
                SET 
                    tg_name='{$aClean['name']}',
                    tg_type='{$aClean['type']}',
                    tg_password=NULL,
                    tg_covers='{$aClean['covers']}',
                    tg_content='{$aClean['content']}'
                WHERE tg_id='{$aClean['id']}'
                LIMIT 1";
            funcSqlQuery($sSqlStatements);
        }
        else{
            $sSqlStatements = "
                UPDATE tg_dir
                SET 
                    tg_name='{$aClean['name']}',
                    tg_type='{$aClean['type']}',
                    tg_password='{$aClean['password']}',
                    tg_covers='{$aClean['covers']}',
                    tg_content='{$aClean['content']}'
                WHERE tg_id='{$aClean['id']}'
                LIMIT 1";
            funcSqlQuery($sSqlStatements);
        }
        //目录添加成功
        if(funcAffectRows() == 1){
            funcCloseMysql();
            funcAlertJump('目录修改成功！','photoAlbums.php');
        }
        else{
            funcCloseMysql();
            funcAlertReturn('目录修改失败！');
        }
    }
    else{
        funcAlertReturn('非法登录');
    }
}
//读出数据
if(isset($_GET['id'])){
    $sSqlStatements = "
        SELECT tg_id, tg_name, tg_type, tg_covers, tg_content
        FROM tg_dir 
        WHERE tg_id='{$_GET['id']}' 
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){//判定数据库是否有选择的数据，若有再进行数据更改
        $aWebPageData = array();
        $aWebPageData['id'] = $aResult['tg_id'];
        $aWebPageData['type'] = $aResult['tg_type'];
        $aWebPageData['name'] = $aResult['tg_name'];
        $aWebPageData['covers'] = $aResult['tg_covers'];
        $aWebPageData['content'] = $aResult['tg_content'];
        $aWebPageData = funcConvertHtml($aWebPageData);
    }
    else{
        funcAlertReturn('不存在此相册');
    }
}
else{
    funcAlertReturn('非法操作');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/photoAddDir.js"></script>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="photoDirModify">       
        <h2>修改相册目录</h2>
        <form method="post" action="?action=modify">
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text" value="<?php echo $aWebPageData['name'] ?>"/></dd>
                <dd>相册类型：
                    <input type="radio" name="type" value="0" <?php if($aWebPageData['type'] == 0) echo 'checked="checked"'?>/>公开
                    <input type="radio" name="type" value="1" <?php if($aWebPageData['type'] == 1) echo 'checked="checked"'?> />私密
                </dd>
                <dd id="password" <?php if ($aWebPageData['type'] == 1) echo 'style="display:block;"'?>>相册密码：
                    <input type="password" name="password" class="text"/>
                </dd>
                <dd>相册封面：<input type="text" name="covers" class="text" value="<?php echo $aWebPageData['covers'] ?>"/></dd>
                <dd>相册描述：<textarea name="content"><?php echo $aWebPageData['content'] ?></textarea></dd>
                <dd><input type="submit" value="修改目录" class="submit"/></dd>
            </dl>
            <input type="hidden" value="<?php echo $aWebPageData['id']?>" name="id" />
        </form>
    </div> 
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>