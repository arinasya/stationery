<?php 
 session_start();
 require_once('../config.php') 
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('includes/main.php') ?>
<body class="hold-transition login-page  dark-mode">
  <script>
    start_loader()
  </script>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="./" class="h1"><b>Login</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="login-frm" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <a href="<?php echo base_url ?>">Go to Website</a>
          </div>
          <!-- /.col -->
          <div class="col-4"> 
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<?php
  if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['userdata'] = array(
      'username' => $username,
      'password' => $password,
      
     );

    $searchQuery = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username' AND password = md5('$password')");
    if ($searchQuery) {
      // Check the number of rows returned by the query
      $num_rows = mysqli_num_rows($searchQuery);
      if ($num_rows > 0) {
        $resultQuery = mysqli_fetch_array($searchQuery);
        $userDB = $resultQuery['username'];
        $passDB = $resultQuery['password'];
        $userlbDB = $resultQuery['user_level'];
        $resultQuery['status'];
        $_SESSION['user_level']=$userlbDB;
        $_SESSION['username'] = $userDB;
        $_SESSION['password'] = $passDB;

        $username = $_SESSION['userdata']['username'];
        $password = $_SESSION['userdata']['password'];
        $id = $_SESSION['userdata']['id'];
      ?>
        <script>window.location.assign('http://localhost/stationeryy/it/index.php')</script>
      <?php
      } else {
        echo 'no match';
          // No matching user found
          // Handle error (e.g., display error message, redirect, etc.)
      }
  } else {
      // Query execution failed
      // Handle error (e.g., log error, display error message, etc.)
  }
  }else{
    echo '';
  }

?>
<!-- jQuery -->
<!--<script src="plugins/jquery/jquery.min.js"></script>-->
<!-- Bootstrap 4 -->
 <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> 
<!-- AdminLTE App -->
  <!--<script src="dist/js/adminlte.min.js"></script> -->

 <script>
  $(document).ready(function(){
    end_loader();
  })
</script> 
</body>
</html>