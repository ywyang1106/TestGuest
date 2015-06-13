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
define('THISPAGENAME', 'memberModify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//修改资料
if ($_GET['action'] == 'modify'){
    //为了防止恶意注册，跨站攻击
    funcVerifyCaptcha($_POST['captcha'], $_SESSION['captcha']);
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    $sSqlStatements = "
        SELECT tg_uniqid 
        FROM tg_user 
        WHERE tg_username='{$_COOKIE['username']}' 
        LIMIT 1";
    $aResult = funcFetchArray($sSqlStatements);
    if(!!$aResult){//判定数据库是否有选择的数据，若有再进行数据更改
        //为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        funcVerifyUniqid($aResult['tg_uniqid'], $_COOKIE['uniqid']);
        //创建一个空数组，用来存放提交过来的数据；
        $aClean = array();
        //开始验证
        $aClean['password'] = funcVerifyModifyPassword($_POST['password']);
        $aClean['sex'] = funcVerifySex($_POST['sex']);
        $aClean['avatar'] = funcVerifyAvatar($_POST['avatar']);
        $aClean['email'] = funcVerifyEmail($_POST['email'], 6, 40);
        $aClean['qq'] = funcVerifyQQ($_POST['qq'], 5, 10);
        $aClean['url'] = funcVerifyUrl($_POST['url'], 6, 40);
        $aClean['switch'] = $_POST['switch'];
        $aClean['autograph'] = funcVerifyAutograph($_POST['autograph']);
        //修改资料
        if(empty($aClean['password'])){
            $sSqlStatements = "
                UPDATE tg_user 
                SET
                    tg_sex='{$aClean['sex']}',
                    tg_avatar='{$aClean['avatar']}',
                    tg_email='{$aClean['email']}',
                    tg_qq='{$aClean['qq']}',
                    tg_url='{$aClean['url']}',
                    tg_switch = '{$aClean['switch']}',
                    tg_autograph = '{$aClean['autograph']}'
                WHERE
                    tg_username='{$_COOKIE['username']}'";
            funcSqlQuery($sSqlStatements);
        }
        else{
            $sSqlStatements = "
                UPDATE tg_user 
                SET
                    tg_password='{$aClean['password']}',
                    tg_sex='{$aClean['sex']}',
                    tg_avatar='{$aClean['avatar']}',
                    tg_email='{$aClean['email']}',
                    tg_qq='{$aClean['qq']}',
                    tg_url='{$aClean['url']}',
                    tg_switch = '{$aClean['switch']}',
                    tg_autograph = '{$aClean['autograph']}'
                WHERE
                    tg_username='{$_COOKIE['username']}'";
            funcSqlQuery($sSqlStatements);
        }
    }
    //判断是否修改成功
    if (funcAffectRows() == 1) {
        funcCloseMysql();
        //funcSessionDestroy();
        funcAlertJump('修改成功','member.php');
    } 
    else{
        funcCloseMysql();
        //funcSessionDestroy();
        funcAlertJump('数据没有被更改','memberModify.php');
    }
}
//是否正常登录
if(isset($_COOKIE['username'])){
    //从数据库获取数据
    $sSqlStatements = "
        SELECT tg_username, tg_sex, tg_avatar, tg_email, tg_qq, tg_url, tg_switch, tg_autograph
        FROM tg_user 
        WHERE tg_username='{$_COOKIE['username']}'";
    $aResult = funcFetchArray($sSqlStatements);
    if($aResult){
        $aWebPageData = array();
        $aWebPageData['username'] = $aResult['tg_username'];
        $aWebPageData['sex'] = $aResult['tg_sex']; 
        $aWebPageData['avatar'] = $aResult['tg_avatar'];
        $aWebPageData['email'] = $aResult['tg_email'];
        $aWebPageData['qq'] = $aResult['tg_qq'];
        $aWebPageData['url'] = $aResult['tg_url'];
        $aWebPageData['switch'] = $aResult['tg_switch'];
        $aWebPageData['autograph'] = $aResult['tg_autograph'];
        $aWebPageData = funcConvertHtml($aWebPageData);//对传入数据进行过滤
        //性别选择
        if($aWebPageData['sex'] == '男'){
            $aWebPageData['pageDataSex'] = '<input type="radio" name="sex" value="男" checked="checked" /> 男 <input type="radio" name="sex" value="女" /> 女';
        }
        elseif($aWebPageData['sex'] == '女'){
            $aWebPageData['pageDataSex'] = '<input type="radio" name="sex" value="男" /> 男 <input type="radio" name="sex" value="女" checked="checked" /> 女';
        }
        //头像选择
        $aWebPageData['pageDataAvatar'] = '<select name="avatar">';
        foreach(range(1,9) as $iNumber){
            if($aWebPageData['avatar'] == 'avatar/m0'.$iNumber.'.gif'){
                $aWebPageData['pageDataAvatar'] .= '<option value="avatar/m0'.$iNumber.'.gif" selected="selected">avatar/m0'.$iNumber.'.gif</option>';
            }
            else{
                $aWebPageData['pageDataAvatar'] .= '<option value="avatar/m0'.$iNumber.'.gif">avatar/m0'.$iNumber.'.gif</option>';
            }
        }
        foreach(range(10,64) as $iNumber){
            if($aWebPageData['avatar'] == 'avatar/m'.$iNumber.'.gif'){
                $aWebPageData['pageDataAvatar'] .= '<option value="avatar/m'.$iNumber.'.gif" selected="selected">avatar/m'.$iNumber.'.gif</option>';
            }
            else{
                $aWebPageData['pageDataAvatar'] .= '<option value="avatar/m'.$iNumber.'.gif">avatar/m'.$iNumber.'.gif</option>';
            }
        }
        $aWebPageData['pageDataAvatar'] .= '</select>';
        //签名开关
        if($aWebPageData['switch'] == 1){
            $aWebPageData['switch_html'] = '<input type="radio" name="switch" value="1" checked="checked"/>启用<input type="radio" name="switch" value="0"/>禁用';
        }
        elseif($aWebPageData['switch'] == 0){
            $aWebPageData['switch_html'] = '<input type="radio" name="switch" value="1" />启用<input type="radio" name="switch" value="0" checked="checked"/>禁用';
        }
    }
    else{
        echo '此用户不存在';
    }
}
else{
    echo '非法登录';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/captcha.js"></script>
<script type="text/javascript" src="js/memberModify.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="member">
        <?php 
            require 'includes/member.inc.php';
        ?>
        <div id="memberMainArea">
            <h2>会员管理中心</h2>
            <form method="post" name="modify" action="?action=modify">
                <dl>
        			<dd>用 户 名：<?php echo $aWebPageData['username']?></dd>
        			<dd>密　　码：<input type="password" class="text" name="password" /> (留空则不修改)</dd>
        			<dd>性　　别：<?php echo $aWebPageData['pageDataSex']?></dd>
        			<dd>头　　像：<?php echo $aWebPageData['pageDataAvatar']?></dd>
        			<dd>电子邮件：<input type="text" class="text" name="email" value ="<?php echo $aWebPageData['email']?>"/></dd>
        			<dd>主　　页：<input type="text" class="text" name="url" value ="<?php echo $aWebPageData['url']?>"/></dd>
        			<dd>Q 　 　Q：<input type="text" class="text" name="qq" value ="<?php echo $aWebPageData['qq']?>"/></dd>
        			<dd>个性签名：<?php echo $aWebPageData['switch_html']?>(可以使用UBB代码)
        			     <p><textarea rows="2" cols="60" name="autograph"><?php echo $aWebPageData['autograph']?></textarea></p>
        			</dd>
        			<dd>验 证 码：
        			    <input type="text" name="captcha" class="text captcha" />
        			    <img src="captcha.php" id="captcha" />
        			    <input type="submit" class="submit" value="修改资料" />
        			</dd>		      
        		</dl>
    		</form>
        </div>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>