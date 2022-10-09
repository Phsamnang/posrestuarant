<?php
include "connect_db.php";
session_start();
if ($_SESSION['username'] == null) {
    header("Location:index.php");
}
include_once "header.php";
if (isset($_POST['btnSave'])) {
    $name = $_POST['table'];
    if (empty($name)) {
        $error = '<script>
        jQuery(document).ready(function($) {
           alert("Empty");
            });
        </script>';
        echo $error;
    } else {
        $insert = $conn->prepare("INSERT INTO tb_table(name)values(:name)");
        $insert->bindParam(':name', $name);
        if ($insert->execute()) {
            header("refresh1:table.php");
        } else {
            echo '<script>
            jQuery(document).ready(function($) {
               alert("fail");
                });
            </script>';
        }
    }
}
if (isset($_POST['btnUpdate'])) {
    $id = $_POST['btnUpdate'];
    $value = $_POST['editcategory'];
    $update = $conn->prepare("UPDATE tb_table SET name=:name WHERE id=" . $id);
    $update->bindParam(':name', $value);
    if ($update->execute()) {
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Table</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Table</h3>
                </div>
                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-md-4">
                            <form action="" method="post">
                                <?php
                                if (isset($_POST['edit'])) {
                                    $value = $_POST['edit'];
                                    $select = $conn->prepare("SELECT * FROM tb_table WHERE id=" . $value);
                                    $select->execute();
                                    if ($select) {
                                        $row = $select->fetch(PDO::FETCH_OBJ);
                                        echo ' <div class="form-group">
                                        <label for="inputEmail3" class=" col-form-label">Category</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="inputEmail3" placeholder="Category" name="editcategory" value="' . $row->name . '">
                                        </div>
                                    </div>
    
                                    <button type="submit" class="btn btn-info" name="btnUpdate" value="' . $row->id . '">Update</button>';
                                    }
                                } else {
                                    echo ' <div class="form-group">
                                    <label for="inputEmail3" class=" col-form-label">Category</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="Category" name="table">
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-info" value="Save" name="btnSave">';
                                }
                                ?>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>table</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $select = $conn->prepare("SELECT * FROM tb_table");
                                    $select->execute();
                                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                        echo '<tr>
    <td>' . $row->name . '</td>
    <td>' . $row->status . '</td>
    <td> <button type="submit" class="btn btn-success" name="edit" value=' . $row->id . '>Edit</button></td>   
    <td> <button type="submit" class="btn btn-danger" name="delete" value=' . $row->id . '>Delete</button></td> 
    </tr>';
                                    }
                                    ?>



                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<script>
</script>
<?php

include_once "footer.php";

?>