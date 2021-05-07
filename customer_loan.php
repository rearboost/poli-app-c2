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

<?php include('include/head.php'); ?>

<body class="">
  <div class="wrapper ">
    <?php include('include/sidebar.php');  ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include('include/nav.php');  ?>
      <!-- End Navbar -->
      <div class="content">
      <div class="row">
          <div class="col-md-12">         
            <div class="card">
              <div class="row">
              <div class="col-md-9">
              <div class="card-header">
                <h4 class="card-title"> CUSTOMER LOANS</h4>    
                <input class="form-control myInput" id="myInput" type="text" placeholder="Search..">                                
              </div>
              </div>
              <div class="col-md-3">
                 <div class="card-header">
                    <button type="button" class="btn btn-primary add-btn" data-toggle="modal" data-target="#Form1">+ Fill Form in here..
                    </button>
                 </div>
              </div>
              </div>
              <div class="card-body">
                <div class="modal fade" id="Form1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">  Customer Loan</h5>
                  </div> 
                <form id="loanAdd">
                  <div class="col-md-12">
                    <br>

                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group" style="border:2px solid; border-radius: 10px; padding: 10px; border-color: #ccccb3;">
                        <label>Loan Type</label> <br>
                        <label><input type="radio" id="t1" name="loan_type" value="daily" checked=""> Daily
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>
                          <input type="radio" id="t2" name="loan_type" value="weekly"> Weekly
                        </label><br>
                      </div>
                    </div>

                    <div class="col-md-6 pr-3">
                      <div class="form-group" style="border:2px solid; border-radius: 10px; padding: 10px; border-color: #ccccb3;">
                        <label>Payment Method</label> <br>
                        <label><input type="radio" id="m1" name="loan_method" value="normal" checked=""> Normal
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>
                          <input type="radio" id="m2" name="loan_method" value="sunday off"> Sunday Off
                        </label><br>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Customer</label>
                          <select class="form-control form-selectBox" id="customer_loan" name="cust_id" required="">
                            <option selected="" value="0">--Select Customer--</option>
                            <?php
                          
                            /// need to fetch customer who not a debtor [only drop customers who have l_status - 1]
                                $custom = "SELECT C.cust_id AS cust_id, C.name AS name
                                          FROM customer C 
                                          ";

                                $result1 = mysqli_query($con,$custom);
                                $numRows1 = mysqli_num_rows($result1); 
                 
                                  if($numRows1 > 0) {
                                    while($row1 = mysqli_fetch_assoc($result1)) {
                                      echo "<option value = ".$row1['cust_id'].">" . $row1['cust_id'] . " | " . $row1['name'] . "</option>";
                                      
                                    }
                                  }
                            ?>
                            
                          </select>
                          <div id="show" class="loan-validtion">
                            
                          </div>

                      </div>
                    </div>
                    <div class="col-md-6 pr-3">
                      <div class="form-group" >
                        <label>Date of obtaining loan</label>
                        <input type="date" id="l_date" name="l_date" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Loan Amount</label>
                        <input type="text" class="form-control customerAmt" placeholder="LKR" id="amount" name="l_amt" required>
                      </div>
                    </div>

                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Interest (%)</label>
                        <input type="text" class="form-control customerAmt" placeholder="Interest" id="int" name="interest" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>No: of Installements</label>
                        <input type="text" class="form-control" id="no_installements" name="no_installements" required placeholder="No. of Installements">
                      </div>
                    </div>
                    
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Rental</label>
                        <input type="text" class="form-control" id="rental" name="rental" required placeholder="LKR.0.00">
                      </div>
                    </div>

                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Duration (Days)</label>
                        <input type="text" class="form-control" id="duration" name = "duration" placeholder="Duration" required>
                      </div>
                    </div>

                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Daily Rental</label>
                        <input type="text" class="form-control" id="daily_rental" name= "daily_rental" placeholder="0.00" required readonly>
                      </div>
                    </div>

                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" id="end_date" name = "end_date" placeholder="End date" required readonly hidden>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <input type="hidden" name ="submit" value="submit"/>
                      <button type="submit" class="btn btn-primary btn-round">Submit</button>
                      <Input type="button" onclick="form_reset()" class="btn btn-danger btn-round" data-dismiss="modal" value="Close">

                      <?php
                          if(isset($_POST['submit'])){

                            $cust_id          = $_POST['cust_id'];
                            $l_date           = $_POST['l_date'];
                            $l_amt            = $_POST['l_amt'];
                            $interest         = $_POST['interest'];
                            $no_installements = $_POST['no_installements'];
                            $rental           = $_POST['rental'];
                            $duration         = $_POST['duration'];
                            $end_date         = $_POST['end_date'];
                            $daily_rental     = $_POST['daily_rental'];
                           
                            $year =  date("Y");
                            $month = date("m");
                            $createDate = date("Y-m-d");

                            //Get Final End Date 

                            $loan_type    = $_POST['loan_type'];
                            $loan_method    = $_POST['loan_method'];

                            $dateBegin = date('Y-m-d', strtotime($_POST['l_date']));
                            $dateEnd = date('Y-m-d', strtotime($_POST['end_date']));
                             
                             //Get Poyadays ------------------ Start
                             $poyadays = 0;
                             $spDates=mysqli_query($con,"SELECT * FROM special_days");
                             while($row = mysqli_fetch_assoc($spDates)) {

                                  $getDate = $row['poyaday'];
                                  if (($getDate >= $dateBegin) && ($getDate <= $dateEnd)){
                                       $poyadays = $poyadays +1;
                                  }
                             }
                            //Get Poyadays ------------------ End
                            //Get Sundays ------------------ Start
                            $sundays = 0;
                            $start = new DateTime($dateBegin);
                            $end = new DateTime($dateEnd);
                            $days = $start->diff($end, true)->days;

                            $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
                            //Get Sundays ------------------ End

                            $sunAndpoyaday = 0;
    
                            while ($start <= $end) {
                                if ($start->format('w') == 0) {
                                    $spDates=mysqli_query($con,"SELECT * FROM special_days");
                                    while($row = mysqli_fetch_assoc($spDates)) {
                                        $getDate = $row['poyaday'];
                                        if ($start->format('Y-m-d') == $getDate){
                                            $sunAndpoyaday = $sunAndpoyaday +1;
                                        }
                                    }
                                }
                                $start->modify('+1 day');
                            }

                            //////////////////////////
                            if($loan_type =="daily" && $loan_method =="normal"){

                              $end_date  = date('Y-m-d', strtotime($dateEnd. ' + '.$poyadays.' days'));

                            }elseif ($loan_type =="daily" && $loan_method =="sunday off"){

                              $totalDays = $poyadays+$sundays;
                              $end_date  = date('Y-m-d', strtotime($dateEnd. ' + '.$totalDays.' days'));

                            }elseif($loan_type =="weekly" && $loan_method =="normal"){

                              $end_date  = $dateEnd;
                            }elseif($loan_type =="weekly" && $loan_method =="sunday off"){
                              $totaldays = $sunAndpoyaday+$sundays;
                              $end_date = date('Y-m-d', strtotime($dateEnd. ' + '.$totaldays.' days'));
                            }
                            ///////////////summarry query starts///////////

                            $querySummary = "SELECT id ,loanAMT FROM summary WHERE year='$year' AND month='$month' ";
                            $resultSummary = mysqli_query($con ,$querySummary);

                            $countSummary =mysqli_num_rows($resultSummary);

                            if($countSummary>0){

                                while($rowSummary = mysqli_fetch_array($resultSummary)){

                                    $oldLoanAMT = $rowSummary['loanAMT'];
                                    $id = $rowSummary['id'];
                                }

                                $newLoanAMT = ($oldLoanAMT +$l_amt);

                                $queryRow ="UPDATE summary SET loanAMT='$newLoanAMT' WHERE id='$id' ";
                                $rowRow =mysqli_query($con,$queryRow);

                            }else{

                                $query ="INSERT INTO  summary (year,month,loanAMT,createDate)  VALUES (?,?,?,?)";

                                $stmt =mysqli_stmt_init($con);
                                if(!mysqli_stmt_prepare($stmt,$query))
                                {
                                    echo "SQL Error";
                                }
                                else
                                {
                                    mysqli_stmt_bind_param($stmt,"ssss",$year,$month,$l_amt,$createDate);
                                    $result =  mysqli_stmt_execute($stmt);
                                }

                                for ($x = 1; $x < 13; $x++) {
                              
                                    if($month !=str_pad($x, 2, "0", STR_PAD_LEFT)){

                                      $queryDefult ="INSERT INTO  summary (year,month,createDate)  VALUES (?,?,?)";

                                      $stmt =mysqli_stmt_init($con);
                                      if(!mysqli_stmt_prepare($stmt,$queryDefult))
                                      {
                                          echo "SQL Error";
                                      }
                                      else
                                      {
                                          mysqli_stmt_bind_param($stmt,"sss",$year,str_pad($x, 2, "0", STR_PAD_LEFT),$createDate);
                                          $result =  mysqli_stmt_execute($stmt);
                                      }

                                    }
                                }
                            }

                            $insert2 = "INSERT INTO loan (l_date,amount,interest,no_installements,rental,daily_rental,duration,end_date,cust_id,l_status,l_type,l_method) 
                              VALUES ('$l_date',$l_amt,$interest,$no_installements,$rental,$daily_rental,$duration,'$end_date','$cust_id',1,'$loan_type','$loan_method')";                         
                            mysqli_query($con,$insert2);

                          }
                      ?>
                    </div>
                  </div>
                  </div>
                </form>
              </div>
              </div>
              </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="myTable">
                    <thead class="text-primary">
                      <th>                      #           </th>
                      <th>                      Start Date  </th>              
                      <th>                      End Date    </th>
                      <th class="text-right">   Loan Amt    </th>
                      <th class="text-right">   Int (%)     </th> 
                      <th class="text-right">   Rental      </th> 
                      <th class="text-right">   Duration    </th>   
                      <th class="text-center">  Status      </th>
                      <!-- <th class="text-center">  Type        </th>
                      <th class="text-center">  Method      </th> -->
                      <th>                      Customer    </th>
                      <th>                      Penalty    </th>
                      <th class="text-center">  View 				</th>
                      <th class="text-center">  Delete 			</th>
                    </thead>
                    <tbody>
                      <?php
                      $sql=mysqli_query($con,"SELECT * FROM loan ORDER BY loan_no DESC");
                      
                      $numRows = mysqli_num_rows($sql); 
                 
                      if($numRows > 0) {
                        while($row = mysqli_fetch_assoc($sql)) {
                          $loan_no  = $row['loan_no'];
                          $l_date   = strtotime($row['l_date']);
                          $loan_amt = $row['amount'];

                        $check = mysqli_query($con,"SELECT * FROM (SELECT * FROM loan_installement WHERE loan_installement.loan_no = '$loan_no') V ORDER BY V.id DESC LIMIT 1;");

                        $data1 = mysqli_fetch_array($check); 

                        $li_date         = strtotime($data1['li_date']);
                        //$remaining_amt   = $data1['remaining_amt'];
                        $now_date        = time();

                        // if(empty($remaining_amt))
                        // {
                        //    $pre_date   = $l_date;  
                        //    $remain_amt = $loan_amt;
                        //    $Days = round(($now_date-$pre_date) / (60 * 60 * 24));
                        //    $remain_amount = ($remain_amt + ($interest*$Days));
                        // }
                        // else if($remaining_amt==0){
                        //    $Days = 0;
                        //    $remain_amount = 0.00;
                        // }
                        // else
                        // {
                        //    $pre_date   = $li_date;
                        //    $remain_amt = $remaining_amt;
                        //    $Days = round(($now_date-$pre_date) / (60 * 60 * 24));
                        //    $remain_amount = ($remain_amt + ($interest*$Days));
                        // }

                        $l_status = $row['l_status'];
                        if($l_status==1){
                          $view_satus = "Active";
                        }else{
                          $view_satus = "Closed";
                        }  
                          $cust_id = $row['cust_id'];
                          $customer = mysqli_query($con, "SELECT * FROM customer WHERE cust_id = '$cust_id'");
                          $cust_data = mysqli_fetch_assoc($customer);

                          ?>
                        
                    <tr>
                      <td>                   <?php echo $row['loan_no']?>  </td>
                      <td>                   <?php echo $row['l_date']?>   </td>
                      <td>                   <?php echo $row['end_date']?>   </td>
                      <td class="text-right"><?php echo number_format($row['amount'],2)?>  </td>
                      <td class="text-right"><?php echo $row['interest']?> </td>
                      <td class="text-right"><?php echo number_format($row['rental'],2)?> </td>
                      <td class="text-right"><?php echo $row['duration']?> </td>
                      <td class="text-center"><?php echo $view_satus; ?> </td>
                    <!-- <td class="text-center"><?php // echo $row['l_type'] ?> </td>
                    <td class="text-center"><?php // echo $row['l_method'] ?> </td> -->
                      <td>                    <?php echo $cust_data['name'] ?>  </td>

                      <td class="text-center">  
                        <a href="#" onclick="add(<?php echo $row['loan_no']; ?>)" name="edit">
                        <i class="fa fa-plus" aria-hidden="true"></i></a>
                      </td>

                      <td class="text-center">  
                        <a href="#" onclick="editView(<?php echo $row['loan_no']; ?>)" name="edit">
                        <i class="fa fa-eye" aria-hidden="true"></i></a>
                      </td>

                      <td class="text-center">  
                        <a href="#" onclick="confirmation('event','<?php echo $row['loan_no']; ?>')"  name="delete">
                        <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                    </tbody>
                           <?php
                        }
                      }
                    ?>                      
                    </table>
                  <?php
                  mysqli_close($con);
                  ?>
                </div>
              </div>
              </div>
            </div>
          </div>
          </div>
        </div>

        </div>
      </div>
      <!-- FOOTER -->
       <?php include('include/footer.php');  ?>
      <!-- FOOTER -->
    </div>
  </div>


  <div id="show_view">

  </div>

  <?php include('include/footer_js.php');  ?>

