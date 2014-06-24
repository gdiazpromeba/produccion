<?php
  require_once '../config.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/DatosRelojSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/DatoReloj.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
 
 
  $svc=new DatosRelojSvcImpl();
  set_time_limit(0);
  $handle = fopen("archivoHoras.txt" , "r");
  while (!feof($handle)){
    $data = fgets($handle);
    if (!$data) break;
    $arr=explode(',', $data);
	$numTar=trim($arr[0], '"');
    $numTar=substr($numTar, strlen($numTar)-4,  strlen($numTar));
    $fecha=trim($arr[2], '"');
    $hora=trim($arr[3], '"');
    $dt=DateTime::createFromFormat("d/m/Y H:i", $fecha . " " . $hora);
//    $fechaFormateada=date_format($dt, 'Y-m-d H:i');
    $datoReloj=new DatoReloj();
    $datoReloj->setTarjetaNumero($numTar);
    $datoReloj->setLecturaFecha($dt);
    $resultado=$svc->inserta($datoReloj);
    if (!$resultado['success']){
      echo $resultado['errors'];
    }else{
      echo "insert&oacute; OK <br/>";
    }
 }

 
?>
