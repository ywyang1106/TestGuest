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
//定义常量，用来授权调用includes里的文件
define("ERRORCALL",true);
//常量，指定本页的内容
define('THISPAGENAME', 'thumb');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//缩略图
if (isset($_GET['filename']) && isset($_GET['percent'])){
    funcThumb($_GET['filename'], $_GET['percent']);
}
?>