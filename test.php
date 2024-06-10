<?php 
 session_start();
require_once('config.php')

?>
<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    
    <div class="row">
    <h3 class="float-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
        <div class="col-lg-12">
            <h3 class="text-center">Login</h3>
            <hr>
            <form action="" id="login_guest-form" method="post">
                <div class="form-group">
                    <label for="" class="control-label">Username</label>
                    <input type="text" class="form-control form" name="username" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
 if(isset($_POST['submit'])){
    // Assuming $conn is your database connection
    $username = $_POST['username'];
    $password = $_POST['password'];

    $searchQuery = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = md5('$password')");
    if ($searchQuery) {
        // Check the number of rows returned by the query
        $num_rows = mysqli_num_rows($searchQuery);
        if ($num_rows > 0) {
            $resultQuery = mysqli_fetch_array($searchQuery);
            $userDB = $resultQuery['username'];
            $passDB = $resultQuery['password'];
            $userlbDB = $resultQuery['user_level'];

            // Store user data in session
            $_SESSION['userdata'] = array(
                'username' => $userDB,
                'password' => $passDB,
                'id' => $resultQuery['id'] // Assuming 'id' is the column name for user ID in your 'users' table
            );
            $_SESSION["favcolor"] = "yellow";
            print_r($_SESSION);
?>
      <script>window.location.assign('http://localhost/stationeryy/')</script>
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
  if (isset($_SESSION['userdata']['id'])){
    $id = $_SESSION['userdata']['id'];
    echo "id: " . $id;

  } else {
    echo "";
  }
  ?>
   <script>
  $(function(){
    $('#login_guest-form').submit(function(e){
        e.preventDefault();
        start_loader()
        if($('.err-msg').length >0)
           $('.err-msg').remove();
        $.ajax({
            url:_base_url_+"classes/Login.php?f=login_guest",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("an error occured",'error')
                end_loader()
            },
            success:function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    alert_toast("Login Succeessfully",'success')
                    setTimeout(function(){
                        location.reload()
                    },2000)
                }else if(resp.status == 'incorrect'){
                    var _err_el = $('<div>')
                        _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                    $('#login_guest-form').prepend(_err_el)
                    end_loader()
                }else{
                    console.log(resp)
                    alert_toast("an error occured",'error')
                    end_loader()
                }
            }
        })
    })
  })
  </script>