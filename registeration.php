<?php
include "connect_db.php";
session_start();
if($_SESSION['username']==null){
    header("Location:index.php");
}
include_once "header.php";
if (isset($_POST['btnInsert'])) {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    echo $username . $phone . $pwd . $role;
    $insert = $conn->prepare("INSERT INTO tb_user(username,pwd,phone,role)VALUE(:name,:pwd,:phone,:role)");

    $insert->bindParam(':name', $username);
    $insert->bindParam(':pwd', $pwd);
    $insert->bindParam(':phone', $phone);
    $insert->bindParam(':role', $role);
    if ($insert->execute()) {
        echo "Success";
        header("location:registeration.php");
    } else {
        echo "fail";
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Registeration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Registeration</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Registeration</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="row">
                    <div class="col-md-4">
                        <form action="registeration.php" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Username" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pwd">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role">
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>

                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="btnInsert">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Username</td>
                                    <td>Password</td>
                                    <td>Phone</td>
                                    <td>Role</td>
                                </tr>
                            </thead>
                            <?php
                            $select = "SELECT * FROM tb_user ORDER BY userid DESC";
                            $sql = $conn->prepare($select);
                            $sql->execute();
                            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                echo "
            <tr>
            <td>$row->userid</td>
            <td>$row->username</td>
            <td>$row->pwd</td>
            <td>$row->phone</td>
            <td>$row->role</td>
            </tr>
            ";
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?php
    include_once "footer.php";
    ?>