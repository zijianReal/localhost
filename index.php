<?php
//开启session
session_start();
header("content-type:text/html;charset=utf-8");
// date_default_timezone_set('PRC');  //设置中国时区北京时间

// if ($_SESSION['islogin'] == 0) {
//     //如果在主页没有成功登录，那么跳转到首页
//     header("location: login.php");
// } else {
//     //如果登陆成功， $_SESSION['login_ok']==1   
//     $_SESSION['islogin'] == 0;
//     //这里再次改为0，是为了解除缓存对域名的影响，防止刷新页面还是能进去，
//     //加上这个，刷新以后必须回到主页重新登录
// }
?>


<!DOCTYPE html>
<html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>

     <style type="text/css">
        .head {
            text-align: center;
            color: #FAA261;
        }

        .wrap {
            width: 600px;
            margin: 0px auto;
        }

        .input .content {
            margin-bottom: 5px;
            width: 594px;
            height: 150px;
        }

        .input .submit {
            float: right;
        }

        .output {
            margin-top: 5px;
            background: #CCC;
            padding: 3px;
            margin-top: 20px;
        }

        .output .user {
            color: #95F;
        }

        .output .time {
            float: right;
            color: #6C0;
        }
     </style>

    </head>
    <body>
    <h1>留言板</h1><a href='login0.php'>登录</a><br><a href="logout.php">登出</a>
    <?php
    //头像显示

    if (isset($account)) {
        $account = $_SESSION['account'];
        $sql = "select icon from admin where account = '$account'";
        $result = mysqli_fetch_assoc($link, $sql);
        echo "<br />";
        echo "您的头像是<br /><img src = '" . $result['icon'] . "' width ='100px'>";
        echo "&nbsp;&nbsp;&nbsp;";
        echo "<br /><h3><a href = 'upimg.php'  ><span style = 'color:blue';>修改头像</span></a></h3>";
    }
    ?>


    <!--输入板块 -->
    <div class="input">
        <form action="save.php" method="post">
            <!-- php 中实时监控textarea输入字数 并在textarea里右下角显示剩余数字-->
            <script type="text/javascript">
                //实时监控textarea输入字数
                function textCounter(textarea, countdown, maxlimit) {
                    //#TODO添加延时器，通过flag的值判断输入的状态，解决输入中文时，输入的字数不准确的问题

                    if (textarea.value.length > maxlimit)
                        //如果输入的字数超过了限制，就把超过的部分截取掉
                        textarea.value = textarea.value.substring(0, maxlimit);
                    else
                        //countdown是textarea下面的span标签
                        countdown.value = maxlimit - textarea.value.length;

                }
            </script>
            <textarea name="message" class="content" autofocus="autofocus" placeholder="请输入留言内容：" onkeyup="textCounter(this, this.form.counter, 5);" onkeydown="textCounter(this, this.form.counter, 5);"></textarea><br />
            <input readonly type="text" name="counter" size="3" maxlength="3" value="5" style="border: none; background-color: transparent; text-align: center; color: #ccc; font-size: 12px; font-family: Arial, sans-serif;">
            <!-- <textarea  name="message"  class="content" autofocus="autofocus" placeholder="请输入留言内容："  maxlength="400"></textarea><br/> -->
            <input type="submit" class="submit" value="提交留言" />
        </form>
    </div>
    <!--输出板块-->




    <ol>
        <?php
        include_once "connect.php";
        $link = connect();


        //分页
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        //定义每页显示的记录数
        $page_size = 10;

        $start = ($page - 1) * $page_size;

        //查询所有留言中parentId为0的留言

        $total = mysqli_num_rows(mysqli_query($link, "select * from message where parentId = 0"));

        //总页数
        $total_page = ceil($total / $page_size);

        //使用参数绑定和预处理语句执行sql语句   ？表示占位符
        $query_message = $link->prepare("select * from  message where parentId = 0 order by createTime asc  limit ?, ?");

        //绑定参数    ii表示两个参数都是整数
        $query_message->bind_param("ii", $start, $page_size);

        $query_message->execute();

        //获取结果集
        $result = $query_message->get_result()->fetch_all(MYSQLI_ASSOC);

        // $query_message = "select * from  message order by createTime asc  limit $start, $page_size";

        // $result = mysqli_query($link, $query_message);

        // $message = mysqli_fetch_all($result, MYSQLI_ASSOC);



        foreach ($result as $key => $value) {
        ?>

            <div class="output">
                <span><?php echo $value["messageId"] ?>楼</span>
                <span class='user'>用户名：
                    <?php
                    $query_user = "select username from admin where userId = $value[userId]";
                    $result_user = mysqli_query($link, $query_user);
                    $username = mysqli_fetch_array($result_user)[0];
                    echo $username;
                    ?>
                </span>
                <span class='time'>留言时间：<?php echo $value["createTime"] ?></span>
                <div class='content'>
                    <?php
                    echo $value["content"];
                    showDeleteButton($value["messageId"]);
                    ?>
                    <!-- Id传输messageId给delete.php -->
                    <!-- 给删除按钮添加判断，判断用户是否有相应的权限，如果有权限，就显示删除按钮，否则不显示-->
                    

                    <a href="delete.php?Id=<?php echo $value["messageId"] ?>" >删除</a>


                    <button onclick="showTextBox()">回复</button>
                    <div id="textbox" style="display:none;">
                        <form action='reply.php' method='post'>
                            @<?php echo $username ?>回复：
                            <input type="hidden" name="parentId" value="<?php echo $value["messageId"] ?>">
                            <input type="text" name="text" id="reply" cols="30" rows="10" placeholder="输入文字">
                            <input type="submit" value="提交" class="sub">
                        </form>
                    </div>

                </div>

            </div>


        <?php
        }
        ?>


        <tr>
            <a href="?page=1">首页</a>
            <a href="?page=<?php echo $page == 1 ? 1 : $page - 1; ?>">上一页</a>
            <a href="?page=<?php echo $page == $total_page ? $total_page : $page + 1; ?>">下一页</a>
            <a href="?page=<?php echo $total_page ?>">尾页</a>
            </td>
        </tr>



    </ol>


