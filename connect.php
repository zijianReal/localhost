<?php
    //引入配置文件，用于连接数据库
    include_once "config.php";
    
    function connect()
    {

        //与mysql数据库连接
        $link = @mysqli_connect(DB_ADDRESS, ACCOUNT_NAME, PASSWORD, DB_NAME);
   
        //连接错误时提示
        $error = mysqli_connect_error();
        //如果有错误的话，输出提示消息,结束程序

        try{
            $pdo = new PDO('mysql:host=localhost;dbname=message','root','root');

            //设置错误模式，抛出异常
            //PDO::ATTR_ERRMODE 错误模式
            //PDO::ERRMODE_EXCEPTION  抛出异常
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            //
            $pdo->exec('set names utf8');
            echo "数据库连接成功";
        }catch(PDOException $e){
            echo "数据库连接失败：".$e->getMessage();
        }


        return $link;
    }


?>
