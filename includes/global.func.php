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
/**
 * funcRunTime()是用来获取执行耗时
 * @access public 表示函数对外公开
 * @return float 表示返回出来的是一个浮点型数字
 */
function funcRunTime(){
    $fTimePoint = explode(' ',microtime());//microtime得出的两个参数，第一个为微秒数，第二个为时间戳
    return $fTimePoint[1] + $fTimePoint[0];
}
/**
 * funcAlertReturn()是弹出错误信息函数，并回退
 * @access public 表示函数对外公开
 * @param $sInfo
 * @return void
 */
function funcAlertReturn($sInfo){
    echo "<script type='text/javascript'>alert('$sInfo');history.back();</script>";
    exit();
}
/**
 * funcAlertClose()是弹出错误信息函数，并关闭当前窗口
 * @access public 表示函数对外公开
 * @param $sInfo
 * @return void
 */
function funcAlertClose($sInfo){
    echo "<script type='text/javascript'>alert('$sInfo');window.close();</script>";
    exit();
}
/**
 * funcAlertReturn()是弹出错误信息函数，并回退
 * @access public 表示函数对外公开
 * @param $sInfo
 * @return void
 */
function funcAlertJump($sInfo, $sUrl){
    if(!empty($sInfo)){
        echo "<script type='text/javascript'>alert('".$sInfo."');location.href='$sUrl';</script>";
        exit();
    }
    else{
        header('Location:'.$sUrl);
    }
}
/**
 * funcLoginState函数判断登录状态
 * @access public
 * @return void
 */
function funcLoginState(){
    if(isset($_COOKIE['username'])){
        funcAlertReturn('登录状态无法进行本操作');
    }
}
/**
 * funcSessionDestroy销毁会话
 * @access public
 * @return boolean
 */
function funcSessionDestroy(){
    if(session_start()){
        session_destroy();
    }
}
/**
 * funcDeleteCookies函数删除cookies
 * @access public
 * @return void
 */
function funcDeleteCookies(){
    setcookie('username', '', time() - 1);
    setcookie('uniqid', '', time() - 1);
    funcSessionDestroy();
    funcAlertJump(null, 'index.php');
}
/**
 * funcSha1Uniqid函数产生唯一标示符
 * @access public
 * @return string 返回唯一标识标示符字符串40位
 */
function funcSha1Uniqid(){
    return sha1(uniqid(rand(), true));
}
/**
 * funcVerifyCaptcha函数判定验证码是否匹配
 * @access public
 * @param string $sInputCaptcha
 * @param string $sCaptcha
 */
function funcVerifyCaptcha($sInputCaptcha, $sCaptcha){
    if($sInputCaptcha != $sCaptcha){
        funcAlertReturn('验证码不正确！');
    }
}
/**
 * funcCaptcha()是验证码产生函数
 * @access public 表示函数对外公开
 * @param int $iWidth表示验证码的宽度
 * @param int $iHeight表示验证码的高度
 * @param int $iNumCaptcha表示验证码的位数
 * @param bool $bFlag表示验证码是否需要边框
 * @return void 函数无返回值
 */
