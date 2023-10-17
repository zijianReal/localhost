<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style type="text/css">
    .head {text-align:center;color:#FAA261;}
    .wrap {
        width:600px;
        margin:0px auto;
    }
    .input .content{
        margin-bottom:5px;
        width:594px;
        height:150px;
    }
    .input .submit{float:right;}
    .output {margin-top:5px;background:#CCC;padding:3px;margin-top:20px;}
    .output .user{color:#95F;}
    .output .time{float:right;color:#6C0;}

</style>

</head>
<body>
<h1>留言板</h1><a href='login0.php'>登录</a><br><a href="logout.php">登出</a>
    <!-- <form action="save.php" method="POST">
        <input type="text" name="message" value="">
        <input type="submit" name="" value="提交" >
    </form> -->



    <!--输入板块 -->
    <div class="input">
            <form action="save.php" method="post">
                <textarea name="message"  class="content" autofocus="autofocus" placeholder="请输入留言内容：" ></textarea><br/>
                <input type="submit" class="submit" value="提交留言"/>
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
                //查询总记录数
                $total = mysqli_num_rows(mysqli_query($link, "select * from message"));

                //总页数
                $total_page = ceil($total / $page_size);
        

                $query_message = "select * from  message order by addTime asc  limit $start, $page_size";

                $result = mysqli_query($link, $query_message);

                $message = mysqli_fetch_all($result, MYSQLI_ASSOC);



                foreach($message as $key => $value)
                {
            ?>

                    <div class="output">
                        <span class = 'user'>用户名：<?php 
                        $query_user = "select username from  admin where userId = $value[userId]";
                        $result_user = mysqli_query($link, $query_user);
                        $username = mysqli_fetch_array($result_user)[0]; 
                        echo $value['username']?></span>
                        <span class = 'time'>留言时间：<?php echo $value["addTime"]?></span>
                        <div class = 'content'>
                            <?php echo $value["content"] ?>
                            <a href= "delete.php" >删除</a>
                            <a class="reply">回复</a><a class="sub">提交</a>
                        </div>

                        
                    </div>

                  <!-- // echo "<li>".
                    // // "<p>留言人：". $username."</p>".
                    // "<p>留言人：".$value["username"]."</p>".
                    // "<p  style='line-height: 22px'>留言时间：".$value["addTime"]."</p>".
                    // "<P>留言内容：".$value["content"]."</p>".
                    // "</li>"; -->

                  
            <?php    
                }
            ?>
  



        <tr>
        <td align="center">
         <a href="?page=1">首页</a>
         <a href="?page=<?php echo $page==1 ? 1 : $page - 1 ;?>">上一页</a>
         <a href="?page=<?php echo $page==$total_page ? $total_page : $page + 1 ;?>">下一页</a>
         <a href="?page=<?php echo $total_page?>">尾页</a>
            </td>
        </tr>


                    
    </ol>
</body>
</html>
