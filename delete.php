<?php 

    include_once "connect.php";
    include_once "index.php";

    $id = $_GET[id];
    $sql = "where * from message where id = ".$id;
    

?>