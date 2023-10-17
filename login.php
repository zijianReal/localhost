<?php
    header("content-type:text/html;charset=utf-8");

    //session开启
    session_start();

    include_once "connect.php";
    $link = connect();
    // $link = mysqli_connect('localhost:3306','root','root','admin');
    
    if(isset($_POST['login'])){

        //接受$_post用户名和密码
        $account = trim($_POST['username']);
        $password = trim($_POST['password']);

        $sql = "select * from admin where account = '$account' and password = '$password'";

        $result = mysqli_query($link,$sql);

        $num = mysqli_num_rows($result);


        if($num){
            //设置session
            $_SESSION['account'] = $account;
            $_SESSION['password'] = $password;
            $_SESSION['islogin'] = 1;

            if(isset($_POST['remember'])=='yes'){
                setcookie('account',$account,time()+7*24*3600);
                setcookie('code',md5($account.md5($password)),time()+7*24*3600);
            }else{
                setcookie('account','',time()-999);
                setcookie('code','',time()-999);
            }
            header('location:index.php');

        }else{
            echo "<script>alert('用户名或密码错误')</script>";
            require_once "login0.php";
        }

    }

?>