<?php
include "connect_db.php";
$id = $_POST['mid'];
$select = $conn->prepare("SELECT * from tb_menus where cateid=$id");

$select->execute();

while ($row = $select->fetch(PDO::FETCH_OBJ)) {
    echo '<div class="col-md-3 text-center">
    <div>
        <img src="upload/' . $row->image . '" alt="" class="img-fluid" style="  width: 150px;
        height: 120px;" >
        <br>
        ' . $row->name . '
        <br>
        <span>តម្លៃ ៖</span>' . $row->price . '
        <input type="number" class="qty" size="2"/>
        <button class="btn-menu" data-id="' . $row->menuid . '">order</button>
    </div>
    
</div>
    
    ';
}
?>
