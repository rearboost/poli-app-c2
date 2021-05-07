<?php

   include("db_config.php");
   $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }

    $id = $_POST['id']; // get id through query string

    $qry = mysqli_query($con,"SELECT * FROM loan L INNER JOIN customer C ON L.cust_id=C.cust_id WHERE loan_no =  $id  "); // select query
    $data = mysqli_fetch_array($qry); // fetch data

    $qry2 = mysqli_query($con,"SELECT brought_forward FROM loan_installement WHERE loan_no=$id ORDER BY id DESC LIMIT 1"); // select query
    $data2 = mysqli_fetch_array($qry2);

    if(isset($_POST['update'])) // when click on Update button
    {
        $no               = $_POST['no'];
        $p_status         = $_POST['p_status'];
        $penalty          = $_POST['penalty'];
        $brought_forward  = $_POST['brought_forward'];

        ///////////////summarry query starts///////////

        $year =  date("Y");
        $month = date("m");
        $createDate = date("Y-m-d");

        $querySummary = "SELECT id ,loanAMT FROM summary WHERE year='$year' AND month='$month' ";
        $resultSummary = mysqli_query($con ,$querySummary);

        $countSummary =mysqli_num_rows($resultSummary);

        if($countSummary>0){

            while($rowSummary = mysqli_fetch_array($resultSummary)){

                $oldLoanAMT = $rowSummary['loanAMT'];
                $id = $rowSummary['id'];
            }

            $newLoanAMT = ($oldLoanAMT +$penalty);

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
                mysqli_stmt_bind_param($stmt,"ssss",$year,$month,$penalty,$createDate);
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

        ///////////// Summary query end ///////////////

        $edit = mysqli_query($con,"UPDATE loan 
                                  SET penalty_status ='$p_status', 
                                      penalty        ='$penalty'
                                  WHERE loan_no=$no");

        $Update_forward = mysqli_query($con,"UPDATE loan_installement 
                                  SET brought_forward ='$brought_forward'
                                  WHERE loan_no=$no");
      
        if($edit)
        {
            mysqli_close($con); // Close connection
            header("location:customer_loan.php"); // redirects to all records page
            exit;
        }
        else
        {
            echo mysqli_error();
        }     
    }              
?>


<div class="card-body">
  <div class="modal fade" id="Form2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">VIEW CUSTOMER LOANS</h5>
        </div> 
        <form id="loanEdit">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-5 pr-3">
                <div class="form-group">
                  <input type="text" name="no" class="form-control" value="<?php echo $data['loan_no']?>" hidden>           
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group" style="border:2px solid; border-radius: 10px; padding: 10px; border-color: #ccccb3;">
                  <label>Loan Type </label> <br>
                  <input type="radio" name="loan_type" <?php if($data['l_type']=="daily"){echo "checked";}?> value="daily"> Daily &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="loan_type" <?php if($data['l_type']=="weekly"){echo "checked";}?> value="weekly"> Weekly
                </div>
              </div>

              <div class="col-md-6 pr-3">
                <div class="form-group" style="border:2px solid; border-radius: 10px; padding: 10px; border-color: #ccccb3;">
                  <label>Payment Method</label> <br>
                  <label><input type="radio" name="loan_method" <?php if($data['l_method']=="normal"){echo "checked";}?> value="normal"> Normal
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="loan_method" <?php if($data['l_method']=="sunday off"){echo "checked";}?> value="sunday off"> Sunday Off
                  </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Customer</label>
                  <input type="text" name="cust_id" class="form-control" value="<?php echo $data['cust_id']?>">           
                </div>
              </div>
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Date of obtaining loan</label>
                  <input type="date" name="l_date" class="form-control" value="<?php echo $data['l_date']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Loan Amount</label>
                  <input type="text" class="form-control customerAmt1" placeholder="LKR" id="amount1" name = "l_amt" value="<?php echo $data['amount']?>">
                </div>
              </div>
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>End Date</label>
                  <input type="text" class="form-control" id="end_date" name = "end_date" placeholder="End date" value="<?php echo $data['end_date']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Rental</label>
                  <input type="text" class="form-control" id="rental" name = "rental" value="<?php echo $data['rental']?>">
                </div>
              </div>
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Daily Rental</label>
                  <input type="text" class="form-control" id="daily_rental" name="daily_rental" placeholder="0.00" value="<?php echo $data['daily_rental']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 pr-3">
                <div class="form-group">
                  <label>Interest (%)</label>
                  <input type="text" class="form-control customerAmt1" placeholder="Interest" id="int1" name = "interest" value="<?php echo $data['interest']?>">
                </div>
              </div>
              <div class="col-md-4 pr-3">
                <div class="form-group">
                  <label>Installements</label>
                  <!-- <select class="form-control" id="no_installements" name = "no_installements" readonly>
                    <option selected="" disabled=""><?php // echo $data['no_installements']?></option>
                    <option value="60">60</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                  </select> -->
                  <input type="text" class="form-control" id="no_installements" name="no_installements" value="<?php echo $data['no_installements']?>">
                </div>
              </div>
              <div class="col-md-4 pr-3">
                <div class="form-group">
                  <label>Duration</label>
                  <input type="text" class="form-control" id="duration" name = "duration" placeholder="Duration" value="<?php echo $data['duration']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="update ml-auto mr-auto">
                <button type="reset" name="close" class="btn btn-danger btn-round" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </form>
      </div><!-- modal content end-->
    </div>
  </div>
</div>

<!--  penalty form  -->
<div class="card-body">
  <div class="modal fade" id="PenaltyForm" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Penalty Fee</h5>
        </div> 
        <form id="add">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-5 pr-3">
                <div class="form-group">
                  <input type="text" name="no" id="no" class="form-control" value="<?php echo $data['loan_no']?>" hidden>           
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Customer</label>
                  <input type="text" name="cust_id" class="form-control" value="<?php echo $data['cust_id'] . ' | ' . $data['name']?>" readonly>
                </div>
              </div>
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Brought Forward</label>
                  <input type="text" name="brought_forward" id="brought_forward" class="form-control" value="<?php echo $data2['brought_forward']?>" readonly>
                </div>
              </div>
            </div>

            <div class="row" style="border:2px solid; border-radius: 10px; padding: 10px; border-color: #ccccb3; margin: 0px 2px 0px 2px;">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Penalty Status </label> <br>
                  <input type="radio" name="p_status" id="deactive" <?php if($data['penalty_status']=="0"){echo "checked";}?> value="0"> None &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="p_status" id="active" <?php if($data['penalty_status']=="1"){echo "checked";}?> value="1"> Active
                </div>
              </div>

              <div class="col-md-6 pr-3">
                  <label>Penalty Fee</label> <br>
                  <input class="form-control" type="text" name="penalty" id="penalty" value="<?php echo $data['penalty']?>">
                </div>
            </div>

            <div class="row">
              <div class="update ml-auto mr-auto">
                <input type="hidden" name ="update" value="update"/>
                <button type="submit" name="update" class="btn btn-primary btn-round">Add</button>
                <button type="reset" name="close" class="btn btn-danger btn-round" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </form>
      </div><!-- modal content end-->
    </div>
  </div>
</div>


<script>
    
    ///////////////////////////////////////////////////

    $('#penalty').on('keyup',function(){

      var loan_no = $('#no').val();

      $.ajax({
        url: 'get_forwardBal.php',
        method:"POST",
        data:{loan_no:loan_no},
        success: function (response) {//response is value returned from php 

          var obj = JSON.parse(response);

          var penalty = $('#penalty').val();
          var forward  = obj.brought_forward

          var new_forward = (Number(penalty)+Number(forward));
        
          $('#brought_forward').val(new_forward);
        }
      });
    });

    $(function () {

        $('#add').on('submit', function (e) {

          e.preventDefault();

          var status;

          if (document.getElementById('deactive').checked) {
            status = document.getElementById('deactive').value;
          }
          else if(document.getElementById('active').checked) {
            status = document.getElementById('active').value;
          }

          var value = $('#penalty').val();

          if(status=='1' && value==0.00){
            alert('Please fill the penalty fee before update.');
          }else if(status=='0' && value!=0.00) {
            alert('Please check the penalty status.');
          }else{

          $.ajax({
            type: 'post',
            url: 'edit_loan.php',
            data: $('#add').serialize(),
            success: function () {
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
    

</script>