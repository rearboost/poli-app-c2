<?php

   include("db_config.php");
    $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }

    $id = $_POST['id']; // get id through query string

    $qry = mysqli_query($con,"SELECT * FROM customer WHERE cust_id='$id' "); // select query

    $data = mysqli_fetch_array($qry); // fetch data

    if(isset($_POST['update'])) // when click on Update button
    {
        $cust_id     = $_POST['c_id1'];
        $type        = $_POST['type1'];
        $reg_no      = $_POST['cust_reg1'];
        $name        = $_POST['name1'];
        $address     = $_POST['address1'];
        $vehicle_no  = $_POST['reg_no1'];
        $contact     = $_POST['contact1'];
      
        $edit = mysqli_query($con,"UPDATE customer 
                                          SET name  ='$name', 
                                              reg_no ='$reg_no', 
                                              address ='$address', 
                                              vehicle_no ='$vehicle_no', 
                                              contact ='$contact' 
                                          WHERE cust_id='$cust_id'");
      
        if($edit)
        {
            mysqli_close($con); // Close connection
            header("location:customer.php"); // redirects to all records page
            exit;
        }
        else
        {
            echo mysqli_error();
        }     
    }              
?>

<div class="card-body">
  <div class="modal fade" id="Form3" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">UPDATE CUSTOMERS</h5>
        </div> 

        <form  id="customerEdit" >
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Customer ID</label>
                  <input type="text" class="form-control" name ="c_id1" value="<?php echo $data['cust_id']?>" readonly>
                </div>
              </div>     
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Customer Type</label>
                    <input type="text" class="form-control" name ="type1" value="<?php echo $data['type']?>" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Customer Registration No</label>
                  <input type="text" class="form-control" name ="cust_reg1" value="<?php echo $data['reg_no']?>">
                </div>
              </div>  
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" name ="name1" value="<?php echo $data['name']?>">
                </div>
              </div>                 
            </div>

            <div class="row">         
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" name ="address1" value="<?php echo $data['address']?>">
                </div>
              </div>
            </div>

            <div class="row">                  
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Vehicle Reg_no</label>
                  <input type="text" class="form-control" name = "reg_no1" value="<?php echo $data['vehicle_no']?>">
                </div>
              </div>                 
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Contact No</label>
                  <input type="text" class="form-control" placeholder="Mobile / Land" name = "contact1" value="<?php echo $data['contact']?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="update ml-auto mr-auto">
                <input type="hidden" name ="update" value="update"/>
                <button type="submit" name="update" class="btn btn-primary btn-round">Update</button>
                <button type="reset" name="close" class="btn btn-danger btn-round" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>

   ///////////////////////////////////////////////////

    $(function () {

        $('#customerEdit').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'edit_customer.php',
            data: $('#customerEdit').serialize(),
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