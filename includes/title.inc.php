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
//防止非HTML页面调用
if(!defined('THISPAGENAME')){
    exit('THISPAGENAME Error!');
}
global $aSystem;
?>
<title><?php echo $aSystem['webname']?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="styles/<?php echo $aSystem['skin']?>/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/<?php echo $aSystem['skin']?>/<?php echo THISPAGENAME?>.css" />
