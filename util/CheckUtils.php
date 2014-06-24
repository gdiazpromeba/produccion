<?php
//require_once('FirePHPCore/fb.php');

 class CheckUtils{
  	/**
  	 * toma el valor que venga de un check de un formulario, y, sea lo que sea, 
  	 * devuelve un 1 o un 0 
  	 */
  	public static function procesaCheck($valorRequest){
  		if (empty($valorRequest)){
  		  return 0;
  		}else if ($valorRequest==='false'){
  		  return 0;
  		}else{
  		  return 1;
  		}
  	}
 }
?>
