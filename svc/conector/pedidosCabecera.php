<?php

try {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pedido.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PedidosCabeceraSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');

  
  
  
  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);


  $svc = new PedidosCabeceraSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$clienteId=$_REQUEST['clienteId'];
		$estado=$_REQUEST['pedidoEstado'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
		$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta);
		$cuenta=$svc->selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['pedidoCabeceraId']=$bean->getId();
	      $arrBean['pedidoNumero']=$bean->getNumero();
	      $arrBean['clienteId']=$bean->getClienteId();
	      $arrBean['clienteNombre']=$bean->getClienteNombre();
	      $arrBean['pedidoFecha']=$bean->getFechaLarga();
	      $arrBean['fechaPrometida']=$bean->getFechaPrometidaLarga();
	      $arrBean['pedidoReferencia']=$bean->getReferencia();
	      $arrBean['pedidoEstado']=$bean->getEstado();
		  $datos[]=$arrBean;
		}
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

  }else if ($ultimo=='obtiene'){
    $id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
    $arrBean['pedidoCabeceraId']=$bean->getId();
    $arrBean['pedidoNumero']=$bean->getNumero();
    $arrBean['clienteId']=$bean->getClienteId();
    $arrBean['clienteNombre']=$bean->getClienteNombre();
    $arrBean['pedidoFecha']=$bean->getFechaLarga();
    $arrBean['pedidoFechaPrometida']=$bean->getFechaPrometidaLarga();
    $arrBean['pedidoReferencia']=$bean->getReferencia();
    $arrBean['pedidoEstado']=$bean->getEstado();
    echo json_encode($arrBean);

  } else if ($ultimo=='inserta'){
    $bean=new Pedido();
    $bean->setNumero($_REQUEST['pedidoNumero']);
    $bean->setClienteId($_REQUEST['clienteIdCabPed']);
    $bean->setFechaCorta($_REQUEST['pedidoFecha']);
    $bean->setFechaPrometidaCorta($_REQUEST['fechaPrometidaPC']);
    $bean->setReferencia($_REQUEST['pedidoReferencia']);
    $bean->setEstado($_REQUEST['pedidoEstado']);
    $exito=$svc->inserta($bean);
    echo json_encode($exito) ;

  } else if ($ultimo=='actualiza'){
    $bean=new Pedido();
    $bean->setId($_REQUEST['pedidoCabeceraId']);
    $bean->setNumero($_REQUEST['pedidoNumero']);
	$bean->setClienteId($_REQUEST['clienteIdCabPed']);
	$bean->setFechaCorta($_REQUEST['pedidoFecha']);
	$bean->setFechaPrometidaCorta($_REQUEST['fechaPrometidaPC']);
	$bean->setReferencia($_REQUEST['pedidoReferencia']);
	$bean->setEstado($_REQUEST['pedidoEstado']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;

  }else if ($ultimo=='sugierePedido'){
		$max=$svc->sugierePedido();
		$resultado=array();
		$resultado['total']=1;
		$resultado['data']=$max;
		echo json_encode($resultado) ;

  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;

  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;
	
  } else if ($ultimo=='reportePagos'){
		$arr=$svc->selReporteSeñas();
		echo json_encode($arr);
  
  } else if ($ultimo=='pedidoRapido'){
    $clienteId=$_REQUEST['clienteId'];
    $clienteNombre=$_REQUEST['clienteNombre'];
    $email=$_REQUEST['email'];
    $telefono=$_REQUEST['telefono'];
    $piezaId=$_REQUEST['piezaId'];
    $terminacionId=$_REQUEST['terminacionId'];
    $terminacionNombre=$_REQUEST['terminacionNombre'];
    $cantidad=$_REQUEST['cantidad'];
    $precioUnitario=$_REQUEST['precioUnitario'];
    $seña=$_REQUEST['seña'];
    $tipoPago=$_REQUEST['tipoPago'];
    
    $exito=$svc->pedidoRapido($clienteId, $clienteNombre, $email, $telefono, $piezaId, $terminacionId, $terminacionNombre, $cantidad, 
		$precioUnitario, $seña, $tipoPago);
    echo json_encode($exito);
  }
  
  }
  catch (Exception $e) {
  	$fp = fopen('errores.txt', 'w');
  	fwrite($fp, "Caught exception: " . $e->getMessage() . "n");
  	fwrite($fp, $e->getTraceAsString());
  	fclose($fp);  	
  	
//   	error_log("Caught exception: " . $e->getMessage() . "n");
//   	error_log($e->getTraceAsString());

  }

?>