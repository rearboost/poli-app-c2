<?php

   include("db_config.php");
   $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }

    $id = $_POST['id']; // get id through query string

    $qry = mysqli_query($con,"SELECT * FROM loan WHERE loan_no =  $id  "); // select query

    $data = mysqli_fetch_array($qry); // fetch data

    // if(isset($_POST['update'])) // when click on Update button
    // {
    //     $no       = $_POST['no'];
    //     $l_date   = $_POST['l_date'];
    //     $l_amt    = $_POST['l_amt'];
    //     $interest = $_POST['interest'];
    //     $int_amt  = $_POST['daily_int'];

    //     $edit = mysqli_query($con,"UPDATE loan 
    //                               SET l_date             ='$l_date', 
    //                                   amount             ='$l_amt', 
    //                                   interest           ='$interest',
    //                                   value_of_interest  ='$int_amt'
    //                               WHERE loan_no=$no");
      
    //     if($edit)
    //     {
    //         mysqli_close($con); // Close connection
    //         header("location:customer_loan.php"); // redirects to all records page
    //         exit;
    //     }
    //     else
    //     {
    //         echo mysqli_error();
    //     }     
    // }              
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
                  <label>Interest (%)</label>
                  <input type="text" class="form-control customerAmt1" placeholder="Interest" id="int1" name = "interest" value="<?php echo $data['interest']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>No: of Installements</label>
                  <select class="form-control" id="no_installements" name = "no_installements">
                    <option selected="" disabled=""><?php echo $data['no_installements']?></option>
                    <option value="60">60</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Rental</label>
                  <input type="text" class="form-control" id="rental" name = "rental" value="<?php echo $data['rental']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Duration</label>
                  <input type="text" class="form-control" id="duration" name = "duration" placeholder="Duration" value="<?php echo $data['duration']?>">
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
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="loan_method" <?php if($data['l_method']=="sunday off"){echo "checked";}?> value="sunday off"> Sunday Off
                  </label><br>
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


<script>

    $('.customerAmt1').on('keyup',function(){
        customerAmt1()
    });

    function customerAmt1(){

      var amount = $('#amount1').val();
      var int  = $('#int1').val();

      var daily_interest;
      

        daily_interest = (Number(amount)*(Number(int)/100))/30;
      
      $('#daily_int1').val(daily_interest.toFixed(2));
    
    } 

    
    ///////////////////////////////////////////////////

    $(function () {

        $('#loanEdit').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'edit_loan.php',
            data: $('#loanEdit').serialize(),
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

        });

      });
    

</script>