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
    Poli App - DEBT COLLECTION
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

  <?php

    $id = $_GET['id']; // get id through query string

    $qry = mysqli_query($con,"SELECT * FROM loan,loan_installement WHERE loan.loan_no = loan_installement.loan_no AND id=$id "); // select query

    $data = mysqli_fetch_array($qry); // fetch data
                 
?>
       <div class="print_form">
        <form >
          <div>
            <br>
            <img src="images/logo.png" style="padding-left: 7%;"><br>
             <span style="padding-left: 20px; font-size: 14px; color: black;"><b>NATIAL MICRO CREDIT AN</b></span><br>
             <span style="padding-left: 28px; font-size: 14px; color: black;"><b> INVESTMENT (PVT) LTD.</b></span><br>
             <span style="padding-left: 32px; font-size: revert; color: black;">(Reg No. PV00214503)</span><br><br>
             <span style="font-size: small; color: black;"><b>Installement Receipt</b></span><br>
             <span style="font-size: small; color: black;">Tel : 076 0364 350 / 070 3625 796</span><br>
             <span style="font-size: small; color: black;">Bill Date : 
             <?php 
                $date = new DateTime(null, new DateTimeZone('Etc/GMT+8'));
                        echo $date->format('Y-m-d h:i:sA'); ?>       
              </span><br>
              <span style="font-size: small; color: black;">Route : Mahiyangana-Hadungamuwa</span><br>
              <span style="font-size: small; color: black;">Cash coll : Mr.Wijethunga</span><br>
          </div>
          <span style="color: black;">--------------------------------------------------</span> <br>

          <span style="font-size: small; color: black;">Customer : 
          <?php
             $name_id = $data['cust_id'];
             $custom = "SELECT * FROM customer WHERE cust_id = '$name_id' ";
             $result1 = mysqli_query($con,$custom);
             $dataName = mysqli_fetch_array($result1);
             echo $dataName['name'];
          ?>
          </span><br>
          <span style="padding-left: 83px; font-size: small;"><?php echo "( ".$data['cust_id']." )" ?></span> <br>

          <span style="font-size: small; color: black;">Loan Amount : 
          <?php $amount = $data['amount'];
                echo number_format($amount,2,".",",") 
          ?>
          </span><br>

          <span style="font-size: small; color: black;">Rental : 
          <?php $rental = $data['rental'];
                echo number_format($rental,2,".",",")  
          ?>
          </span><br>

          <span style="font-size: small; color: black;">Duration : 
          <?php echo $data['duration'] ?>
          </span><br>

          <span style="font-size: small; color: black;">Start Date : 
          <?php echo $data['l_date'] ?>
          </span><br>

          <span style="font-size: small; color: black;">End Date : 
          <?php echo $data['end_date'] ?>
          </span><br>

          <span style="color: black;">--------------------------------------------------</span> <br>

          <span style="font-size: small; color: black;">Today paid : 
          <?php $paid = $data['paid'];
                echo number_format($paid,2,".",",") 
          ?>
          </span><br>

          <span style="font-size: small; color: black;">Arreares/Additional : 
          <?php $arrears = $data['arrears'];
                echo number_format($arrears,2,".",",") 
          ?>
          </span><br>

          <span style="font-size: small; color: black;">Total paid : 
          <?php $total_paid = $data['total_paid'];
                echo number_format($total_paid,2,".",",")  
          ?>
          </span><br>

          <span style="font-size: small; color: black;">Brought forward : 
          <?php $brought_forward =$data['brought_forward'];
                echo number_format($brought_forward,2,".",",") ?>
          </span><br>

          <span style="color: black;">--------------------------------------------------</span>
          <h5 style="padding-left: 5%; font-size: small; color: black;"><b>THANK YOU!</b></h5>
         </form> 
       </div>
  </div>

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

  ///////////////////////////////////////  Print  
  $(document).ready(function(){
      setTimeout(function(){ window.print(); }, 2000);
     // setTimeout(window.close, 3000);
  });
  ///////////////////////////////////////////


  </script>
</body>

</html>
<?php
}
?>