<?php
    
    session_start();
    include_once "connect.php";
    include_once "config.php";


    $content = $_POST;   
 
    $messageId = $content['parentId'];

    $message = $content['text'];


    //成功提取内容后，连接数据库

    $link = connect();

    $time = date("Y-m-d H:i:s",time());

    $account = $_SESSION['account'];

    $query_userId = "select userId from  admin where account = '$account'";
    $result_userId = mysqli_query($link, $query_userId);
    $userId = mysqli_fetch_array($result_user)[0];


    $query_username = "select username from  admin where account = '$account'";
    $result_username = mysqli_query($link, $query_username);
    $username = mysqli_fetch_array($result_user)[0];



    $add_message = "insert into ".TABLE_NAME."(userId,createTime,content,parentId) values('$userId','$time','$message','$messageId')";
    //`messageid`, `userId`, 'addtimne',`content`,'parentId','status'

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

