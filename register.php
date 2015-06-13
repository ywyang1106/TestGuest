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
session_start();
//定义常量，用来授权调用includes里的文件
define("ERRORCALL", true);
//常量，指定本页的内容
define('THISPAGENAME', 'register');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';//使用硬路径，速度更快
//登录状态判定
funcLoginState();
global $aSystem;
//判断数据是否提交
if($_GET['action'] == 'register'){
    if(empty($aSystem['register'])){
        exit('不允许非法注册');
    }
    //为了防止恶意注册，跨站攻击
    funcVerifyCaptcha($_POST['captcha'], $_SESSION['captcha']);
    //引入验证函数文件
    include ROOT_PATH.'includes/verifyLegal.func.php';
    //创建一个空数组，用来存放提交过来的数据；
    $aClean = array();
    //开始验证
    //可以通过唯一标示符来防止恶意注册，伪装表单跨站攻击等
    //这个存入数据库的唯一标示符还有第二个用处，就是登录cookies验证
    $aClean['uniqid'] = funcVerifyUniqid($_POST['uniqid'], $_SESSION['uniqid']);
    //active也是一个唯一标示符，用来给刚注册的用户进行激活处理，方可登录
    $aClean['active'] = funcSha1Uniqid();
    $aClean['username'] = funcVerifyUsername($_POST['username'], 2, 20);
    $aClean['password'] = funcVerifyPassword($_POST['password'], $_POST['confirm'], 6, 32);
    $aClean['question'] = funcVerifyQuestion($_POST['question'], 4, 20);
    $aClean['answer'] = funcVerifyAnswer($_POST['answer'], $_POST['question'], 4, 20);
    $aClean['sex'] = funcVerifySex($_POST['sex']);
    $aClean['avatar'] = funcVerifyAvatar($_POST['avatar']);
    $aClean['email'] = funcVerifyEmail($_POST['email'], 6, 40);
    $aClean['qq'] = funcVerifyQQ($_POST['qq'], 5, 10);
    $aClean['url'] = funcVerifyUrl($_POST['url'], 6, 40);
    //在新增之前，判断用户名是否重复
    $sSqlStatements = "
        SELECT tg_username 
        FROM tg_user 
        WHERE tg_username='{$aClean['username']}' 
        LIMIT 1";
    $sInfomation = '此用户名已被注册，请更换用户名';
    funcJudgeRepeat($sSqlStatements, $sInfomation);
    //新增用户
    //在双引号里，直接放变量是可以的，比如$_username，但如果是数组，必须加上{}，比如{$aClean['username']} 
    $sSqlStatements = "
        INSERT INTO tg_user
            (tg_uniqid, tg_active, tg_username, tg_password, tg_question,
             tg_answer, tg_sex, tg_avatar, tg_email, tg_qq, tg_url,
             tg_reg_time, tg_last_login_time, tg_last_login_ip)
        VALUES
            ('{$aClean['uniqid']}', '{$aClean['active']}', '{$aClean['username']}', '{$aClean['password']}', '{$aClean['question']}',
             '{$aClean['answer']}', '{$aClean['sex']}', '{$aClean['avatar']}', '{$aClean['email']}', '{$aClean['qq']}', '{$aClean['url']}',
             NOW(), NOW(), '{$_SERVER["REMOTE_ADDR"]}')";
    funcSqlQuery($sSqlStatements);
    if(funcAffectRows() == 1){
        //获取刚刚新增的ID
        $aClean['id'] = funcInsertId();
        funcCloseMysql();//关闭数据库
        //funcSessionDestroy();
        //生成XML
        funcSetXml('new.xml', $aClean);
        funcAlertJump('注册成功，跳转至激活页...', 'active.php?active='.$aClean['active']);//跳转到激活页
    }
    else{
        funcCloseMysql();//关闭数据库
        //funcSessionDestroy();
        funcAlertJump('注册失败，跳转至注册页...', 'register.php');//跳转至注册页
    }
} 
else{
    $_SESSION['uniqid'] = $sUniqid = funcSha1Uniqid();
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
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
    <?php 
        require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="register">
        <h2>会员注册</h2>
        <?php if(!empty($aSystem['register'])){?>
        <form method="post" name="register" action="register.php?action=register">
            <input type="hidden" name= "uniqid" value="<?php echo $sUniqid ?>" />
            <dl>
                <dt>请认真填写一下内容</dt>
                <dd>用 户 名：<input type="text" name="username" class="text"/>(*必填，至少两位)</dd>
                <dd>密　　码：<input type="password" name="password" class="text"/>(*必填，至少六位)</dd>
                <dd>确认密码：<input type="password" name="confirm" class="text"/>(*必填，同上)</dd>
                <dd>密码提示：<input type="text" name="question" class="text"/>(*必填，至少两位)</dd>
                <dd>密码回答：<input type="text" name="answer" class="text"/>(*必填，至少两位)</dd>
                <dd>性　　别：<input type="radio" name="sex" value="男" checked="checked"/>男<input type="radio" name="sex" value="女" />女</dd>
                <dd class="avatar"><input type="hidden" name="avatar" value="avatar/m01.gif" /><img src="avatar/m01.gif" alt="头像选择" id="avatarImage" /></dd>
                <dd>电子邮件：<input type="text" name="email" class="text"/>(*必填，激活帐号)</dd>
                <dd>　Q Q 　：<input type="text" name="qq" class="text"/></dd>
                <dd>主页地址：<input type="text" name="url" class="text" value="http://"/></dd>
                <dd>验 证 码：<input type="text" name="captcha" class="text captcha" /><img src="captcha.php" id="captcha" /></dd>
                <dd><input type="submit" class="submit" value="注册" /></dd>
            </dl>
        </form>
        <?php 
            }
            else{
                echo '<h4 style="text-align: center;">本站暂不允许注册</h4>';
            }
        ?>
    </div>
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>