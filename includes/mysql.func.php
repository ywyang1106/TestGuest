<?php
/**
 * TestGuest Version1.0
 * ================================================
 * Copy 2010-2015 ywyang
 * Email: y.w.yang@163.com
 * ================================================
 * Author: ywyang
 * Date: 2015年5月31日
*/
//防止恶意调用
if(!defined('ERRORCALL')){
    exit('Access Deny!');
}
// //设置字符集编码
// header('Content-Type:text/html;charset=utf-8');
/**
 * funcConnectMysql函数连接MySQL数据库
 * @access public
 * @return void
 */
function funcConnectMysql(){
    global $rConnectMysql;//表示全局变量，非超级全局变量，可在函数外部被访问
    if( !($rConnectMysql = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))){
        exit('数据库连接失败');
    }
}
/**
 * funcSelectDb函数选择数据库
 * @access public
 * @return void
 */
function funcSelectDb(){
    if( !(mysql_select_db(DB_NAME))){
        exit('找不到指定的数据库');
    }
} 
/**
 * funcSetCoding设置字符集
 * @access public
 * @return void
 */
function funcSetCoding(){
    if( !(mysql_query('SET NAMES UTF8'))){
        exit('字符集错误');
    }
}
/**
 * funcSqlQuery函数执行SQL语句，并返回资源句柄
 * @access public
 * @return resource
 */
function funcSqlQuery($sSqlStatements){
    if( !$rQuery = mysql_query($sSqlStatements)){
        exit('SQL语句执行错误'.mysql_error());
    }
    return $rQuery;
}
/**
 * funcFetchArray函数执行SQL语句并将对应的结果提取出来变为数组形式(只获取一条数据组)
 * @access public
 * @return array
 */
function funcFetchArray($sSqlStatements){
    return mysql_fetch_array(funcSqlQuery($sSqlStatements), MYSQL_ASSOC);
}
/**
 * funcFetchArrayList函数执行SQL语句并将对应的结果提取出来变为数组形式(获取所有数据组)
 * @access public
 * @return array
 */
function funcFetchArrayList($rResult){
    return mysql_fetch_array($rResult, MYSQL_ASSOC);
}
/**
 * funcNumberRows表示得到结果集的总条数
 * @access public
 * @return int
 */
function funcNumRows($rResult){
    return mysql_num_rows($rResult);
}
/**
 * funcAffectRows表示影响到的记录条数
 * @access public
 * @return int
 */
function funcAffectRows(){
    return mysql_affected_rows();
}
 /**
  * funcJudgeRepeat函数判断用户名是否重复
  * @access public
  * @param string $sSqlStatements
  * @param string $sInfomation
  * return void | string
  */
function funcJudgeRepeat($sSqlStatements, $sInfomation){
    if(funcFetchArray($sSqlStatements)){
        funcAlertReturn($sInfomation);
    }
}
/**
 * funcCloseMysql函数关闭数据库
 * @access public
 * @return void
 */
function funcCloseMysql(){
    if(!mysql_close()){
        exit('数据库关闭异常');
    }
}
/**
 * funcFreeMysqlResult释放数据库操作得到的结果集所占的内存
 * @access public
 * @param var $vResult
 * @return void
 */
function funcFreeMysqlResult($vResult){
    mysql_free_result($vResult);
}
/**
 * funcInsertId函数获取数据库上一个操作取得的ID
 * @access public
 * @return int
 */
function funcInsertId(){
    return mysql_insert_id();
}
?>
