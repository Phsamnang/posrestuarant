<?php
include "connect_db.php";
session_start();
if ($_SESSION['username'] == null) {
    header("Location:index.php");
}
include_once "header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">List Menus</h1>
                    <a href="addmenu.php" class="btn btn-info">Back</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <table class="table table-striped" id="productlist">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select = $conn->prepare("SELECT * FROM tb_menus left join tb_category on tb_menus.cateid=tb_category.cateid");
                    $select->execute();
                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                        echo '<tr>
    <td>' . $row->name . '</td>
    <td>' . $row->category . '</td>
    <td>' . $row->price . '</td>
    <td><img src="upload/' . $row->image . '" alt="" class="img-fluid mb-3" style="width: 50px;height:50"></td>
    <td> <a class="btn btn-success" href="editmenus.php?id=' . $row->menuid . '">Edit</a></td>   
    <td> <button class="btn btn-danger btndelete" id=' . $row->menuid . '>Delete</button></td> 
    </tr>';
                    }
                    ?>


                </tbody>
            </table>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        $('#productlist').DataTable({
            "order": [0, "desc"]
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.btndelete').click(function() {
            var id = $(this).attr("id");
            var tdh = $(this);
            if (confirm("Do you want delete it?")) {
                $.ajax({
                    url: 'deletemenu.php',
                    type: 'post',
                    data: {
                        mid: id
                    },
                    success: function() {
                        tdh.parents('tr').hide();
                    }
                })
            } else {
                return false;
            }

        });
    });
</script>
<!-- Control Sidebar -->
<?php
include_once "footer.php";
?>