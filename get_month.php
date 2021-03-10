<?php	
	include("db_config.php");
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
	mysqli_select_db($con, DB_NAME);

	if(isset($_GET['year'])){	
		$year = $_GET['year'];

		$get_month = mysqli_query($con, "SELECT DISTINCT(month) as month FROM loan_installement WHERE year='$year' ORDER BY month ASC") ;

		$count = mysqli_num_rows($get_month);

		if($count>0){
			echo '<option selected="" disabled="">Select Year First</option>';
			while($row = mysqli_fetch_array($get_month)){

                $dt = DateTime::createFromFormat('!m', $row['month']);
                $text_month =  $dt->format('F');

				echo '<option value ="'.$row['month'].'" >'.$row['month']. ' | '  .$text_month.'</option>';
			}
		}else{
			echo '<option>No Months</option>';
		}
		
	}else{
		echo '<h1> Error</h1>';
	}



?>