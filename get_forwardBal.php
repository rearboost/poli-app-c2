<?php
	
	error_reporting(0);
	include("db_config.php");
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
	mysqli_select_db($con, DB_NAME);

	$loan_no = $_POST['loan_no'];
	
	$no = mysqli_query($con,"SELECT brought_forward FROM loan_installement WHERE loan_no ='$loan_no' ORDER BY id DESC LIMIT 1");

    $data1 = mysqli_fetch_array($no); 

	$brought_forward  = $data1['brought_forward'];

	if(empty($brought_forward))
	{
		$brought_forward = 0;	
	}
	else
	{
	   $brought_forward = $brought_forward;
	}

	$myObj->brought_forward  = $brought_forward;
	$myJSON = json_encode($myObj);
	echo $myJSON;

	//echo  $brought_forward;

?>