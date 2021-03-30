<?php

	$con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
  	if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
  	}
  	mysqli_select_db($con,DB_NAME);

	//////////// card 1 /////////////
	$customer_count = mysqli_query($con, "SELECT cust_id FROM customer");
	$card_1 = mysqli_num_rows($customer_count); 

	//////////// card 2 /////////////
	$loan_count = mysqli_query($con, "SELECT loan_no FROM loan");
	$card_2 = mysqli_num_rows($loan_count);

	//////////// card 3 /////////////
	$date = new DateTime(null, new DateTimeZone('Etc/GMT+8'));
    $new_date = $date->format('Y-m-d'); 
    $today = explode('-', $new_date);

    $cur_month = $today[1];

	$collect_amt = mysqli_query($con, "SELECT SUM(paid) as tot_collect FROM loan_installement WHERE month = '$cur_month' ");
	$sum = mysqli_fetch_array($collect_amt); 

	$card_4 = $sum['tot_collect']; 

	if(!empty($card_4)){
		$card_4 = $sum['tot_collect']; 
	}else{
		$card_4 = 0; 
	}


?>