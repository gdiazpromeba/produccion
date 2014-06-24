<?php
  //require_once('FirePHPCore/fb.php');
  class FechaUtils{

  	/**
  	 * toma una cadena del tipo "29/05/2001" y devuelve
  	 * otra cadena del tipo "2001-05-29 00:00:00"
  	 */
  	public static function cadenaDMAaLarga($cadena){
  		//$obj=DateTime::createFromFormat('d/m/Y', $cadena); no puedo hasta 5.3
  		if (empty($cadena)) return null;
        if (!is_string($cadena)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
  		$obj=FechaUtils::cadenaDMAaObjeto($cadena);
  		return FechaUtils::dateTimeACadena($obj);
  	}

  	/**
  	 * devuelve una cadena formateada como "2000-12-31"
  	 * a partir de un objeto DateTime dado como par?metro
  	 */
  	public static function dateTimeACadenaAMD($objDateTime){
  		if (empty($objDateTime)) return null;
        if (is_string($objDateTime)){
  		  throw new Exception("el valor recibido debería ser un objeto datetime, no una cadena");
  		}
 		return $objDateTime->format('Y-m-d');
  	}


  	/**
  	 * toma una cadena del tipo "2001-05-29 00:00:00" y devuelve
  	 * otra cadena del tipo "29/05/2001"
  	 */
  	public static function cadenaLargaADMA($cadena){
  		//$obj=DateTime::createFromFormat('d/m/Y', $cadena); no puedo hasta 5.3
  		if (empty($cadena)) return null;
        if (!is_string($cadena)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
  		$obj=FechaUtils::cadenaAObjeto($cadena);
  		return FechaUtils::dateTimeACadenaDMA($obj);
  	}

  	/**
  	 * dada una cadena del tipo "29/05/2001", devuelve un objeto DateTime
  	 */
  	public static function cadenaDMAaObjeto($cadena){
  		if (empty($cadena)) return null;
        if (!is_string($cadena)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
  		$arr=explode("/", $cadena);
  		$dia=$arr[0]; $mes=$arr[1]; $año=$arr[2];
  		$obj=new DateTime();
  		$obj->setDate($año, $mes, $dia);
  		$obj->setTime(0,0,0);
  		return $obj;
  	}

  	/**
  	 * dada una cadena del tipo "29/05/2001" más otra cadena del tipo "13:05",
  	 * devuelve un objeto DateTime
  	 */
  	public static function cadenaDMAYHoraAObjeto($cadenaDMA, $cadenaHora){
      $arr=explode("/", $cadenaDMA);
  	  $dia=$arr[0]; $mes=$arr[1]; $año=$arr[2];
  	  $arr=explode(":", $cadenaHora);
  	  $horas=$arr[0];$minutos=$arr[1];
      $obj=new DateTime();
  	  $obj->setDate($año, $mes, $dia);
  	  $obj->setTime($horas,$minutos,0);
  	  return $obj;
  	}


  	/**
  	 * devuelve la fecha/hora de ahora, en formato de cadena larga
  	 */
  	public static function ahoraLarga(){
  		$obj=new DateTime();
  		return FechaUtils::dateTimeACadena($obj);
  	}

  	/**
  	 * devuelve la fecha de ahora, en formato dd/mm/yyyy
  	 */
  	public static function ahoraDMA(){
  		$obj=new DateTime();
  		return FechaUtils::dateTimeACadenaDMA($obj);
  	}

  	/**
  	 * devuelve una cadena formateada como "2000-12-31 14:30:23"
  	 * a partir de un objeto DateTime dado como parámetro
  	 */
  	public static function dateTimeACadena($objDateTime){
  		if (empty($objDateTime)) return null;
        if (is_string($objDateTime)){
  		  throw new Exception("el valor recibido debería ser una objeto datetime, no una cadena");
  		}
 		return $objDateTime->format('Y-m-d H:i:s');
  	}

  	/**
  	 * devuelve una cadena formateada como "31/12/2009"
  	 * a partir de un objeto DateTime dado como parámetro
  	 */
  	public static function dateTimeACadenaDMA($objDateTime){
        if (is_string($objDateTime)){
  		  throw new Exception("el valor recibido debería ser una objeto datetime, no una cadena");
  		}
  		if (empty($objDateTime)) return null;
  		return $objDateTime->format('d/m/Y');
  	}

	/**
	 * crea y devuelve un objeto DateTime
	 * a partir de una cadena formateada como "2000-12-32 14:30:23"
	*/
	public static function creaDeCadena($cadena){
       if (empty($cadena)) return null;
        if (!is_string($cadena)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
       //return DateTime::createFromFormat('Y-m-d H:i:s', $cadenaFecha); no puedo usarla todavía, hasta que HM mejore a php 5.3
       return date_create($cadena);
	}

	/**
	 * crea y devuelve un objeto DateTime
	 * a partir de una cadena formateada como "2000-12-32 14:30:23"
	*/
	public static function cadenaAObjeto($cadena){
       if (empty($cadena)) return null;
       //return DateTime::createFromFormat('Y-m-d H:i:s', $cadenaFecha); no puedo usarla todavía, hasta que HM mejore a php 5.3
       return date_create($cadena);
	}


	/**
	 * devuelve una cadena formateada como "2000-12-32 00:00:00"
	 * a partir de los números de año, mes y día (enteros).
	 * La hora a cero.
	 */
	public static function cadena($año, $mes, $dia){
		$dt=new DateTime();
        $dt->setDate($año, $mes, $dia);
        $dt->setTime(0, 0, 0);
        $fechaEnCadena=$dt->format('Y-m-d H:i:s');
        return $fechaEnCadena;
	}
	

	/**
	 * dado un año y mes, devuelve un objeto DateTime con lo mínimo
	 * @param unknown_type $año
	 * @param unknown_type $mes
	 */
	public static function objetoDeAM($año, $mes){
		$dt=new DateTime();
        $dt->setDate($año, $mes, 1);
        $dt->setTime(0, 0, 0);
        return $dt;
	}

	/**
	 * obtiene el año de un objeto DateTime
	 */
	public static function año($objDateTime){
      return $objDateTime->format('Y');
	}

    /**
	 * obtiene el mes de un objeto DateTime
	*/
	public static function mes($objDateTime){
	  return $objDateTime->format('n');
	}

    /**
	 * obtiene el día (numérico del mes) de un objeto DateTime
	*/
	public static function dia($objDateTime){
	  return $objDateTime->format('d');
	}

	public static function diferenciaEnMinutos($dt1, $dt2){
	  $ts1=$dt1->format('U');
	  $ts2=$dt2->format('U');
	  $diferencia=$ts1-$ts2;
	  $difEnMinutos=floor($diferencia/60.0);
	  return $difEnMinutos;
	}

  	/**
  	 * esta complicada función es para los servidores cuyo PHP aún no soporta
  	 * objetos DateTime con adición de intervalos de tiempo (versión 5.3 en adelante)
  	 * Devuelve una cadena del mismo formato DMA objeto DateTime
  	 * @param string $cadenaMDA
  	 * @param int $dias
  	 */
	public static function agregaDiasAMDA($cadenaMDA, $dias){
   	  $objDateTime=FechaUtils::cadenaDMAaObjeto($cadenaMDA);
  	  $dia=FechaUtils::dia($objDateTime);
  	  $mes=FechaUtils::mes($objDateTime);
  	  $año=FechaUtils::año($objDateTime);
  	  $fecha=date("d/m/Y", mktime(0, 0, 0, $mes, $dia + $dias, $año));
      return $fecha;
	}
	
  	/**
  	 * dado un objeto DateTime, le agrega un número específico de meses, y lo devuelve en forma de objeto DateTime
  	 * @param unknown_type $objDateTime
  	 * @param unknown_type $meses
  	 */
	public static function agregaMesesADate($objDateTime, $meses){
  	  $dia=FechaUtils::dia($objDateTime);
  	  $mes=FechaUtils::mes($objDateTime);
  	  $año=FechaUtils::año($objDateTime);
  	  $fecha=date("d/m/Y", mktime(0, 0, 0, $mes + $meses, $dia, $año));
  	  $dt=FechaUtils::cadenaDMAaObjeto($fecha);
      return $dt;
	}	
	
  	/**
  	 * toma una expresión de tiempo en forma de cadena 'hh:mm:ss' y lo pasa a un
  	 * valor entero en segundos
  	 * @param unknown_type $cadena
  	 */
	public static function cadenaHMSASegundos($cadena){
  	  $arr=split(":", $cadena);
  	  $segundos=intval($arr[2]);
  	  $segundos+=intval($arr[1])*60;
  	  $segundos+=intval($arr[0])*3600;
  	  return $segundos;
	}
	
	/**
  	 * toma un valor entero en segundos y lo 
  	 * transforma en una cadena 'hh:mm:ss' 
  	 * @param unknown_type $cadena
  	 */
	public static function segundosACadenaHMS($segundos){
	  $horas=floor($segundos/3600);
	  $minutos=floor(($segundos - $horas * 3600)/60);
	  $segundos=$segundos - $horas * 3600 - $minutos * 60;
	  //ahora pasan a ser cadenas
	  $horas=sprintf("%02d",$horas); 
	  $minutos=sprintf("%02d",$minutos);
	  $segundos=sprintf("%02d",$segundos);
	  return $horas . ":" . $minutos . ":" . $segundos;
	}
	
	public static function segundosAArrayHMS($segundos){
	  $horas=floor($segundos/3600);
	  $minutos=floor(($segundos - $horas * 3600)/60);
	  $segundos=floor($segundos - $horas * 3600 - $minutos * 60);
	  $res=array();
	  $res['horas']=$horas;
	  $res['minutos']=$minutos;
	  $res['segundos']=$segundos;
      return $res;
	}
	
	
	


  }
?>
