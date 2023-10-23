<?php 
	header('Content-type:text/html; charset=utf-8');
	// 注销后的操作
	session_start();
	// 清除Session
    $account = $_SESSION['account'];

	$_SESSION = array();
	session_destroy();
 
	// 清除Cookie
	setcookie('account', '', time()-99);
	setcookie('code', '', time()-99);
 
	// 提示信息
	echo "帐号".$account.'已经登出<br>';
	echo "<a href='login0.php'>重新登录</a>";
 
 ?>