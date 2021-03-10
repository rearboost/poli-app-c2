<?php
	include("db_config.php");
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
	mysqli_select_db($con, DB_NAME);

	$type = $_POST['type'];

	if($type == "Daily")
	{
		$getid = "SELECT customer.cust_id  FROM customer WHERE customer.cust_id LIKE 'D%' AND customer.type = 'Daily' 
				ORDER BY customer.cust_id DESC LIMIT 1";
		$cust_id ="D0000";
				
	}
	else
	{
	   $getid = "SELECT customer.cust_id  FROM customer WHERE customer.cust_id LIKE 'W%' AND customer.type = 'Weekly' 
				ORDER BY customer.cust_id DESC LIMIT 1";

	    $cust_id ="W0000";
	}
	$record = mysqli_query($con, $getid);
	while ($row = mysqli_fetch_assoc($record)) {
	
	    $cust_id = substr($row['cust_id'], 1); 
	}
	echo $cust_id;

?>