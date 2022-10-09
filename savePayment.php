<?php
include "connect_db.php";
include "showInvoice.php";
session_start();
if ($_SESSION['username'] == null && $_SESSION['userid'] == null) {
    // header("Location:index.php");
}
$sale_id=$_POST['sale_id'];
$recieve=$_POST['recieve'];
if($recieve==0){
    $delete=$conn->prepare("delete from tb_sales where id='.$sale_id.'");
    $delete->execute();
}else{
    $select=$conn->prepare('select *from tb_sales where id='.$sale_id.'');
    $select->execute();
    $rs=$select->fetch(PDO::FETCH_OBJ);
    
    $change=$recieve-$rs->total_price;
    $table_id=$rs->table_id;
    $update=$conn->prepare('update tb_sales set total_recieve='.$recieve.',chang='.$change.',sale_status="paid" where id='.$sale_id.'');
    $update->execute();
    
    $updatetable=$conn->prepare('update tb_table set status="avialable" where id='.$table_id.'');
    
    $updatetable->execute();
    
}

