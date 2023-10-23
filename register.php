<?php
	header("content-type:text/html;charset=utf-8");
	//连接数据库

    include_once "connect.php";
    $link = connect();
    // $link = mysqli_connect('localhost:3306','root','root','admin');

	
	//接收$_POST用户名和密码
	
	$username=$_POST['username'];
	$password=$_POST['password'];
    $account=$_POST['account'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];


	//过滤用户名和密码
	$username=htmlspecialchars($username);
	$password=htmlspecialchars($password);
	$account=htmlspecialchars($account);
	$phone=htmlspecialchars($phone);
	$email = filter_var(filter_var($email,FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);//使用php原生过滤器先删除非email字符，后验证


 ////PHP 添加表单验证
 ///https://www.runoob.com/php/php-form-validation.html
 ////合法性判断
 ////https://my.oschina.net/uanaoeng/blog/5297793
 ///https://blog.csdn.net/keepwin100/article/details/84960534
 ///PHP性能优化指南:减少正则表达式的使用
 ///https://www.cainiaoxueyuan.com/bc/16445.html
 ///添加cookie 检验  以及remember me 功能 换个方式

 ///Password Hashing API 对密码加密


	


	
	
	//查看表user用户是否存在或为空
	$sql_select = "select account from admin where account = '$account'";

	$select = mysqli_query($link,$sql_select);
	$num = mysqli_num_rows($select); 
	if($account == "" || $password == "")
	{
		echo "请确认信息完整性";
	}else if($num){
		echo "已存在用户名";
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "邮箱格式不正确";
	}else{
			$sql="insert into admin(username,account,password,email) values('$username','$account','$password','$email')";
			//username ,account,password,email
            $result=mysqli_query($link,$sql);
			//判断是否注册后显示内容
			if(!$result)
			{
				echo "注册不成功！"."<br>";
				echo "<a href='register0.php'>返回</a>";
			}
			else
			{
				echo "注册成功!"."<br/>";
				echo "<a href='login0.php'>立刻登录</a>";
			}
		}
	
?>