<script>

  ////////////////////////////  DataTable ////////////////////////////
  $(document).ready( function () {
      $('#myTable').DataTable();
  });

  /////////////////////////////////////// Table Search ///////////////////////////
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

  /////////////////CHECK IF THE CUSTOMER LOAN EXIST//////////////////////////
  $('#customer_loan').on('change', function() {

    $.ajax({
      url: 'cust_loan_verify.php',
      method:"POST",
      data:{cust_id:this.value},
      success: function (response) {//response is value returned from php 
        //alert(data)
        //$('#show').html(response);
        $("#show").removeAttr('class');
        if(response==1){
           $('#show').html("");
           $("#show").css({"color": "green"});
        }else{
           $('#show').html("Already You have a loan");
           $("#show").css({"color": "red"});
           setTimeout(function(){ $("#customer_loan").val("");  $('#show').html("") }, 1500);
        }
        $("#show").css({"padding": "5px" , "font-size":"small"});
      }
    });
  });  

  /////////// calculate rental when keyup //////////////////// 
  $('.customerAmt').on('keyup',function(){
      customerAmt()
  });

  function customerAmt(){

    var amount = $('#amount').val();
    var int  = $('#int').val();
    var no  = $('#no_installements').val();
    var interest;
    var rental;

    interest = (Number(amount)*(Number(int)/100)*no)/30;
    rental = Number(amount)+Number(interest);
    
    $('#rental').val(rental.toFixed(2));
  
  } 

  /////////// no_installements onchange //////////////////// 
  $('#no_installements').on('keyup',function(){

    /////////////////calculate rental///////////////
    var type_value;

    if (document.getElementById('t1').checked) {
      type_value = document.getElementById('t1').value;
    }
    else if(document.getElementById('t2').checked) {
      type_value = document.getElementById('t2').value;
    }

    var amount = $('#amount').val();
    var int  = $('#int').val();
    var no  = $('#no_installements').val();
    var duration;
    var interest;
    var rental;
    var daily_rental;

    if(type_value=='weekly'){
      interest = (Number(amount)*(Number(int)/100)*no)/4;
      rental = (Number(amount)+Number(interest))/no;
      duration = Number(no) * 7;
      daily_rental = Math.ceil(Number(rental)/7);
    }else{
      interest = (Number(amount)*(Number(int)/100)*no)/30;
      rental = (Number(amount)+Number(interest))/no;
      duration = Number(no);
      daily_rental = rental;
    }


    $('#daily_rental').val(daily_rental.toFixed(2));
    $('#rental').val(rental.toFixed(2));

    $('#duration').val(duration);

    ///////////////calc end date //////////////////
    var start_date = $('#l_date').val();

    const date = new Date(start_date);
    date.setDate(date.getDate() + Number(duration)+1);  

    const zeroPad = (num, places) => String(num).padStart(places, '0') 
  
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var y = date.getFullYear();

    var end_date = zeroPad(mm, 2) + '/'+ zeroPad(dd, 2) + '/'+ y;

    $('#end_date').val(end_date);

  });

  $('#rental').on('keyup',function(){

    var amount = $('#amount').val();
    var int  = $('#int').val();
    var no  = $('#no_installements').val();
    var rental  = $('#rental').val();
    var interest;
    var duration;

    interest = (Number(amount)*(Number(int)/100)*no)/30;
    duration = (Number(amount)+Number(interest))/rental;

    $('#duration').val(duration);

    //////////////////create end date //////////////////
    var start_date = $('#l_date').val();

    const date = new Date(start_date);
    date.setDate(date.getDate() + Number(duration)+1);  

    const zeroPad = (num, places) => String(num).padStart(places, '0') 
  
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var y = date.getFullYear();

    var end_date = zeroPad(mm, 2) + '/'+ zeroPad(dd, 2) + '/'+ y;

    $('#end_date').val(end_date);

  });

  $('#duration').on('keyup',function(){

    var amount = $('#amount').val();
    var int  = $('#int').val();
    var no  = $('#no_installements').val();
    var duration  = $('#duration').val();
    var interest;
    var rental;

    interest = (Number(amount)*(Number(int)/100)*no)/30;
    rental = (Number(amount)+Number(interest))/duration;
    
    $('#rental').val(rental);

    //////////////////create end date //////////////////
    var start_date = $('#l_date').val();

    const date = new Date(start_date);
    date.setDate(date.getDate() + Number(duration)+1);  

    const zeroPad = (num, places) => String(num).padStart(places, '0') 
  
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var y = date.getFullYear();

    var end_date = zeroPad(mm, 2) + '/'+ zeroPad(dd, 2) + '/'+ y;

    $('#end_date').val(end_date);
  });

  ///////////////////////////////////////////////////

  $(function () {

      $('#loanAdd').on('submit', function (e) {

        e.preventDefault();

        var customer_loan = $('#customer_loan').val();

        if(customer_loan=='0'){
          alert('Submission Failed.Required Field is Empty.');
        }else{

        $.ajax({
          type: 'post',
          url: 'customer_loan.php',
          data: $('#loanAdd').serialize(),
          success: function (data) {
            swal({
              title: "Good job !",
              text: "Successfully Submited",
              icon: "success",
              button: "Ok !",
              });
              setTimeout(function(){ location.reload(); }, 2500);
             }
        });
        }

      });

    });

  
  ///////// Form values reset /////////
  function form_reset(){
    document.getElementById("loanAdd").reset();
  }

  ////////// Add penalty fee ////////////
  function add(id){

    $.ajax({
            url:"edit_loan.php",
            method:"POST",
            data:{"id":id},
            success:function(data){
              $('#show_view').html(data);
              $('#PenaltyForm').modal('show');
            }
      });
  }

  ////////// Form edit ////////////
  function editView(id){

    $.ajax({
            url:"edit_loan.php",
            method:"POST",
            data:{"id":id},
            success:function(data){
              $('#show_view').html(data);
              $('#Form2').modal('show');
            }
      });
  }

  // Form delete 
  function delete_loan(id){

    $.ajax({
            url:"delete_loan",
            method:"POST",
            data:{"id":id},
            success:function(data){
                swal({
                title: "Good job !",
                text: data,
                icon: "success",
                button: "Ok !",
                });
                setTimeout(function(){ location.reload(); }, 2500);
    
            }
      });
  }

  // delete confirmation javascript
  function confirmation(e,id) {
      swal({
      title: "Are you sure?",
      text: "Want to Delete this recode !",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
             delete_loan(id)
          } 
      });
  }
  ////////////////////  
   
  </script>

</body>

</html>
<?php
}
?>