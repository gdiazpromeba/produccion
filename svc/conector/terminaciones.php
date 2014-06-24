<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Terminacion.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/TerminacionesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc = new TerminacionesSvcImpl();

  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_GET['start'];
	$cuantos=$_GET['limit'];
	$cadena=$_GET['query'];
	$callback=$_GET['callback'];
	$beans=$svc->selPorComienzo($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorComienzoCuenta($cadena);
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['terminacionId']=$bean->getId();
	  $arrBean['terminacionNombre']=$bean->getNombre();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo $callback . "(" .  json_encode($resultado) . ");";

  }


?>