<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ComunicacionPrecios.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/ComunicacionesPreciosCabeceraSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new ComunicacionesPreciosCabeceraSvcImpl();

  if ($ultimo=='selecciona'){
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$clienteId=$_REQUEST['clienteId'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
		$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta);
		$cuenta=$svc->selTodosCuenta($clienteId, $fechaDesde, $fechaHasta);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['comPrecCabId']=$bean->getId();
	      $arrBean['clienteId']=$bean->getClienteId();
	      $arrBean['clienteNombre']=$bean->getClienteNombre();
	      $arrBean['destinatario']=$bean->getDestinatario();
	      $arrBean['fecha']=$bean->getFechaLarga();
	      $arrBean['autorizadorId']=$bean->getAutorizadorId();
	      $arrBean['autorizadorNombre']=$bean->getAutorizadorNombre();
	      $arrBean['metodoEnvio']=$bean->getMetodoEnvio();
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
    $arrBean['comPrecCabId']=$bean->getId();
    $arrBean['clienteId']=$bean->getClienteId();
    $arrBean['clienteNombre']=$bean->getClienteNombre();
    $arrBean['destinatario']=$bean->getDestinatario();
    $arrBean['fecha']=$bean->getFechaLarga();
    $arrBean['autorizadorId']=$bean->getAutorizadorId();
    $arrBean['autorizadorNombre']=$bean->getAutorizadorNombre();
    echo json_encode($arrBean);	  
    
  } else if ($ultimo=='inserta'){
    $bean=new ComunicacionPrecios(); 
	$bean->setClienteId($_REQUEST['clienteIdCabCom']);
	$bean->setDestinatario($_REQUEST['destinatario']);
	$bean->setFechaCorta($_REQUEST['fecha']);
	$bean->setAutorizadorId($_REQUEST['autorizadorId']);
	$bean->setMetodoEnvio($_REQUEST['metodoEnvio']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new ComunicacionPrecios();
    $bean->setId($_REQUEST['comPrecCabId']);
	$bean->setClienteId($_REQUEST['clienteIdCabCom']);
	$bean->setDestinatario($_REQUEST['destinatario']);
	$bean->setFechaCorta($_REQUEST['fecha']);
	$bean->setAutorizadorId($_REQUEST['autorizadorId']);
	$bean->setMetodoEnvio($_REQUEST['metodoEnvio']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
	
  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='duplica'){
    $cabComPrecId=$_REQUEST['cabComPrecId'];
    $fechaNueva=FechaUtils::cadenaAObjeto($_REQUEST['fechaNueva']);
    $variacion=$_REQUEST['variacion'];
  	$exito=$svc->duplica($cabComPrecId, $fechaNueva, $variacion);
  	echo json_encode($exito);
  	
  } else if ($ultimo=='creaDesdePedido'){
    $comPrecCabId=$_REQUEST['comPrecCabId'];
    if (isset($_REQUEST['fechaDesde'])){
      $fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);      
    }
    $clienteId=$_REQUEST['clienteId'];
  	$exito=$svc->creaDePedidos($clienteId, $comPrecCabId, $fechaDesde);
  	echo json_encode($exito);
  }
  
  
  
  

?>