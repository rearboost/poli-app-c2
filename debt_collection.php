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
                <h4 class="card-title"> DEBT COLLECTION WITH INTEREST</h4>     
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
                    <h5 class="modal-title" id="staticBackdropLabel">Debt Collection</h5>
                  </div>
                <form id="collectionDebt">
                  <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Customer</label>
                          <select class="form-control form-selectBox" id="custom_id" name="id" required>
                            <option value="default">--Select Customer--</option>
                            <?php

                              $custom = "SELECT C.cust_id AS cust_id  , C.name AS name
                                          FROM customer C 
                                          INNER JOIN  loan L
                                          ON C.cust_id = L.cust_id
                                          WHERE L.l_status = 1;";

                                $result1 = mysqli_query($con,$custom);
                                $numRows1 = mysqli_num_rows($result1); 
                 
                                  if($numRows1 > 0) {
                                    while($row1 = mysqli_fetch_assoc($result1)) {
                                      echo "<option value = ".$row1['cust_id'].">" . $row1['cust_id'] . " | " . $row1['name'] . "</option>";
                                      
                                    }
                                  }
                            ?>
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <?php

                          $print = mysqli_query($con,"SELECT * FROM loan_installement ORDER BY id DESC LIMIT 1");
                          $row_print = mysqli_fetch_assoc($print);

                        ?>
                        <input type="hidden" id="nextId" name="nextId" value ='<?php echo $row_print['id']+1; ?>'>
                        <label>Loan Amount</label>
                        <input type="text" class="form-control" id="loan_amt" name = "l_amt" disabled = "" id = "loan_amount" placeholder="LKR. 0.00" readonly required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control available" id="li_date" name = "li_date" required disabled="">
                      </div>
                    </div>

                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Brought Forward</label>
                        <input type="text" class="form-control" id="brought_forward" name="brought_forward" placeholder="LKR. 0.00" required readonly="">
                      </div>
                    </div>
                  </div>

                  <p id="expiry_msg" style="color: red;" hidden> * The loan end date has been expired. Consider about the penalty fee.</p>

                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Today Paid</label>
                        <input type="text" class="form-control checkAmt" placeholder="LKR 0.00" id="paid" name="paid" required disabled>
                      </div>
                    </div>
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Rental</label>
                        <input type="text" class="form-control" placeholder="LKR 0.00" id="rental" name = "rental" required disabled>
                      </div>
                    </div>
                  </div>
                    <!-- hidden area open-->
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <input type="text" class="form-control" id="type" name = "type" required readonly placeholder="type" hidden> 
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input type="text" class="form-control" id="method" name = "method" required readonly placeholder="method" hidden>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input type="text" class="form-control" id="days" name = "day" required readonly placeholder="days" hidden>
                      </div>
                    </div>
                    <div class="col-md-3 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="pre" id="pre_date" name = "pre_date" required readonly hidden>
                      </div>
                    </div>
                    <div class="col-md-3 pr-3">
                      <div class="form-text">
                        <input type="text" class="form-control" placeholder="now" id="now_date" name = "now_date" required readonly hidden>
                      </div>
                    </div>
                    <div class="col-md-3 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="sunday" id="sunday" name = "sunday" required readonly hidden>
                      </div>
                    </div>
                    <div class="col-md-3 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="poyaday" id="poyaday" name = "poyaday" required readonly hidden>
                      </div>
                    </div>
                    <div class="col-md-3 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="newdays" id="newdays" name = "newdays" required readonly hidden>
                      </div>
                    </div>
                    <div class="col-md-2 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="No" id="duration" name = "duration" required readonly  hidden>
                      </div>
                    </div>
                    <div class="col-md-4 pr-3">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="amount" id="amount" name = "amount" required readonly hidden>
                      </div>
                    </div>
                    <!-- hidden area close-->
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Total Paid</label>
                        <input type="text" class="form-control" placeholder="LKR 0.00" id="total_paid" name="total_paid" required readonly>
                      </div>
                    </div>               
                    <div class="col-md-6 pr-3">
                      <div class="form-group">
                        <label>Arreares / Addition(-)</label>
                        <input type="text" class="form-control" placeholder="LKR 0.00" id="arreares" name="arreares" required readonly>
                      </div>
                    </div>
                  </div>
                  <!-- <p id="penalty_msg" style="color: red;" hidden>* A penalty fee has to be paid as the due date for the loan has expired.</p> -->
                                
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <input type="hidden" name ="submit" value="submit"/>
                      <button type="submit" class="btn btn-primary btn-round" >Submit</button>
                      <Input type="button" onclick="form_reset()" class="btn btn-danger btn-round" data-dismiss="modal" value="Close">

                      <?php
                          if(isset($_POST['submit'])){

                            $custom_id       = $_POST['id'];
                            $li_id           = $_POST['nextId'];
                            $li_date         = $_POST['li_date'];
                            $paid            = $_POST['paid'];
                            $arreares        = $_POST['arreares'];
                            $total_paid      = $_POST['total_paid'];
                            $brought_forward = $_POST['brought_forward'];

                            if($arreares == ''){
                              echo "Required field is empty.";
                            }else{
                            $date = explode('-', $li_date);

                            $debt_year  = $date[0];
                            $debt_month = $date[1];

                            $year =  date("Y");
                            $month = date("m");
                            $createDate = date("Y-m-d");
                  
                            $querySummary = "SELECT id ,debtAMT FROM summary WHERE year='$year' AND month='$month' ";
                            $resultSummary = mysqli_query($con ,$querySummary);

                            $countSummary =mysqli_num_rows($resultSummary);

                            if($countSummary>0){

                                while($rowSummary = mysqli_fetch_array($resultSummary)){

                                    $oldDebtAMT = $rowSummary['debtAMT'];
                                    $id = $rowSummary['id'];
                                }

                                $newDebtAMT = ($oldDebtAMT +$paid);

                                $queryRow ="UPDATE summary SET debtAMT='$newDebtAMT' WHERE id='$id' ";
                                $rowRow =mysqli_query($con,$queryRow);

                            }else{

                                $query ="INSERT INTO  summary (year,month,debtAMT,createDate)  VALUES (?,?,?,?)";

                                $stmt =mysqli_stmt_init($con);
                                if(!mysqli_stmt_prepare($stmt,$query))
                                {
                                    echo "SQL Error";
                                }
                                else
                                {
                                    mysqli_stmt_bind_param($stmt,"ssss",$year,$month,$paid,$createDate);
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

                          $data = mysqli_query($con,"SELECT l.loan_no, l.amount FROM customer c , loan l WHERE c.cust_id = l.cust_id AND l.cust_id = '$custom_id' AND l.l_status = 1");
                              $row_l = mysqli_fetch_assoc($data);
                              $loan_no = $row_l['loan_no'];
                              $loan_amount = $row_l['amount'];

                          $insert = "INSERT INTO loan_installement (id,li_date,month,year,paid,arrears, total_paid,brought_forward,loan_no) VALUES ($li_id,'$li_date','$debt_month','$debt_year',$paid,$arreares,$total_paid,$brought_forward,$loan_no)";
                          mysqli_query($con,$insert);

                          if($brought_forward <= 0){
                            $update_status = mysqli_query($con,"UPDATE loan SET l_status =0, penalty_status=0 WHERE loan_no=$loan_no");
                          }

                            }


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
                  	  <th>                    ID 				      </th>
                      <th>                    Date            </th>
                      <th class="text-right"> Paid amt        </th>
                      <th class="text-right"> Arreares        </th>
                      <th class="text-right"> Total paid      </th>
                      <th class="text-right"> Brought Forward	</th>
                      <th>                    Customer        </th>
                      <th class="text-center">Delete          </th>
                      <th class="text-center">Print 			    </th>
                    </thead>
                    <tbody>
                      <?php
                      $sql="SELECT * FROM loan_installement ORDER BY id DESC";
                      
                      $result = mysqli_query($con,$sql);
                      $numRows = mysqli_num_rows($result); 
                 
                      if($numRows > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          $loan_no = $row['loan_no'];

                          $customer = mysqli_query($con,"SELECT * FROM loan L INNER JOIN customer C ON C.cust_id=L.cust_id WHERE L.loan_no='$loan_no' ");
                          $cust_data = mysqli_fetch_assoc($customer);

                      ?>   
                        <tr>
                        <td>                    
                          <?php echo $row['id']  ?>             
                        </td>
                        <td>                    
                          <?php echo $row['li_date']  ?>        
                        </td>
                        <td class="text-right"> 
                          <?php echo number_format($row['paid'],2)?>             
                        </td>
                        <td class="text-right"> 
                          <?php echo number_format($row['arrears'],2) ?>         
                        </td>
                        <td class="text-right"> 
                          <?php echo number_format($row['total_paid'],2)?>       
                        </td>
                        <td class="text-right"> 
                          <?php echo number_format($row['brought_forward'],2) ?> 
                        </td>
                        <td> 
                          <?php echo  $cust_data['name']; ?>        
                        </td>
                       
                      	<td class="text-center">  
                        	<a href="#" onclick="confirmation('event','<?php echo $row['id']; ?>')" name="delete">
                        	<i class="fa fa-trash-o" aria-hidden="true"></i></a>
                      	</td>
                        <td class="text-center">  
                        	<a href="#" onclick="printView(<?php echo $row['id']; ?>)" name="print">
                          <i class="fa fa-print" aria-hidden="true"></i></a>
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

  /////////////////////////////////////// Table Search 
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
  ///////////////////////////////////////////

  // fetch remain amount and loan amount from remain_amt.php
  $('#custom_id').on('change', function() {

      $.ajax({
        url: 'remain_amt.php',
        method:"POST",
        data:{id:this.value},
        success: function (response) {

          var obj = JSON.parse(response);

          var l_type = obj.l_type
          var penalty_status = obj.penalty_status

          $('#type').val(l_type);
          $('#method').val(obj.l_method);
          $('#loan_amt').val(obj.loan_amt);
          $('#brought_forward').val(obj.brought_forward);
          $('#rental').val(obj.rental);
          $('#total_paid').val(obj.total_paid);
          $('#arreares').val(obj.arrears);
          $('#duration').val(obj.duration);

          var pre_date  =  obj.pre_date
          var end_date  =  obj.end_date
          var now_date  =  $('#li_date').val();

          const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
          
          if(now_date<=end_date){
            var day1 = pre_date;
            var day2 = now_date;
          }else{
            var day1 = pre_date;
            var day2 = end_date;

            $('#expiry_msg').prop('hidden', false);
          }

          const firstDate = new Date(day1);
          const secondDate = new Date(day2);

          const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
          
          
          if(l_type=='weekly'){
              var a = diffDays;
              var b = 7;
              var c = a % b;
              var x;
              if(c>=1){
                x = (a - c) / 7;
              }else{
                x = a / b;
              }
              $('#days').val(x);
          }else{
              $('#days').val(diffDays);
          }
          $('#li_date').prop('disabled', false);

          // if(penalty_status==1){
          //   $('#penalty_msg').prop('hidden', false);
          // }else{
          //   $('#penalty_msg').prop('hidden', true);
          // }
        }
      });
  }); 

  ///////////////////////////////////////////

  // fetch no.of days when select the date
  $('#li_date').on('change', function() {

      var customer_id = $('#custom_id').val();
      var type    = $('#type').val();
      var method  = $('#method').val();

      $.ajax({
        url: 'remain_amt.php',
        method:"POST",
        data:{id:customer_id},
        success: function (response) {
          var obj = JSON.parse(response);
          var pre_date  =  obj.pre_date
          var end_date  =  obj.end_date
          var now_date  =  $('#li_date').val();

          $('#pre_date').val(pre_date);// before installement date or loan get date
          $('#now_date').val(now_date);// selected date


          const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
          // alert(now_date)
          // alert(pre_date)
          // alert(end_date)

          if(now_date<=end_date){
            var day1 = pre_date;
            var day2 = now_date;
          }else{
            var day1 = pre_date;
            var day2 = end_date;

            $('#expiry_msg').prop('hidden', false);
          }

            const firstDate = new Date(day1);
            const secondDate = new Date(day2);

          // alert(firstDate)
          // alert(secondDate)

          const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));

          if(type=='weekly' && method=='normal'){
              var a = diffDays;
              var b = 7;
              var c = a % b;
              var x;
                if(c>=1){
                  x = (a - c) / 7;
                }else{
                  x = a / b;
                }
              //$('#days').val(x);
              $('#days').val(a);
                    
          }else{
              $('#days').val(diffDays);
          }

          $('#paid').prop('disabled', false);
        }

      });

}); 

///////// Form values reset /////////
function form_reset(){
  document.getElementById("collectionDebt").reset();
}

//////////////////// 


$('.checkAmt').on('keyup',function(){

  checkAmt()
  $('#expiry_msg').prop('hidden', true);

})

function checkAmt(){

  var paid    = $('#paid').val();
  var days    = $('#days').val();
  var no      = $('#duration').val();
  var amount;

  var new_forward;
  var new_arreares;
  var new_total;

  var poyadays;
  var new_days;
  var id =  $('#custom_id').val();

  //////////////get sundays////////////////////////////
  var method = $('#method').val();
  var start_day = $('#pre_date').val();
  var finish_day = $('#now_date').val();

  var start = new Date(start_day);
  var finish = new Date(finish_day);

  var dayMilliseconds = 1000 * 60 * 60 * 24;
  var weekendDays = 0;
  while (start <= finish) {
    var day = start.getDay()
    if (day == 0) {
      weekendDays++;
    }
    start = new Date(+start + dayMilliseconds);
  }
  $('#sunday').val(weekendDays);

  /////////////////get poyaday///////////////////////////
  $.ajax({
    url: 'get_poyaday.php',
    method:"POST",
    data:{"start_day":start_day,"finish_day":finish_day,"method":method},
    success: function (response) {
        poyadays = Number(response);

      $('#poyaday').val(poyadays);

      /////////calculate days for each type and methods///////////

      var type   = $('#type').val();
      var method = $('#method').val();
      var sun    = $('#sunday').val();
     
      if(type=='weekly' && method=='sunday off')
      {
         //new_days = Number(days)-Number(sun);
              var a = Number(days)-Number(sun);
              var b = 7;
              var c = a % b;
              var x;
                if(c>=1){
                  x = (a - c) / 7;
                }else{
                  x = a / b;
                }
         //new_days = Number(x);
         new_days = Number(a);
      }
      else if(type=='weekly' && method=='normal')
      {
         new_days = Number(days);
      }
      else if(type=='daily' && method=='normal')
      {
         new_days = Number(days)-Number(poyadays);
      }
      else if (type=='daily' && method=='sunday off'){
           new_days = Number(days)-(Number(sun)+Number(poyadays));
      }else{
        new_days = 0;
      }
      $('#newdays').val(new_days);
    }

  });

///////////////////////////////////////////////////////////

  $.ajax({
    url: 'remain_amt.php',
    method:"POST",
    data:{id:id},
    success: function (response) {

      var obj = JSON.parse(response);

      var old_forward  =  obj.brought_forward
      var old_total    =  obj.total_paid
      var old_arreares =  obj.arrears
      var rental       =  obj.rental
      var daily_rental =  obj.daily_rental


      amount = Number(daily_rental)*Number(new_days);

      new_forward  = Number(old_forward)-Number(paid);
      new_total    = Number(old_total)+Number(paid);

      if(old_arreares==0 && paid==amount){
        new_arreares = 0.00;
      }else{
        new_arreares = Number(old_arreares)+(Number(amount)-Number(paid));
      }

      if(isNaN(new_arreares)){
        $('#arreares').val('');
        $('#arreares').prop('required', true);
      }else{
        $('#arreares').val(new_arreares.toFixed(2));      
      }
  
       $('#amount').val(amount.toFixed(2));
       $('#brought_forward').val(new_forward.toFixed(2));
       $('#total_paid').val(new_total.toFixed(2));
    }
  });
}

/////////////// Bill//////////////////// 
function printView(id){
  window.open('debt_collection_print?id='+id, '_blank');
}
/////////////////////

// Form edit 
function editView(id){

  $.ajax({
          url:"edit_debt.php",
          method:"POST",
          data:{"id":id},
          success:function(data){
            $('#show_view').html(data);
            $('#Form2').modal('show');
          }
    });
}
//////////////////// 
 $(function () {

      $('#collectionDebt').on('submit', function (e) {

        e.preventDefault();

        var nextId = $('#nextId').val();

        var arreares = $('#arreares').val();

        if(arreares==''){
          alert('Submission Failed.Required Field is Empty.');
        }else{
          $.ajax({
            type: 'post',
            url: 'debt_collection.php',
            data: $('#collectionDebt').serialize(),
            success: function () {
              swal({
                title: "Good job !",
                text: "Successfully Submited",
                icon: "success",
                button: "Ok !",
                });
                setTimeout(function(){window.open('debt_collection_print?id='+nextId, '_blank'); }, 2500);
                setTimeout(function(){ location.reload(); }, 2500);
            }
          });
        }
      });
  });

////////////////////  

// Form delete 
function delete_debt(id){

  $.ajax({
          url:"delete_debt",
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
           delete_debt(id)
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