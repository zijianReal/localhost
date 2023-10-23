<?php
header("content-type:text/html;charset=utf-8");

//session开启
session_start();

include_once "connect.php";
$link = connect();
// $link = mysqli_connect('localhost:3306','root','root','admin');

if (isset($_POST['login'])) {

    //接受$_post用户名和密码
    $account = mysqli_real_escape_string($link,trim($_POST['account']));
    $password = mysqli_real_escape_string($link,trim($_POST['password']));

    $account = filter_input(INPUT_POST, 'account', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = htmlspecialchars($password);

    if (!empty($account) && !empty($password)) {


        // // 使用白名单进行输入用户名和密码验证
        // $whitepattern="/^[a-z\d]*$/i";         // 构造的白名单正则表达式，只允许输入的内容是字符串和数字的组合
        // $blackpattern="/\*|'|\"|#|;|,|or|\^|=|<|>|and/i";
        // // 构造的黑名单正则表达式
        // if(preg_match($blackpattern, $name)){ // preg_match：使用正则表达式对字符串进行正则匹配
        //     die('illegal input! 用户名中包含敏感词汇！');
        // }
        // if(!preg_match($whitepattern, $passwd)){
        //     die('illegal input! 密码中包含敏感词汇！');
        // }

        $sql = $link->prepare("select * from admin where account = ? and password = ?");

        $sql->bind_param("ss", $account,  $password);

        $sql->execute();

        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        $num = count($result);


        if ($num) {
            //设置session
            $_SESSION['account'] = $account;
            $_SESSION['password'] = $password;
            // $_SESSION['islogin'] = 1;

            if (isset($_POST['remember']) == 'yes') {
                setcookie('account', $account, time() + 7 * 24 * 3600);
                setcookie('password', sha1($password), time() + 7 * 24 * 3600);
                //用cookie保存session_id
                setcookie('PHPSESSID', session_id(), time() + 7 * 24 * 3600);
                // setcookie('code',md5($account.md5($password)),time()+7*24*3600);
            } else {
                setcookie('account', '', time() - 999);
                setcookie('code', '', time() - 999);
            }
            header('location:index.php');
        } else {
            echo "<script>alert('用户名或密码错误')</script>";
            require_once "login0.php";
        }
    }
}
?>