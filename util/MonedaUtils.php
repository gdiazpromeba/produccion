<?php
  //require_once('FirePHPCore/fb.php');
  class MonedaUtils{

  	/**
  	 * toma una número y lo formatea como moneda
  	 * se usa en Windows, que no tiene money_format
  	 * por no tener sprintf
  	 */
  	public static function money_format($numero){
  		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
  			return '$' . number_format($numero, 2, '.', ',');
  		}else{
  			return money_format('%.2n', $numero);
  		}
  	}
  }
?>
