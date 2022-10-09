<?php
include "connect_db.php";
session_start();
if($_SESSION['username']==null){
    header("Location:index.php");
}
include_once "header.php";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
         <?php

$select=$conn->prepare("SELECT * FROM `tb_saleDetail` RIGHT JOIN tb_menus ON tb_saleDetail.menu_id=tb_menus.menuid LEFT JOIN tb_sales ON tb_saleDetail.sale_id=tb_sales.id WHERE isCooked='Cook' AND status ='noComfirm' ");
$select->execute();
echo '<table class="table">
    <thead>
        <tr>
            <td>
                ម្ហូប
            </td>
            <td>
                ចំនួន
            </td>
            <td>
                ខ្យុស
            </td>
            <td>
                action
            </td>
        </tr>
    </thead>
    <tbody>';
        while($row=$select->fetch(PDO::FETCH_OBJ)){
        echo '

        <tr>
            <td>'.$row->name.'</td>
            <td>'.$row->quantity.'</td>
            <td>'.$row->table_name.'</td>
            <td><button>ចាប់ចម្អិន</button></td>
        </tr>';

        }
        echo '
    </tbody>
</table>';
?>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<script>
setInterval(function(){ location.reload(true); },5000);
</script>

<?php
include_once "footer.php";

?>