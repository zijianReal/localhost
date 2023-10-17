<?php
    session_start();
    include_once "connect.php";
    include_once "config.php";


    //将post中的内容先保存到变量content中
    $content = $_POST;
    
    //提取用户的留言
    $message = $content['message'];
    //测试查看 用户内容是否成功提取出来了
    //var_dump($content["message"]);



    //成功提取内容后，连接数据库

    $link = connect();

    $time = date("Y-m-d H:i:s",time());

    $account = $_SESSION['account'];

    $query_user = "select username from  admin where account = '$account'";
    $result_user = mysqli_query($link, $query_user);
    $username = mysqli_fetch_array($result_user)[0];

    $add_message = "insert into ".TABLE_NAME."(username,addTime,content) values('$username','$time','$message')";
    //`messageid`, `userId`, 'addtimne',`content`,

    var_dump($add_message);
    


    //保存执行sql语句的状态，如果执行失败提示
    $execute_sql = mysqli_query($link, $add_message);

    if($execute_sql===TRUE)
    {
        echo "插入SQL语句执行成功！";
        //留言成功后跳转到首页（刷新页面）
        header("location:index.php");
    }
    else
    {
        exit("SQL语句出错了");
    }
    

?>
