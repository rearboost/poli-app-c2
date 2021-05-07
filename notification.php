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
          <div class="col-md-12">         
            <div class="card">
              <div class="row">
              <div class="col-md-10">
              <div class="card-header">
                <h3 class="card-title"> You have to exchange following cheques.</h3>                    
              </div>
              </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="myTable">
                    <thead class="text-primary">
                      <th>  Customer</th>
                      <th>  Bank</th>
                      <th>  Cheque No</th>
                      <th>  Valid Date</th>
                      <th>  Cheque value</th>
                    </thead>
                    <tbody>
                      <?php

                      // $sql=mysqli_query($con,"SELECT * FROM cheque WHERE valid_date = CURDATE() OR valid_date = date_add(curdate(),interval 1 day) AND status = 'NYC' ORDER BY valid_date ASC");

                      // $numRows = mysqli_num_rows($sql); 
                 
                      if($numRows > 0) {
                        while($row = mysqli_fetch_assoc($sql)) {
                          ?>
                          <tr>
                            <td> <?php echo $row['cust_id'] ?>       </td>
                            <td> <?php echo $row['bank'] ?>          </td>
                            <td> <?php echo $row['cheque_no']?>      </td>
                            <td> <?php echo $row['valid_date']  ?>   </td>
                            <td> <?php echo $row['cheque_value']  ?> </td>
                          </tr>
                    </tbody>
                           <?php
                        }
                      }
                    ?>                      
                    </table>
                  <?php
                  mysqli_close($con);
                  ?>
                </div>
              </div>
            </div>
          </div>
          </div>

        </div>
      </div>
      <!-- FOOTER -->
       <?php include('include/footer.php');  ?>
      <!-- FOOTER -->
    </div>
  </div>

  <?php include('include/footer_js.php');  ?>

<script>
  ////////////////////////////  DataTable ////////////////////////////
  $(document).ready( function () {
      $('#myTable').DataTable();
  });
</script>


</body>

</html>
<?php
}
?>
