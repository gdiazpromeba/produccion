<?php


//require_once('FirePHPCore/fb.php');

class AOD{
	protected function conectarse(){
      $db_connection = new mysqli("localhost", 'almarlam_gonzalo' , 'manuela' , 'almarlam_prod');
      //$db_connection = new mysqli("localhost", 'almarlam_gonzalo' , '' , 'almarlam_prod');
      //$db_connection = new mysqli("localhost", 'root' , '' , 'almarlam_prod');
      $db_connection->set_charset("utf8");
      
      //$db_connection->query("SET NAMES 'utf8'");
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }
      
      return $db_connection;
    }
    
    protected function idUnico(){
      // no prefix
      // works only in PHP 5 and later versions
      $token = md5(uniqid());

      // better, difficult to guess
      $better_token = md5(uniqid(mt_rand(), true));
	  return $better_token;
    }
    
    //prepara un Prepared Statement con su c?digo SQL
    //devuelve un mensaje de error e interrumpe el programa si falla
    protected function preparar($conexion, $sql){
      if (!$statement = $conexion->prepare($sql)){     
        echo $conexion->error;
        exit();
      }
      return $statement;
    }
    
    
    protected function ejecutaYCierra($conexion, $stm, $nuevoId=null){
    	$res=array();
    	if ($stm->execute()){
    	  $this->cierra($conexion, $stm);
    	  $res['success']=true;
    	  if (isset($nuevoId)){
    	  	$res['nuevoId']=$nuevoId;
    	  }
     	}else{
    	  $res['success']=false;
    	  $res['errors']=mysqli_error($conexion);
    	  $this->cierra($conexion, $stm);
    	}
    	return $res;
    }
    
    protected function cierra($conexion, $stm){
          $stm->close();
          $conexion->close();
    }
    	

}
?>
