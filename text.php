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
}
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

</body>
</html>


      
<?php
//include("db_config.php");

$end_date = '2021-06-23';
$poyadays = 3;

//echo date('Y-m-d', strtotime($end_date. ' + '.$poyadays.'days'));

// echo date('Y-m-d', strtotime("2021-06-23 +3 days"));

//    $dateBegin = date('Y-m-d', strtotime('2021-03-01'));
//    $dateEnd = date('Y-m-d', strtotime('2021-03-30'));
                             

//    $sundaysArray = array();
//     while ($dateBegin <= $dateEnd) {
//         if ($dateBegin->format('w') == 0) {
//             $sundaysArray[] = $dateBegin->format('Y-m-d');
//         }
        
//         $dateBegin->modify('+1 day');
//     }

//     echo $sundaysArray;

    $startDate = new DateTime('2021-03-01');
    $endDate = new DateTime('2021-03-30');

    //$sundays = array();

    $sunAndpoyaday = 0;
    
    while ($startDate <= $endDate) {
        if ($startDate->format('w') == 0) {
            $spDates=mysqli_query($con,"SELECT * FROM special_days");
            while($row = mysqli_fetch_assoc($spDates)) {
                $getDate = $row['poyaday'];
                if ($startDate->format('Y-m-d') == $getDate){
                    $sunAndpoyaday = $sunAndpoyaday +1;
                }
            }
        }
        $startDate->modify('+1 day');
    }

    echo $sunAndpoyaday;




