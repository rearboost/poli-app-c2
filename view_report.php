<?php
  error_reporting(0);
  include("db_config.php");
  $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }
?>
  <table class="table" id="get_data1">
    <thead class="text-primary">
      <th>                    LOAN NO         </th>
      <th class="text-right"> BORROWED DATE   </th>
      <th class="text-right"> LOAN AMOUNT     </th>
    </thead>
    <tbody>

  <?php

  if(isset($_POST['cust_id'])){

    $customer = $_POST['cust_id'];

    $query = mysqli_query($con,"SELECT  L.loan_no AS loan_no, L.l_date as l_date, L.amount as amount
      FROM customer C
      INNER JOIN loan L
        ON C.cust_id = L.cust_id
      WHERE L.cust_id = '$customer' ");

    // $data = mysqli_fetch_array($query); 

    // $loan_no    = $data['loan_no'];
    // $l_date     = $data['l_date'];
    // $loan_amt   = $data['amount'];

    // $get_amt = mysqli_query($con,"SELECT * FROM (SELECT SUM(installement_amt+interest_amt) as total_paid FROM loan_installement WHERE loan_installement.loan_no = '$loan_no') V GROUP BY V.loan_no ;");

    // $data1 = mysqli_fetch_array($get_amt); 

    // $total_paid   = $data1['total_paid'];

    $numRows = mysqli_num_rows($query);

      if($numRows > 0) {
        while($row = mysqli_fetch_assoc($query)) {
?>
     
      <tr>
        <td>                    <?php echo $row['loan_no'] ?>   </td>
        <td class="text-right"> <?php echo $row['l_date'] ?>    </td>
        <td class="text-right"> <?php echo number_format($row['amount'],2) ?>    </td>
        <td class="text-right">    
         <a href="#" onclick="View('<?php echo $row['loan_no']; ?>')" name="view">History </a>
        </td>
      </tr>
      <div id = "show_view">
        
      </div>

    </tbody>

<?php
        }
      }
?> 
  
  </table>
  <?php
  mysqli_close($con);

  }

 ?>
<script>
    // VIEW HISTORY
    function View(id){

      $.ajax({
              url:"view_history.php",
              method:"POST",
              data:{"id":id},
              success:function(data){
                $('#show_view').html(data);
                $('#get_data2').modal('show');
                //$('#get_data1').hide();
              }
        });
    }
    ////////////////////  
</script>