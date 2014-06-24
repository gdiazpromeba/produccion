<?php      

  echo "hola"; 
  
      $db_connection = new mysqli("localhost", "almarlam_gonzalo", "manuela", "almarlam_prod");
      $db_connection->set_charset("utf8");
      
      //$db_connection->query("SET NAMES 'utf8'");
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }else{
        echo "db OK";
      }
     
      $db_connection->close();


?>
