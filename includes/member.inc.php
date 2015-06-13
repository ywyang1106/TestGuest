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
<div id="memberSidebar">
    <h2>中心导航</h2>
    <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人资料</a></dd>
        <dd><a href="memberModify.php">修改资料</a></dd>               
    </dl>
    <dl>
        <dt>其他管理</dt>
        <dd><a href="memberCheckMessage.php">信息查阅</a></dd>
        <dd><a href="memberSetFriend.php">好友设置</a></dd>
        <dd><a href="memberCheckFlower.php">查询花朵</a></dd>
        <dd><a href="memberPhotoAlbums.php">个人相册</a></dd>                
    </dl>
</div>