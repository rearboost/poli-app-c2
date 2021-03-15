
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

</body>
</html>


      
<?php


$end_date = '2021-06-23';
$poyadays = 3;

echo date('Y-m-d', strtotime($end_date. ' + '.$poyadays.'days'));

// echo date('Y-m-d', strtotime("2021-06-23 +3 days"));


?>

<script type="text/javascript">

   $(document).ready(function(){
var type =2;
var check_day = 0

    if(type==1)
  {
      alert("ab");
  }
  else if (type==2){
     

      alert("aa");
 if(check_day == 0){
        alert("aa1");
      }else{
         alert("aa2");
      }
     
  }

     });

  
</script>