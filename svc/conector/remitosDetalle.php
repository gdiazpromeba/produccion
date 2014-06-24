<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/RemitoDetalle.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/RemitosDetalleSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc = new RemitosDetalleSvcImpl();
  
  if ($ultimo=='selecciona'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$remitoCabeceraId=$_REQUEST['valorIdPadre'];
	$beans=$svc->selTodos($desde, $cuantos, $remitoCabeceraId);
	$cuenta=$svc->selTodosCuenta($remitoCabeceraId);
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['remitoDetalleId']=$bean->getId();
	  $arrBean['remitoCabeceraId']=$bean->getCabeceraId();
	  $arrBean['piezaId']=$bean->getPiezaId();
	  $arrBean['piezaNombre']=$bean->getPiezaNombre();
	  $arrBean['cantidad']=$bean->getCantidad();
	  $arrBean['pedidoDetalleId']=$bean->getPedidoDetalleId();
	  $arrBean['interno']=$bean->getInterno();
	  $arrBean['pedidoNumero']=$bean->getPedidoNumero();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado) ;
	
  }else if ($ultimo=='selRemitosRelacionados'){
	//parametros de paginación
	$pedidoDetalleId=$_REQUEST['pedidoDetalleId'];
	
	$beans=$svc->selRemitosRelacionados($pedidoDetalleId);
	$cuenta=count($beans);
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['numero']=$bean->getNumero();
	  $arrBean['fecha']=$bean->getFechaLarga();
	  $arrBean['estado']=$bean->getEstado();
	  $arrBean['cantidad']=$bean->getCantidad();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado) ;	
  	
  } else if ($ultimo=='inserta'){
    $bean=new RemitoDetalle(); 
    $bean->setCabeceraId($_REQUEST['DetalleRemitosvalorIdPadre']);
    $bean->setPiezaId($_REQUEST['piezaId']);
    $bean->setCantidad($_REQUEST['cantidad']);
    $bean->setPedidoDetalleId($_REQUEST['pedidoDetalleId']);
    $exito=$svc->inserta($bean);
    echo json_encode($exito) ;
		
  } else if ($ultimo=='actualiza'){
    $bean=new RemitoDetalle();
    $bean->setId($_REQUEST['remitoDetalleId']);
    $bean->setCabeceraId($_REQUEST['DetalleRemitosvalorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaId']);
	$bean->setCantidad($_REQUEST['cantidad']);
	$bean->setPedidoDetalleId($_REQUEST['pedidoDetalleId']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
	
  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  }  

   

?>