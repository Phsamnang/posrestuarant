<?php
include "connect_db.php";
session_start();
include_once "header.php";
$id = $_GET['id'];
$select = $conn->prepare("select * from tb_menus where menuid=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);
$cate = $row['cateid'];
$menusname = $row['name'];
$menuprice = $row['price'];
$menuimage = $row['image'];
if (isset($_POST['btnupdate'])) {
    $id_menu = $_POST['btnupdate'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $f_name=$_FILES['myfile']['name'];
    if(!empty($f_name)){
        $f_tmp = $_FILES['myfile']['tmp_name'];
        $f_size = $_FILES['myfile']['size'];
    
        $f_extension = explode('.', $f_name);
        $f_extension = strtolower(end($f_extension));
    
        $f_newfile = uniqid() . '.' . $f_extension;
        
        $store = 'upload/' . $f_newfile;
        if ($f_extension == 'jpg' || $f_extension == 'png') {
            if ($f_size >= 10000000) {
               $error='<script>
               jQuery(document).ready(function($) {
                  alert("shoud be 1MB");
                   });
               </script>';
            } else {
                if (move_uploaded_file($f_tmp, $store)) {
                    unlink("upload/$menuimage");
                    $productimage = $f_newfile;
                    if (!isset($error)) {
                        $insert = $conn->prepare("update tb_menus set cateid=:category,name=:name,price=:price,image=:image where menuid=$id_menu");
                        $insert->bindParam(':category', $category);
                        $insert->bindParam(':name', $name);
                        $insert->bindParam(':price', $price);
                        $insert->bindParam(':image', $productimage);
                        if ($insert->execute()) {
                            '<script>
                        jQuery(document).ready(function($) {
                           alert("success");
                            });
                        </script>';
                        header("refresh1:addmenu.php");
                        } else {
                            '<script>
                            jQuery(document).ready(function($) {
                               alert("fail");
                                });
                            </script>';
                        }
                }
            }
        }
       
        }
    }else{
        $insert = $conn->prepare("update tb_menus set cateid=:category,name=:name,price=:price,image=:image where menuid=$id_menu");
        $insert->bindParam(':category', $category);
        $insert->bindParam(':name', $name);
        $insert->bindParam(':price', $price);
        $insert->bindParam(':image', $productimage);
        if($insert->execute()){
            header("location:addmenu.php");
        }else{
            echo "fail";
        }

    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0">Update Product</h1>
                    <a href="menulist.php" class="btn btn-info">Show Product</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Menu</li>
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
                    <h3 class="card-title">Edit Menu</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Product Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="Product Name" name="product_name" value="<?php echo $menusname ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="i" class="col-sm-2 col-form-label">Category</label>
                                    <select class="form-control col-sm-10" name="category">
                                        <option value="" disabled selected>select category</option>
                                        <?php
                                        $select = $conn->prepare("SELECT *FROM tb_category");
                                        $select->execute();
                                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row);

                                        ?>
                                            <option <?php if ($row['cateid'] == $cate) { ?> selected="selected" <?php } ?> value="<?php echo $row['cateid']; ?>">
                                                <?php echo $row['category']; ?></option>

                                        <?php } ?>

                                    </select>

                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Sale Price</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPassword3" placeholder="Enter..." name="price" value="<?php echo $menuprice ?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="inputPassword3" placeholder="Enter..." name="myfile">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning" name="btnupdate" value="<?php echo $id ?>">Update</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<?php
include_once "footer.php";
?>