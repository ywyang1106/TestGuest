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
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'avatar');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/opener.js"></script>
</head>
<body>
    <div id="avatar">
        <h3>选择头像</h3>
        <dl>
            <?php foreach(range(1,9) as $num){?>
            <dd><img src="avatar/m0<?php echo $num?>.gif" alt="avatar/m0<?php echo $num?>.gif" title="头像<?php echo $num?>" /></dd>
            <?php }?>
        </dl>
        <dl>
            <?php foreach(range(10,64) as $num){?>
            <dd><img src="avatar/m<?php echo $num?>.gif" alt="avatar/m<?php echo $num?>.gif" title="头像<?php echo $num?>" /></dd>
            <?php }?>
        </dl>
    </div>
</body>
</html>