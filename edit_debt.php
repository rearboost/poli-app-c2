<?php

include("db_config.php");
  $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }

    $id = $_POST['id']; // get id through query string

    $qry = mysqli_query($con,"SELECT * FROM loan,loan_installement WHERE loan.loan_no = loan_installement.loan_no AND id=$id "); // select query

    $data = mysqli_fetch_array($qry); // fetch data

    if(isset($_POST['update'])) // when click on Update button
    {

        $i_id               = $_POST['i_id1'];
        $li_date            = $_POST['li_date1'];
        $amt                = $_POST['amt1'];
        $installement_amt   = $_POST['i_amt1'];
        $interest_amt       = $_POST['int_amt1'];
        $remaining_amt      = $_POST['remain_amt1'];
        $r_int              = $_POST['r_int1'];
        $cust_id            = $_POST['cust_id1'];

      
        $edit = mysqli_query($con,"UPDATE loan_installement  
                                     SET paid     =$amt
                                  WHERE id=$i_id ");
      
        if($edit)
        {
            mysqli_close($con); // Close connection
            header("location:debt_collection.php"); // redirects to all records page
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
          <h5 class="modal-title" id="staticBackdropLabel">UPDATE DEBT COLLECTIONS</h5>
        </div> 

        <form id="debtEdit">
          <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                  <input type="hidden" class="form-control" name = "i_id1" value = "<?php echo $data['id'] ?>" >
                </div>
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Customer</label> 
                  <input type="text" class="form-control" id="cust_id1" name = "cust_id1" disabled="" value = "<?php echo $data['cust_id'] ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Date</label>
                  <input type="date" class="form-control" id="li_date1" name = "li_date1" value = "<?php echo $data['li_date'] ?>" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Amount</label>
                  <input type="text" class="form-control checkAmt1" id="amt1" name="amt1" value = "<?php echo $data['paid'] ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Installment amount</label>
                  <input type="text" class="form-control" placeholder="LKR" id="inst_amt1" name = "i_amt1" value = "<?php echo $data['installement_amt'] ?>" disabled>
                </div>
              </div>              
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Interest amount</label>
                  <input type="text" class="form-control" placeholder="LKR" id="int_amount1" name = "int_amt1" value = "<?php echo $data['interest_amt'] ?>" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Remaining amount</label>
                  <input type="text" class="form-control" id="remain_amt1" name = "remain_amt1" value = "<?php echo $data['remaining_amt'] ?>" disabled>
                  <input type="hidden" class="form-control" id="r_int1" name = "r_int1" readonly required>
                </div>
              </div>
              <div class="col-md-6 pr-3">
                <div class="form-group">
                  <label>Loan Amount</label>
                  <input type="text" class="form-control" id="l_amt1" name = "l_amt1" disabled = "" value = "<?php echo $data['amount'] ?>">
                </div>
              </div>
            </div>                  
            <div class="row">
              <div class="update ml-auto mr-auto">
                <input type="hidden" name ="update" value="update"/>
                <button type="submit" class="btn btn-primary btn-round">Update</button>
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

    // fetch no.of days when select the date
  // $('#li_date1').on('change', function() {

  //     var customer_id = $('#cust_id1').val();

  //     $.ajax({
  //       url: 'remain_amt.php',
  //       method:"POST",
  //       data:{id:customer_id},
  //       success: function (response) {
  //         var obj = JSON.parse(response);
  //         var pre_date  =  obj.pre_date
  //         var now_date  =  $('#li_date1').val();

  //         const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
  //         const firstDate = new Date(pre_date);
  //         const secondDate = new Date(now_date);

  //         const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));

  //         $('#days1').val(diffDays);
  //         $('#amt1').prop('disabled', false);
  //       }
  //     });
  //   }); 
  /////////////////////////////////////////

    ////////////////////  Update the Functions

    // $('.checkAmt1').on('keyup',function(){
    //     checkAmt1()
    // })

    // function checkAmt1(){
    //   var amount = $('#amt1').val();
    //   var days   = $('#days1').val();
    //   var installement_amt;
    //   var interest_amt;
    //   var remain_int;
    //   var remain_amt;
    //   var id =  $('#cust_id1').val();

    //   $.ajax({
    //     url: 'remain_amt.php',
    //     method:"POST",
    //     data:{id:id},
    //     success: function (response) {

    //       var obj = JSON.parse(response);
    //      // $('#remain_amt').val(obj.remain_amt);
    //       var remain_amt      =  obj.remain_amt
    //       var remain_int      =  obj.remain_int
    //       var loan            =  obj.loan_amt
    //       var daily_interest  =  obj.interest

    //       interest_amt = (Number(daily_interest) * Number(days));
      
    //       if(amount>=interest_amt){
    //         installement_amt = Number(amount) - Number(interest_amt);
    //         remain_int       = Number(0.00);
    //         remain_amt       = Number(remain_amt) - Number(installement_amt);  
    //       }else{
    //         installement_amt = Number(0.00);
    //         remain_int       = Number(interest_amt) - Number(amount);
    //         remain_amt       = Number(remain_amt) + Number(remain_int);  
    //       } 
      
    //        $('#int_amount1').val(interest_amt.toFixed(2));
    //        $('#inst_amt1').val(installement_amt.toFixed(2));
    //        $('#remain_amt1').val(remain_amt.toFixed(2));
    //        $('#r_int1').val(remain_int.toFixed(2));
    //     }

    //   });
    // }

     $(function () {

        $('#debtEdit').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'edit_debt.php',
            data: $('#debtEdit').serialize(),
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