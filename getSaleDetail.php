<?php
include "connect_db.php";
include "showInvoice.php";

$table_id = $_GET['table_id'];
$sale = $conn->prepare("SELECT * from tb_sales where table_id=$table_id and sale_status='unpaid'");
$sale->execute();
$get_sale = $sale->fetch(PDO::FETCH_OBJ);
if ($get_sale) {
    $sale_id = $get_sale->id;
    $invoice=new Invoice();
     $invoice-> showInvoice($sale_id,$conn);
} else {
    echo'<button class="btn btn-info startOrder" id="startOrder">Start Order</button>';
}
