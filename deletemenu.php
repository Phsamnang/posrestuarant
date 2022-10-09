<?php
include "connect_db.php";
$id=$_POST['mid'];

$delet=$conn->prepare("DELETE from tb_menus where menuid=$id");

if($delet->execute()){
    echo "yee";

}else{
    echo "Cannot delete";
}

?>