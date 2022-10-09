<?php
include "connect_db.php";
session_start();
if ($_SESSION['username'] == null) {
    header("Location:index.php");
}
include_once "header.php";
if (isset($_POST['btnSave'])) {
    $category = $_POST['category'];
    if (empty($category)) {
        $error = '<script>
        jQuery(document).ready(function($) {
           alert("Empty");
            });
        </script>';
        echo $error;
    } else {
        $insert = $conn->prepare("INSERT INTO tb_category(category)values(:category)");
        $insert->bindParam(':category', $category);
        if ($insert->execute()) {
            echo '<script>
            jQuery(document).ready(function($) {
               alert("success");
                });
            </script>';
            header("lcoation:category.php");
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
    $update = $conn->prepare("UPDATE tb_category SET category=:category WHERE cateid=" . $id);
    $update->bindParam(':category', $value);
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
                    <h1 class="m-0">Category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                    <h3 class="card-title">Category</h3>
                </div>
                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-md-4">
                            <form action="category.php" method="post">
                                <?php
                                if (isset($_POST['edit'])) {
                                    $value = $_POST['edit'];
                                    $select = $conn->prepare("SELECT * FROM tb_category WHERE cateid=" . $value);
                                    $select->execute();
                                    if ($select) {
                                        $row = $select->fetch(PDO::FETCH_OBJ);
                                        echo ' <div class="form-group">
                                        <label for="inputEmail3" class=" col-form-label">Category</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="inputEmail3" placeholder="Category" name="editcategory" value="' . $row->category . '">
                                        </div>
                                    </div>
    
                                    <button type="submit" class="btn btn-info" name="btnUpdate" value="' . $row->cateid . '">Update</button>';
                                    }
                                } else {
                                    echo ' <div class="form-group">
                                    <label for="inputEmail3" class=" col-form-label">Category</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="Category" name="category">
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-info" value="Save" name="btnSave">';
                                }
                                ?>
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $select = $conn->prepare("SELECT * FROM tb_category");
                                    $select->execute();
                                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                        echo '<tr>
    <td>' . $row->category . '</td>
    <td> <button type="submit" class="btn btn-success" name="edit" value=' . $row->cateid . '>Edit</button></td>   
    <td> <button type="submit" class="btn btn-danger" name="delete" value=' . $row->cateid . '>Delete</button></td> 
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
<?php

include_once "footer.php";

?>