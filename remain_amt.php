<?php
	
	error_reporting(0);
	include("db_config.php");
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
	mysqli_select_db($con, DB_NAME);

	$customer_id = $_POST['id'];

	$get_loan = mysqli_query($con,"SELECT loan_no,l_date,amount,no_installements,	rental,l_type,l_method FROM loan l WHERE cust_id = '$customer_id' AND l_status = 1");

	$data = mysqli_fetch_array($get_loan); 

	$loan_no 			= $data['loan_no'];
	$l_date 			= $data['l_date'];
	$loan_amt 			= $data['amount'];
	$no_installements 	= $data['no_installements'];
	$rental 			= $data['rental'];
	$l_type 			= $data['l_type'];
	$l_method 			= $data['l_method'];
	
	$check_no = mysqli_query($con,"SELECT * FROM (SELECT * FROM loan_installement WHERE loan_installement.loan_no = '$loan_no') V ORDER BY V.id DESC LIMIT 1;");

    $data1 = mysqli_fetch_array($check_no); 

	$li_date 		  = $data1['li_date'];
	$arrears   		  = $data1['arrears'];
	$total_paid  	  = $data1['total_paid'];
	$brought_forward  = $data1['brought_forward'];

	$first_forward_bal = $rental * $no_installements;
	
	if(empty($brought_forward))
	{
		$brought_forward = $first_forward_bal;	
		$total_paid 	 = 0.00;	
		$arrears 	 	 = 0.00;	
		$pre_date 		 = $l_date;	
	}
	else
	{
	   $brought_forward = $brought_forward;
	   $total_paid 		= $total_paid;	
	   $arrears 		= $arrears;	
	   $pre_date   		= $li_date;
	}

	$myObj->loan_amt 		 = $loan_amt;
	$myObj->no_installements = $no_installements;
	$myObj->rental 			 = $rental;
	$myObj->l_type 			 = $l_type;
	$myObj->l_method 		 = $l_method;
	$myObj->brought_forward  = $brought_forward;
	$myObj->total_paid  	 = $total_paid;
	$myObj->arrears 		 = $arrears;
	$myObj->pre_date 		 = $pre_date;

	$myJSON = json_encode($myObj);

	echo $myJSON;

?>