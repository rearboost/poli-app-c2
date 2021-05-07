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

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">

</head>

<body class="">
  <div class="wrapper ">

  <?php

    $id = $_GET['id']; // get id through query string

    $qry = mysqli_query($con,"SELECT * FROM loan,loan_installement WHERE loan.loan_no = loan_installement.loan_no AND id=$id "); // select query

    $data = mysqli_fetch_array($qry); // fetch data

    $l_type = $data['l_type'];
    if($l_type=="weekly"){

      $duration = 'W - '.$data['duration']/7;
    }else{
      $duration = 'D - '.$data['duration'];
    }
                 
?>
       <div class="print_form">
        <form >
          <div>
            <br>
            <img src="images/poli_app.png" style="padding-left: 17%;"><br>
             <span style="padding-left: 20px; font-size: 45px; color: black;"><b>NATIAL MICRO CREDIT AN</b></span><br>
             <span style="padding-left: 55px; font-size: 45px; color: black;"><b> INVESTMENT (PVT) LTD.</b></span><br>
             <span style="padding-left: 100px; font-size: 40px; color: black;">(Reg No. PV00214503)</span><br><br>
             <span style="font-size: 43px; color: black;"><b>Installement Receipt</b></span><br>
             <span style="font-size: 43px; color: black; font-family: sans-serif;">Tel : 076 0364 350 / 070 3625 796</span><br>
             <span style="font-size: 43px; color: black; font-family: sans-serif;">Bill Date : 
             <?php 
                $date = new DateTime(null, new DateTimeZone('Asia/Colombo'));
                        echo $date->format('Y-m-d h:i: sA'); ?>       
              </span><br>
              <span style="font-size: 43px; color: black; font-family: sans-serif;">Route : Mahiyangana-Hadungamuwa</span><br>
              <span style="font-size: 43px; color: black; font-family: sans-serif;">Cash coll : Mr.Hashitha</span><br>
          </div>
          <b><span style="color: black;">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</span> <br></b>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Customer : 
          <b>
          <?php
             $name_id = $data['cust_id'];
             $custom = "SELECT * FROM customer WHERE cust_id = '$name_id' ";
             $result1 = mysqli_query($con,$custom);
             $dataName = mysqli_fetch_array($result1);
             echo $dataName['name'];
          ?>
          </b>
          </span><br>
          <span style="padding-left: 83px; font-size: 43px;"><b><?php echo "( ".$dataName['reg_no']." )" ?></b></span> <br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Loan Amount : 
          <b>
          <?php $amount = $data['amount'];
                echo number_format($amount,2,".",",") 
          ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Rental : 
          <b>
          <?php $rental = $data['rental'];
                echo number_format($rental,2,".",",")  
          ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Duration :
          <b>
          <?php echo $duration; ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Start Date : 
          <b>
          <?php echo $data['l_date'] ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">End Date : 
          <b>
          <?php echo $data['end_date'] ?>
          </b>
          </span><br>

          <b><span style="color: black;">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</span> <br></b>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Today paid : 
          <b>
          <?php $paid = $data['paid'];
                echo number_format($paid,2,".",",") 
          ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Arreares/Additional : 
          <b>
          <?php $arrears = $data['arrears'];
                echo number_format($arrears,2,".",",") 
          ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Total paid : 
          <b>
          <?php $total_paid = $data['total_paid'];
                echo number_format($total_paid,2,".",",")  
          ?>
          </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Brought forward : 
          <b>
          <?php $brought_forward =$data['brought_forward'];
                echo number_format($brought_forward,2,".",",") ?>
           </b>
          </span><br>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">Closing balance : 
          <b>
          <?php $closing_bal =$data['brought_forward'];
                echo number_format($closing_bal,2,".",",") ?>
           </b>
          </span><br>

          <?php 
          $penalty_status = $data['penalty_status'];
          if ($penalty_status==1): ?>

          <span style="font-size: 43px; color: black; font-family: sans-serif;">
          
          <?php $penalty =$data['penalty'];
                echo '* Including <b>' . number_format($penalty,2,".",",") . '</b> of penalty fee.' ?>
           
          </span><br>
          <?php else: ?>
          <?php endif ?>

          <b><span style="color: black;">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</span> <br></b><br>
          <h5 style="padding-left: 18%; font-size: 40px; color: black;"><b>THANK YOU!</b></h5>
          <br>
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
      setTimeout(function(){ window.print(); }, 1500);
     // setTimeout(window.close, 3000);
  });
  ///////////////////////////////////////////


  </script>
</body>

</html>
<?php
}
?>