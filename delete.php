<?php 
    include_once "connect.php";
    include_once "config.php";

    $link = connect();

    //接收index.php传过来的Id
    $messageId = $_GET['Id'];

    echo $messageId;

    $delete_message = "delete from message where messageId = '$messageId'";

    $execute_sql = mysqli_query($link, $delete_message);

    if ($execute_sql && mysqli_affected_rows($link) == 1) 
{
    echo "<script>alert('删除成功！');location.href='index.php'</script>";
} else {
    echo "<script>alert('删除失败！');location.href='index.php'</script>";
}

?>