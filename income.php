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
                <div class="card-header">
                  <h5 class="card-title pl-3">&nbsp;&nbsp;INCOME REPORT</h5>                    
                </div>
              </div>
              <div class="card-body">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Pick a year</label>
                      <select class="form-control" name="year" id="year">
                        <option selected="" disabled="">Select Year</option>
                        <?php
                                      
                          //fetch years 
                          $get_year = "SELECT DISTINCT(year)AS year FROM loan_installement WHERE year<>''";

                          $result = mysqli_query($con,$get_year);
                          $numRows = mysqli_num_rows($result); 

                            if($numRows > 0) {
                              while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value = ".$row['year'].">" . $row['year'] . "</option>";
                                
                              }
                            }
                          ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>Pick a month</label>
                      <select class="form-control" name="month" id="month">
                        <option selected="" disabled="">Select Year First</option>
                      </select>
                    </div>
                  </div>
                </div>
              
              <div class="table-responsive">
                <div id="result">

                </div>
              </div>
            </div>
          </div><!--card -->
        </div>
      </div>
    </div>  
  <!-- FOOTER -->
   <?php include('include/footer.php');  ?>
  <!-- FOOTER -->
  </div> <!-- end main panel -->
</div> <!-- end wrapper -->

  <?php include('include/footer_js.php');  ?>

  <script>
  $(document).ready(function(){

   $('#year').on('change', function() {
        var year  = $(this).val();
        var month = $('#month').val();

         $('#month').val('');
        
        $.ajax({
           url:"income_table.php",
           method:"POST",
           data:{"month":month,"year":year},
           success:function(data)
           {
            $('#result').html(data);
           }
        });

        if(year){
          
          $.get("get_month.php",
            {year:year},
            function (data) { 
              $('#month').html(data);
            }
          );
             
        }else{
          $('#month').html('<option>Select Year First</option>');
        }

    });

    $('#month').on('change', function() {
     var year  = $('#year').val();
     var month = $(this).val();
      
      if(year){
        $.ajax({
           url:"income_table.php",
           method:"POST",
           data:{"month":month,"year":year},
           success:function(data)
           {
            $('#result').html(data);
           }
        });
      }else{
        alert('Please select the year first');
        $('#month').val('');
      }
        
    });

  });
  </script>

</body>

</html>
<?php
}
?>