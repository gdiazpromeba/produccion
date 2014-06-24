<?php      

  phpinfo();

$date = "1998-08-14";
$newdate = strtotime ( '-3 day' , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
 
echo $newdate;
  


?>
