<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年6月12日
*/
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'articleModify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
$sSkinurl = $_SERVER["HTTP_REFERER"];
//必须从上一页点击过来，而且必须有ID
if(empty($sSkinurl) || !isset($_GET['id'])){
    funcAlertReturn('非法操作！');
} 
else{
    //最好判断一下id必须是1，2，3中的一个
    //生成一个cookie，用来保存皮肤的种类
    setcookie('skin', $_GET['id']);
    funcAlertJump(null, $sSkinurl);
}
?>