</body>



</html>


<script>
    function showTextBox() {
        var textbox = document.getElementById("textbox");
        textbox.style.display = "block";
    }
</script>

<?php 
    function showDeleteButton($value){
        $link = connect();
        $sql = "select description from user_role where userId = '$_SESSION[userId]'";
        $result = mysqli_query($link,$sql);
        //提取$result中的description字段
        $description = mysqli_fetch_array($result)[0];
        $delete = in_array("2",$description);
        //如果含有权限删除字段，就显示删除按钮
        if(!$delete){
            echo "<a href='delete.php?Id=$value[messageId]'>删除</a>";
        }
    }
?>

<?php
    $link = connect();
    $sql  = "select * from message where parentId=0";
    $result = mysqli_query($link, $sql);

    function showComments($parent_id, $level) {
        $link = connect();
        $sql = "SELECT * FROM message WHERE parentId=$parent_id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div style="margin-left: ' . ($level * 20) . 'px;">';
          echo '<p>' . $row['content'] . '</p>';
          echo '<small>' . $row['createTime'] . '</small>';
          echo '<a href="#" onclick="showReplyForm(' . $row['messageId'] . ')">回复</a>';
          echo '<div id="reply-form-' . $row['messageId'] . '" style="display: none;">';
          echo '<form method="post" action="#">';
          echo '<input type="hidden" name="parentId" value="' . $row['messageId'] . '">';
          echo '<input type="text" name="content">';
          echo '<input type="submit" value="提交">';
          echo '</form>';
          echo '</div>';
          showComments($row['messageId'], $level + 1);
          echo '</div>';
        }
      }


      // 显示评论列表
    while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="output">';
    echo '<p>' . $row['content'] . '</p>';
    echo '<small>' . $row['createTime'] . '</small>';
    echo '<a href="#" onclick="showReplyForm(' . $row['messageId'] . ')">回复</a>';
    echo '<div id="reply-form-' . $row['messageId'] . '" style="display: none;">';
    echo '<form method="post" action="#">';
    echo '<input type="hidden" name="parent_id" value="' . $row['messageId'] . '">';
    echo '<input type="text" name="content">';
    echo '<input type="submit" value="提交">';
    echo '</form>';
    echo '</div>';
    showComments($row['messageId'], 1);
    echo '</div>';
  }
?>