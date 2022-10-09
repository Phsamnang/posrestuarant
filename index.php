<?php
include_once "connect_db.php";
session_start();

if(isset($_POST['login'])){
  $username=strtolower($_POST['username']);
  $pwd=$_POST['pwd'];

  //echo $username.$pwd;
$select=$conn->prepare("SELECT * FROM tb_user WHERE username='$username' AND pwd='$pwd'");
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);
if($username===$row['username'] AND $pwd===$row['pwd'] AND $row['role']==="admin"){
  $_SESSION['userid']=$row['userid'];
  $_SESSION['username']=$row['username'];
  $_SESSION['role']=$row['role'];
 
  header("refresh:1;dashboard.php");
}else if($username===$row['username'] AND $pwd===$row['pwd'] AND $row['role']==="user"){
  $_SESSION['userid']=$row['userid'];
  $_SESSION['username']=$row['username'];
  $_SESSION['role']=$row['role'];
  header("refresh:1;user.php");
}else{
  echo "Fail login";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>VY</b>CHOMRUOEN</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="index.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="username" name="username" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pwd" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
