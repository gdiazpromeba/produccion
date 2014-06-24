<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/EstadisticasSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
  //require_once('FirePHPCore/fb.php');


  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc = new EstadisticasSvcImpl();

  if ($ultimo=='facturacion'){
  	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	$datos=$svc->facturacion($fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  } else if ($ultimo=='precios'){
  	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	$piezaId=$_REQUEST['piezaId'];
	$datos=$svc->precios($piezaId, $fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);	
	
  }elseif ($ultimo=='montosPedidosYRemitidos'){
	//no sé por qué en este caso los controles, que son iguales a otros, mandan una fecha larga
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	
	$datos=$svc->montosPedidosYRemitidos($fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }else if ($ultimo=='remitido'){
  	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	$datos=$svc->remitido($fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }elseif ($ultimo=='montosPedidosYRemitidos'){
	//no sé por qué en este caso los controles, que son iguales a otros, mandan una fecha larga
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	
	$datos=$svc->montosPedidosYRemitidos($fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }
  
  
  elseif ($ultimo=='remitido'){
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	
	$datos=$svc->facturacion($fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }elseif ($ultimo=='montosPedidosYRemitidos'){
	//no sé por qué en este caso los controles, que son iguales a otros, mandan una fecha larga
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	
	$datos=$svc->montosPedidosYRemitidos($fechaDesde, $fechaHasta);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);	
	
  }else if ($ultimo=='mejoresFichasEnUnidades'){
	//no sé por qué en este caso los controles, que son iguales a otros, mandan una fecha larga
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	$cuantas=$_REQUEST['cuantas'];
	
	$datos=$svc->mejoresFichasEnUnidades($fechaDesde, $fechaHasta, $cuantas);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }else if ($ultimo=='mejoresFichasEnMonto'){
	//no sé por qué en este caso los controles, que son iguales a otros, mandan una fecha larga
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	$cuantas=$_REQUEST['cuantas'];
	
	$datos=$svc->mejoresFichasEnMonto($fechaDesde, $fechaHasta, $cuantas);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }else if ($ultimo=='mejoresClientesEnMonto'){
	//no sé por qué en este caso los controles, que son iguales a otros, mandan una fecha larga
	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']); 
	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
	$cuantos=$_REQUEST['cuantos'];
	
	$datos=$svc->mejoresClientesEnMonto($fechaDesde, $fechaHasta, $cuantos);
	$res=array();
	$res["data"]=$datos;
	$res["total"]=count($datos);
	echo json_encode($res);
	
  }



  

?>