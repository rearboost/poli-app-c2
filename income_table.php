<?php
  include("db_config.php");
  $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }


  if(isset($_POST['year']) && ($_POST['month']))
  {
    $year    = $_POST['year'];
    $month   = $_POST['month'];
    $query   = "SELECT li_date AS column1, SUM(paid) AS tot_amount FROM loan_installement WHERE year='$year' AND month='$month' GROUP BY column1 HAVING tot_amount>0";
  }

  else if (isset($_POST['year']) && !empty($_POST['year']))
  {  
    $year   =$_POST['year'];
    $query = "SELECT month AS column1, SUM(paid) AS tot_amount FROM loan_installement WHERE year='$year' GROUP BY column1 HAVING tot_amount>0";   
  
  }
  // else 
  // {
  //   $query = "SELECT year AS column1, SUM(paid) AS tot_amount FROM loan_installement GROUP BY column1 HAVING tot_amount>0";
  // }

  $result = mysqli_query($con ,$query);

  if(mysqli_num_rows($result)>0)
  {
    ?>

 <table class="table" id="get_data1">
    <thead class="text-primary">
      <th style="width:10%"> </th>
      <th>                    MONTH / DATE   </th>
      <th class="text-right"> AMOUNT (LKR)   </th>
      <th style="width:10%"> </th>
    </thead>
    <tbody>
   <?php
   $i=1;
   while($row = mysqli_fetch_array($result))
   {
    echo '
    <tr>
     <td style="width:10%"> </td>
     <td>'.$row["column1"].'</td>
     <td class="text-right">'.number_format($row["tot_amount"],2).'</td>
     <td style="width:10%"> </td>';
    echo '</tr>';

    $i++;
   }
   ?>
   </tbody>
  </table>
   <?php
   mysqli_close($con);
  }
  
?>

 
