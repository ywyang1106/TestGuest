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
define('THISPAGENAME', 'photoAddDir');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//必须是管理员才能登录
funcManageLogin();
//添加目录
if($_GET['action'] == 'adddir'){
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
		//接受数据
		$aClean = array();
		$aClean['name'] = funcVerifyDirName($_POST['name']);
		$aClean['type'] = $_POST['type'];
		if(!empty($aClean['type'])){
		    $aClean['password'] = funcVerifyDirPassword($_POST['password']);
		}
		$aClean['content'] = $_POST['content'];
		$aClean['dir'] = time();
		$aClean = funcMysqlString($aClean);
		//先检查一下主目录是否存在
        if(!is_dir('photo')){
			mkdir('photo',0777);
	    }
		//再在这个主目录里面创建你定义的相册目录
        if(!is_dir('photo/'.$aClean['dir'])){
            mkdir('photo/'.$aClean['dir']);
        }
        //把当前的目录信息写入数据库即可
        if(empty($aClean['type'])){
            $sSqlStatements = "
                INSERT INTO tg_dir
                    (tg_name, tg_type, tg_content, tg_dir, tg_date)
                VALUES
                    ('{$aClean['name']}', '{$aClean['type']}', '{$aClean['content']}', 'photo/{$aClean['dir']}', NOW())";
            funcSqlQuery($sSqlStatements);
        }
        else{
            $sSqlStatements = "
                INSERT INTO tg_dir
                    (tg_name, tg_type, tg_content, tg_dir, tg_date, tg_password)
                VALUES
                    ('{$aClean['name']}', '{$aClean['type']}', '{$aClean['content']}', 'photo/{$aClean['dir']}', NOW(), '{$aClean['password']}')";
            funcSqlQuery($sSqlStatements);
        }
        //目录添加成功  
        if(funcAffectRows() == 1){
            funcCloseMysql();
            funcAlertJump('目录添加成功！','photoAlbums.php');
        }
        else{
            funcCloseMysql();
            funcAlertReturn('目录添加失败！');
        }
    }
    else{
        funcAlertReturn('非法登录！');
    }
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
    <div id="photoAddDir">       
        <h2>添加相册目录</h2>
        <form method="post" action="?action=adddir">
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text"/></dd>
                <dd>相册类型：<input type="radio" name="type" value="0" checked="checked"/>公开<input type="radio" name="type" value="1" />私密</dd>
                <dd id="password">相册密码：<input type="password" name="password" class="text"/></dd>
                <dd>相册描述：<textarea name="content"></textarea></dd>
                <dd><input type="submit" value="添加目录" class="submit"/></dd>
            </dl>
        </form>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>