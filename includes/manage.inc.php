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
//防止恶意调用
if(!defined('ERRORCALL')){
    exit('Access Deny!');
}
?>
<div id="manageSidebar">
    <h2>管理导航</h2>
    <dl>
        <dt>系统管理</dt>
        <dd><a href="manage.php">后台首页</a></dd>
        <dd><a href="manageSet.php">系统设置</a></dd>               
    </dl>
    <dl>
        <dt>会员管理</dt>
        <dd><a href="manageMember.php">会员列表</a></dd>
        <dd><a href="manageJobSet.php">职务设置</a></dd>               
    </dl>
</div>