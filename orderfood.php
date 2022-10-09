<?php
include "connect_db.php";
include "showInvoice.php";
session_start();
if ($_SESSION['username'] == null && $_SESSION['userid'] == null) {
    // header("Location:index.php");
}
//include_once "header.php";
$id = $_POST['menuid'];
$tabe_name = $_POST['tablename'];
$table_id = $_POST['tableid'];
$qty = $_POST['quantity'];
$usr_id = $_SESSION['userid'];
$usr_name = $_SESSION['username'];

$sale = $conn->prepare("select * from tb_sales where table_id=$table_id and sale_status='unpaid'");
$sale->execute();
$objsale = $sale->fetch(PDO::FETCH_OBJ);
$menu = $conn->prepare("select * from tb_menus where menuid=$id");
$menu->execute();
$rs = $menu->fetch(PDO::FETCH_OBJ);
if (!$objsale) {
   
} else {
    $sale_id = $objsale->id;
}
date_default_timezone_set('Asia/Phnom_Penh');

$date = date("Y-m-d H:i:s");
$saledetail = $conn->prepare("insert into tb_saleDetail(sale_id,menu_id,menu_name,menu_price,quantity,datetime)values(:sale_id,:menu_id,:menu_name,:menu_price,:quantity,:datetime)");
$menu_id = $rs->menuid;
$menu_name = $rs->name;
$menu_price = $rs->price;
$saledetail->bindParam(':sale_id', $sale_id);
$saledetail->bindParam(':menu_id', $menu_id);
$saledetail->bindParam(':menu_name', $menu_name);
$saledetail->bindParam(':menu_price', $menu_price);
$saledetail->bindParam(':quantity', $qty);
$saledetail->bindParam(':datetime', $date);
$saledetail->execute();

$total_price = $objsale->total_price;

$total_price = $total_price + ($qty * $menu_price);

$saleupdate = $conn->prepare("update tb_sales set total_price=$total_price where id=$sale_id");
     $saleupdate->execute();
     $invoice=new Invoice();
     $invoice->showInvoice($sale_id,$conn);
