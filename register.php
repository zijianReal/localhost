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
	$email=$_POST['email'];
	


	
	
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