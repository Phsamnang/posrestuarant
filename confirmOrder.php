
<?php
include "connect_db.php";
include "showInvoice.php";
$id=$_POST['id'];
$update=$conn->prepare("update tb_saleDetail set status='confirm' where sale_id=$id");
$update->execute();
$invoice=new Invoice();
     $invoice-> showInvoice($id,$conn);

?>