<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pago.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Cheque.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PagosSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//require_once('FirePHPCore/fb.php4');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new PagosSvcImpl();

  if ($ultimo=='selTodos'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$pedidoCabeceraId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $pedidoCabeceraId);
		$cuenta=$svc->selTodosCuenta($pedidoCabeceraId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['pagoId']=$bean->getId();
	      $arrBean['pedidoCabeceraId']=$bean->getPedidoId();
	      $arrBean['monto']=$bean->getMonto();
	      $arrBean['fecha']=$bean->getFechaLarga();
	      $arrBean['tipo']=$bean->getTipo();
	      $arrBean['observaciones']=$bean->getObservaciones();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;	
		
     
  } else if ($ultimo=='inserta'){
    $bean=new Pago();
	$bean->setPedidoId($_REQUEST['formPagosvalorIdPadre']);
	$fecha=FechaUtils::cadenaDMAaObjeto($_REQUEST['fecha']);
	$bean->setFecha($fecha);
	$bean->setMonto($_REQUEST['monto']);
	$bean->setTipo($_REQUEST['tipoPago']);
	$bean->setObservaciones($_REQUEST['observaciones']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new Pago();
    $bean->setId($_REQUEST['pagoId']);
	$bean->setPedidoId($_REQUEST['formPagosvalorIdPadre']);
	$fecha=FechaUtils::cadenaDMAaObjeto($_REQUEST['fecha']);
	$bean->setFecha($fecha);
	$bean->setMonto($_REQUEST['monto']);
	$bean->setTipo($_REQUEST['tipoPago']);
	$bean->setObservaciones($_REQUEST['observaciones']);
	
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
  }

?>