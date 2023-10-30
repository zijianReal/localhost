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
	$createTime = date("Y-m-d H:i:s",time());



	//过滤用户名和密码
	$username=htmlspecialchars($username);
	$password=htmlspecialchars($password);
	$account=htmlspecialchars($account);
	$phone=htmlspecialchars($phone);
	$email = filter_var(filter_var($email,FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);//使用php原生过滤器先删除非email字符，后验证


//上传头像处理
//限制上传.gif 或 .jpeg 类型图片并小于 200 kb



	
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
	}else if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 200000)) {
	if ($_FILES["file"]["error"] > 0) {
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	} else {
	move_uploaded_file($_FILES["file"]["tmp_name"],
		"D:\\phpEnv\www\localhost\icon/" . $_FILES["file"]["name"]);
	
	$icon_tem = "image/" . $_FILES["file"]["name"];
	$icon_arr = array("$icon_tem");
	$icon = implode($icon_arr);
	 }
    }else{
			$sql="insert into admin(username,account,password,,phone,email,icon,createTime) values('$username','$account','$password','$phone','$email','$icon','$createTime')";
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
