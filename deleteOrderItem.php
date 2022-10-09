<?php
include "connect_db.php";
include "showInvoice.php";
$id=$_POST['id'];

$delete=$conn->prepare("delete from tb_saleDetail where id=$id");
$menu_p=$conn->prepare("select * from tb_saleDetail where id=$id");
$menu_p->execute();
$rs=$menu_p->fetch(PDO::FETCH_OBJ);
$price=($rs->menu_price * $rs->quantity);
$delete->execute();
$sale_id=$rs->sale_id;
$select_from_sale=$conn->prepare("select * from tb_sales where id=$sale_id");
$select_from_sale->execute();
$sale=$select_from_sale->fetch(PDO::FETCH_OBJ);
$new_price=$sale->total_price;
$new_price=$new_price-$price;
$update=$conn->prepare("update tb_sales set total_price=$new_price where id=$sale_id");
$update->execute();
$invoice=new Invoice();
$invoice->showInvoice($sale_id,$conn);