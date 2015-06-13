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
//防止恶意调用
if(!defined('ERRORCALL')){
    exit('Access Deny!');
}
//关闭数据库
funcCloseMysql();
//程序运行结束时间
?>
<div id="footer">
    <p>本程序执行耗时为：<?php echo round(funcRunTime() - $GLOBALS['sStartTime'],4); ?>秒</p>
	<p>版权所有 翻版必究</p>
	<p>
		本程序由<span>ywyang</span>提供 源代码可以任意修改和发布(c) y.w.yang@163.com
	</p>
</div>