function funcCaptcha($iWidth=75, $iHeight=25, $iNumCaptcha=4, $bFlag=false){// 图片宽,高，随机码的个数
    // 随机验证码产生
    for($i=0; $i<$iNumCaptcha; $i++) {
        $sCaptcha .= dechex(mt_rand(0, 15));
    }
    // 保存在$_SESSION全局变量里，可以传递
    $_SESSION['captcha'] = $sCaptcha;
    // echo $_SESSION['captcha'];
    // 创建一张图像
    $rImage = imagecreatetruecolor($iWidth, $iHeight);
    // 输出白色
    $rWhite = imagecolorallocate($rImage, 255, 255, 255);
    // 填充背景
    imagefill($rImage, 0, 0, $rWhite);
    //判定是否需要边框
    if($bFlag){
        // 创建黑色,边框
        $rBlack = imagecolorallocate($rImage, 0, 0, 0);
        imagerectangle($rImage, 0, 0, $iWidth-1, $iHeight-1, $rBlack);
    }
    // 随机画出6个线条
    for($i=0; $i<6; $i++){
        $rRandColor = imagecolorallocate($rImage, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imageline($rImage, mt_rand(0, $iWidth), mt_rand(0, $iHeight), mt_rand(0, $iWidth), mt_rand(0, $iHeight), $rRandColor);
    }
    // 随机雪花
    for($i = 0; $i < 50; $i ++){
        $rRandColor = imagecolorallocate($rImage, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagestring($rImage, 1, mt_rand(1, $iWidth), mt_rand(1, $iHeight), '*', $rRandColor);
    }
    // 输出验证码
    for($i=0; $i<strlen($_SESSION['captcha']); $i++){
        $rRandColor = imagecolorallocate($rImage, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
        $iPostionX = $i * $iWidth / $iNumCaptcha + mt_rand(1, 10);
        $iPostionY = mt_rand(1, $iHeight / 2);
        imagestring($rImage, mt_rand(3, 5), $iPostionX, $iPostionY, $_SESSION['captcha'][$i], $rRandColor);
    }
    // 输出图像
    header("Content-type:image/png");
    imagepng($rImage);
    // 销毁
    imagedestroy($rImage);
}
/**
 * funcPagingParameters分页函数的参数设置及验证
 * @access public
 * @param string $sSql SQL语句，用来得到结果集的总条数
 * @param int $iSize 用户设定的每页显示数量，参数传入给$iPageSize
 * @return void
 */
function funcPagingParameters($sSql, $iSize){//$iPageSize每页显示数量
    global $iPageNum, $iPageSize, $iTotalPage, $iPage, $iNumber;
    if(isset($_GET['page'])){//容错处理
        $iPage = $_GET['page'];
        if(empty($iPage) || $iPage <= 0 || !is_numeric($iPage)){
            $iPage = 1;
        }
        else{
            $iPage = intval($iPage);//取整操作
        }
    }
    else{
        $iPage = 1;
    }
    $iPageSize = $iSize;
    $iNumber = funcNumRows(funcSqlQuery($sSql));
    //首页要得到所有的数据总和
    if($iNumber == 0){
        $iTotalPage = 1;
    }
    else{
        $iTotalPage = ceil($iNumber / $iPageSize);
    }
    if($iPage > $iTotalPage){
        $iPage = $iTotalPage;
    }
    $iPageNum = ($iPage - 1) * $iPageSize;//每页开始显示的第一个数据
}
/**
 * funcPaging函数进行分页处理，若$bType为真，则为文本分页，否则为数字分页
 * @access public
 * @param boolean $bType
 * @return void
 */
function funcPaging($bType=false){
    global $iTotalPage, $iPage, $iNumber, $iGlobalId;
    if(!$bType){//数字分页
        echo '<div id="pageNumber">';
        echo '<ul>';
        for($i=0; $i < $iTotalPage; $i++){
            if($iPage == ($i+1)) {
                echo '<li><a href="'.THISPAGENAME.'.php?'.$iGlobalId.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
            }
            else{
                echo '<li><a href="'.THISPAGENAME.'.php?'.$iGlobalId.'page='.($i+1).'">'.($i+1).'</a></li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    }
    else{//文本分页
        echo '<div id="pageText">';
        echo '<ul>';
        echo '<li>'.$iPage.'/'.$iTotalPage.'页</li>';
        echo '<li><strong>'.$iNumber.'</strong>个数据</li>';
        if($iPage == 1){
            echo '<li>首页 | </li>';
            echo '<li>上一页 | </li>';
        }
        else{
            echo '<li><a href="'.THISPAGENAME.'.php">首页</a> | </li>';
            echo '<li><a href="'.THISPAGENAME.'.php?'.$iGlobalId.'page='.($iPage - 1).'">上一页</a> | </li>';
        }
        if($iPage == $iTotalPage){
            echo '<li>下一页 | </li>';
            echo '<li>尾页 </li>';
        }
        else{
            echo '<li><a href="'.THISPAGENAME.'.php?'.$iGlobalId.'page='.($iPage + 1).'">下一页</a> | </li>';
            echo '<li><a href="'.THISPAGENAME.'.php?'.$iGlobalId.'page='.$iTotalPage.'">尾页</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}
/**
 * funcConvertHtml函数将传入变量中的特殊HTML标记转换成可识别模式
 * @access public
 * @param string|array $var
 * @return string|array
 */
function funcConvertHtml($var){
    if(is_array($var)){
        foreach($var as $key => $value){
            $var[$key] = funcConvertHtml($value);//采用递归处理，也可以将此处的函数直接改为htmlspecialchars
        }
    }
    else{
         $var = htmlspecialchars($var);
    } 
    return $var;
}
/**
 * funcMysqlString函数对传入数据的字符串进行转义处理
 * @access public
 * @param var $vString
 * @return var
 */
function funcMysqlString($vString){
    //get_magic_quotes_gpc状态为1，表示自动开启了上交表单转义，为0则没开启
    if(GPC){
        return $vString;
    }
    else{
        if(is_array($vString)){
            foreach($vString as $key => $value){
                $var[$key] = funcMysqlString($value);//采用递归处理，也可以将此处的函数直接改为addslashes
            }
        }
        else{
            //return mysql_real_escape_string($vString);
            $vString = addslashes($vString);
        }
       
    }
    return $vString;
}
/**
 * funcSummary函数返回字符串$sString的摘要模式，仅显示其前14个字节的内荣
 * @access public
 * @param string $sString
 * @return string
 */
function funcSummary($sString, $iNumber=14){
    if(mb_strlen($sString, 'utf-8') > $iNumber){
        $sString = mb_substr($sString, 0, $iNumber, 'utf-8');
    }
    return $sString;
}
/**
 * funcSetXml函数生成XML表
 * @access public
 * @param resource $rXmlFile
 * @param array $aClean
 */
function funcSetXml($rXmlFile, $aClean){
    $rFopen = @fopen('new.xml','w');
    if(!$rFopen){
        exit('系统错误，文件不存在！');
    }
    flock($rFopen,LOCK_EX);

    $sString = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
    fwrite($rFopen,$sString,strlen($sString));
    $sString = "<vip>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "\t<id>{$aClean['id']}</id>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "\t<username>{$aClean['username']}</username>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "\t<sex>{$aClean['sex']}</sex>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "\t<face>{$aClean['avatar']}</face>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "\t<email>{$aClean['email']}</email>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "\t<url>{$aClean['url']}</url>\r\n";
    fwrite($rFopen, $sString, strlen($sString));
    $sString = "</vip>";
    fwrite($rFopen, $sString, strlen($sString));

    flock($rFopen, LOCK_UN);
    fclose($rFopen);
}
/**
 * funcGetXml函数获取XML表
 * @access public
 * @param resource $rXmlFile
 * @param array $aClean
 */
function funcGetXml($rXmlFile){
    $aWebPageData = array();
    if (file_exists($rXmlFile)) {
        $sXml = file_get_contents($rXmlFile);
        preg_match_all('/<vip>(.*)<\/vip>/s',$sXml,$aDom);
        foreach ($aDom[1] as $sValue) {
            preg_match_all('/<id>(.*)<\/id>/s',$sValue,$aId);
            preg_match_all('/<username>(.*)<\/username>/s',$sValue,$aUsername);
            preg_match_all( '/<sex>(.*)<\/sex>/s', $sValue, $aSex);
            preg_match_all( '/<face>(.*)<\/face>/s', $sValue, $aAvatar);
            preg_match_all( '/<email>(.*)<\/email>/s', $sValue, $aEmail);
            preg_match_all( '/<url>(.*)<\/url>/s', $sValue, $aUrl);
            $aWebPageData['id'] = $aId[1][0];
            $aWebPageData['username'] = $aUsername[1][0];
            $aWebPageData['sex'] = $aSex[1][0];
            $aWebPageData['avatar'] = $aAvatar[1][0];
            $aWebPageData['email'] = $aEmail[1][0];
            $aWebPageData['url'] = $aUrl[1][0];
        }
    } 
    else{
        echo '文件不存在';
    }
    return $aWebPageData;
}
/**
 * funcConvertUbb函数将UBB格式转换成HTML格式
 * @access public
 * @param mixed $sString
 * @return mixed
 */
function funcConvertUbb($sString){
    $sString = nl2br($sString);
    $sString = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$sString);
    $sString = preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$sString);
    $sString = preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$sString);
    $sString = preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$sString);
    $sString = preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$sString);
    $sString = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$sString);
    $sString = preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$sString);
    $sString = preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1">\1</a>',$sString);
    $sString = preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片" />',$sString);
    $sString = preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px;" src="\1" />',$sString);
    return $sString;
}
/**
 * funcExpiredTime检测间隔时间是否足够
 * @access public
 * @param time $iNowTime
 * @param time $iPreTime
 * @param time $iSecond
 */
function funcExpiredTime($iNowTime, $iPreTime, $iSecond){
    if($iNowTime - $iPreTime < $iSecond){
        funcAlertReturn('发帖时间间隔太短');
    }
}
/**
 * funcManageLogin管理员登录函数
 * @access public
 * @return void
 */
function funcManageLogin(){
    if((!isset($_COOKIE['username'])) || (!isset($_SESSION['admin']))){
        funcAlertReturn('非法登录！');
    }
}
/**
 * funcThumb函数将大图转换成对应比例的小图
 * @access public
 * @param resource $sFilename
 * @param float $fPercent
 */
function funcThumb($sFilename,$fPercent){
    //生成png标头文件
    header('Content-type: image/png');
    $sName = explode('.',$sFilename);
    //获取文件信息，长和高 
    list($iWidth, $iHeight) = getimagesize($sFilename);
    //生成缩微的长和高
    $sNewWidth = $iWidth * $fPercent;
    $sNewHeight = $iHeight * $fPercent;
    //创建一个以0.3百分比新长度的画布
    $rNewImage = imagecreatetruecolor($sNewWidth, $sNewHeight);
    //按照已有的图片创建一个画布
    switch($sName[1]){
        case 'jpg' : $rImage = imagecreatefromjpeg($sFilename); break;
        case 'png' : $rImage = imagecreatefrompng($sFilename); break;
        case 'gif' : $rImage = imagecreatefrompng($sFilename); break;
    }
    //将原图采集后重新复制到新图上，就缩略了
    imagecopyresampled($rNewImage, $rImage, 0, 0, 0, 0, $sNewWidth, $sNewHeight, $iWidth, $iHeight);
    imagepng($rNewImage);
    imagedestroy($rNewImage);
    imagedestroy($rImage);
}
/**
 * funcRemoveDir迭代的删除目录，若非空则将内部的删除后再删除该目录
 * @param file $dirName
 * @return boolean|bool
 */
function funcRemoveDir($dirName)
{
    if(!is_dir($dirName)){
        return false;
    }
    $handle = @opendir($dirName);
    while(($file = @readdir($handle)) !== false){
        if($file != '.' && $file != '..'){
            $dir = $dirName . '/' . $file;
            is_dir($dir) ? funcRemoveDir($dir) : @unlink($dir);
        }
    }
    closedir($handle);
    return rmdir($dirName) ;
}
?>
