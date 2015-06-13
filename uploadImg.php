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
//定义常量，用来授权调用includes里的文件
define("ERRORCALL",true);
//常量，指定本页的内容
define('THISPAGENAME','uploadImg');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//非会员不可见
if(!$_COOKIE['username']){
    funcAlertReturn('非法登录');
}
//执行上传图片功能
if($_GET['action'] == 'upload'){
    $sSqlStatements = "
        SELECT tg_uniqid
        FROM tg_user
        WHERE tg_username='{$_COOKIE['username']}'
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){
        //引入验证函数文件
        include ROOT_PATH.'includes/verifyLegal.func.php';
        funcVerifyUniqid($aResult['tg_uniqid'], $_COOKIE['uniqid']);
        //设置上传图片的类型
        $rFiles = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
        //判断类型是否是数组里的一种
        if(is_array($rFiles)){
            if(!in_array($_FILES['userfile']['type'],$rFiles)){
                funcAlertReturn('上传图片必须是jpg,png,gif中的一种！');
            }
        }
        //判断文件错误类型
        if($_FILES['userfile']['error'] > 0){
            switch($_FILES['userfile']['error']){
                case 1: funcAlertReturn('上传文件超过约定值1'); break;
                case 2: funcAlertReturn('上传文件超过约定值2'); break;
                case 3: funcAlertReturn('部分文件被上传'); break;
                case 4: funcAlertReturn('没有任何文件被上传！'); break;
            }
            exit;
        }
        //判断配置大小
        if($_FILES['userfile']['size'] > 1000000){
            funcAlertReturn('上传的文件不得超过1M');
        }    
        //获取文件的扩展名 1.jpg
        $sExtendName = explode('.', $_FILES['userfile']['name']);
        $sFileName = $_POST['dir'].'/'.time().'.'.$sExtendName[1];
        //移动文件
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
            if(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$sFileName)){
                funcAlertReturn('移动失败');
            } 
            else{
                //funcAlertClose('上传成功！');
                echo "<script>alert('上传成功！');window.opener.document.getElementById('url').value='$sFileName';window.close();</script>";
                exit();
            }
        } 
        else{
            funcAlertReturn('上传的临时文件不存在！');
        }
    }
    else{
        funcAlertReturn('非法登录！');
    }
}
//接收dir
if(!isset($_GET['dir'])){
    funcAlertReturn('非法操作！asfdasdfasdf');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
    <div id="uploadImg" style="padding: 20px;">
        <form enctype="multipart/form-data" action="uploadImg.php?action=upload" method="post">
		    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		    <input type="hidden" name="dir" value="<?php echo $_GET['dir']?>" />
		           选择图片: <input type="file" name="userfile" /><input type="submit" value="上传" />
	    </form>
    </div>
</body>
</html>