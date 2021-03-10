<?php
	error_reporting(0);
	include("db_config.php");
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
	mysqli_select_db($con, DB_NAME);

	$start_day = $_POST['start_day'];
	$finish_day = $_POST['finish_day'];
	$method = $_POST['method'];

	if($method=='normal'){
		$get_poyaday = mysqli_query($con,"SELECT COUNT(id) AS poyadays FROM special_days WHERE poyaday BETWEEN '$start_day' AND '$finish_day'");
	}else{
		$get_poyaday = mysqli_query($con,"SELECT COUNT(id) AS poyadays FROM special_days WHERE day_index<>0 AND poyaday BETWEEN '$start_day' AND '$finish_day'");
	}


	$data = mysqli_fetch_assoc($get_poyaday); 

	$poyadays 	= $data['poyadays'];
	
	if(empty($poyadays))
	{
		$poyadays = 0;	
	}
	else
	{
	   $poyadays = $poyadays;
	}

	 // $myObj->poyadays  = $poyadays;

	 // $myJSON = json_encode($myObj);

	//echo $myJSON;
	echo $poyadays;

?>