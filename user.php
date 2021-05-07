<?php
include("db_config.php");
include("msg_show.php");
session_start();
if (!isset($_SESSION['loged_user'])) {
    //echo "Access Denied";
    header('location: login.php');
}else {
$con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
  if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
  }
mysqli_select_db($con,DB_NAME);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('include/head.php'); ?>

<body class="">
  <div class="wrapper ">
    <?php include('include/sidebar.php');  ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include('include/nav.php');  ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12"><!-- Begin profile-->
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit Login Credintials</h5>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class= "col-md-6">
                      <h5>Change username</h5>
                      <form id="changeUsername">
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="form-group">
                              <label>Current Username</label>
                              <input type="text" class="form-control"  placeholder="current username" name="old_user" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="form-group">
                              <label>New Username</label>
                              <input type="text" class="form-control"  placeholder="New username" name="new_user" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="update ml-auto mr-auto">
                              <p style="color: red" id="res_update_user"></p> 
                              <input type="hidden" name ="update_user" value="update_user"/>
                              <button type="submit" class="btn btn-primary btn-round">Update Username</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class= "col-md-6">
                      <h5>Change Password</h5>
                      <form id="changePassword">
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="form-group">
                              <label>Current Password</label>
                              <input type="text" class="form-control"  placeholder="current password" name="old_pw" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="form-group">
                              <label>New password</label>
                              <input type="text" class="form-control"  placeholder="New password" name="new_pw" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="form-group">
                              <label>Confirm password</label>
                              <input type="text" class="form-control"  placeholder="Confirm password" name="confirm_pw" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8 pr-1">
                            <div class="update ml-auto mr-auto">
                              <p style="color: red" id="res_update_pw"></p>
                              <input type="hidden" name ="update_pw" value="update_pw"/> 
                              <button type="submit" class="btn btn-primary btn-round">Update Password</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
              <?php
                  mysqli_close($con);
              ?>
              </div>
            </div>
          </div><!-- end profile-->
        </div>
      </div>
      <!-- FOOTER -->
       <?php include('include/footer.php');  ?>
      <!-- FOOTER -->
    </div>
  </div>
  <?php include('include/footer_js.php');  ?>
</body>

</html>
<?php
}
?>


<script>

       $(function () {
        $('#changeUsername').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            url: 'edit_user.php',
            data: $('#changeUsername').serialize(),
            success: function (data) {

              if(data==1){

                swal({
                title: "Good job !",
                text: "Successfully Submited",
                icon: "success",
                button: "Ok !",
                });
                setTimeout(function(){ location.reload(); }, 2500);

              }else{

                $('#res_update_user').html(data)
              } 
            }
          });
        });
      });

      ///////////////////////////////////////////////////

      $(function () {
        $('#changePassword').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            url: 'edit_user.php',
            data: $('#changePassword').serialize(),
            success: function (data) {

              if(data==1){

                swal({
                title: "Good job !",
                text: "Successfully Submited",
                icon: "success",
                button: "Ok !",
                });
                setTimeout(function(){ location.reload(); }, 2500);

              }else{

                $('#res_update_pw').html(data)
              } 
            }
          });
        });
      });


      

</script>