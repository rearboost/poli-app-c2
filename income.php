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

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Poli App - REPORT
   </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />

</head>

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

  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <!-- <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script> -->
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
  <!-- sweetalert message -->
  <script src="assets/js/sweetalert.min.js"></script>

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