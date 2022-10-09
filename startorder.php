<?php
include "connect_db.php";
session_start();
if ($_SESSION['username'] == null && $_SESSION['userid'] == null) {
    // header("Location:index.php");
}
$tabe_name = $_POST['tab_name'];
$table_id = $_POST['tab_id'];
$usr_id = $_SESSION['userid'];
$usr_name = $_SESSION['username'];
$insert = $conn->prepare("insert into tb_sales(table_id,table_name,user_id,user_name)values(:table_id,:table_name,:user_id,:user_name)");
$insert->bindParam(':table_id', $table_id);
$insert->bindParam('table_name', $tabe_name);
$insert->bindParam('user_id', $usr_id);
$insert->bindParam('user_name', $usr_name);
$insert->execute();
$updatetable = $conn->prepare("update tb_table set status='unabvialable' where id=$table_id");
$updatetable->execute();
