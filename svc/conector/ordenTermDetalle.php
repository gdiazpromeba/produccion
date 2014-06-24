<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenTerminacionDetalle.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenTerminacion.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/OrdenesTerminacionDetSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/OrdenesTerminacionCabSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
    
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new OrdenesTerminacionDetSvcImpl();
  $svcCab = new OrdenesTerminacionCabSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$ordenProdCabId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $ordenProdCabId);
		$cuenta=$svc->selTodosCuenta($ordenProdCabId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['ordTermDetId']=$bean->getId();
	      $arrBean['ordTermCabId']=$bean->getCabeceraId();
	      $arrBean['piezaId']=$bean->getPiezaId();
	      $arrBean['piezaNombre']=$bean->getPiezaNombre();
	      $arrBean['cantidad']=$bean->getCantidad();
	      $arrBean['cantidadCortada']=$bean->getCantidadCortada();
	      $arrBean['cantidadPulida']=$bean->getCantidadPulida();
	      $arrBean['fechaEntrega']=$bean->getFechaEntregaLarga();
	      $arrBean['observaciones']=$bean->getObservaciones();
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
    $arrBean['ordTermDetId']=$bean->getId();
    $arrBean['ordTermCabId']=$bean->getCabeceraId();
    $arrBean['ordenNumero']=$bean->getNumero();
    $arrBean['piezaId']=$bean->getPiezaId();
    $arrBean['piezaNombre']=$bean->getPiezaNombre();
    $arrBean['cantidad']=$bean->getCantidad();
    $arrBean['cantidadCortada']=$bean->getCantidadCortada();
    $arrBean['cantidadPulida']=$bean->getCantidadPulida();
    $arrBean['fechaEntrega']=$bean->getFechaEntregaLarga();
    $arrBean['observaciones']=$bean->getObservaciones();
    echo json_encode($arrBean);	 
     
  } else if ($ultimo=='inserta'){
    $bean=new OrdenTerminacionDetalle();
	$bean->setCabeceraId($_REQUEST['valorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaIdOPD']);
	$bean->setCantidad($_REQUEST['cantidadOPD']);
	$bean->setCantidadCortada($_REQUEST['cantidadCortada']);
	$bean->setCantidadPulida($_REQUEST['cantidadPulida']);
	$bean->setFechaEntregaCorta($_REQUEST['fechaEntrega']);
	$bean->setObservaciones($_REQUEST['observacionesOPD']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new OrdenTerminacionDetalle();
    $bean->setId($_REQUEST['ordTermDetId']);
	$bean->setCabeceraId($_REQUEST['valorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaIdOPD']);
	$bean->setCantidad($_REQUEST['cantidadOPD']);
	$bean->setCantidadPulida($_REQUEST['cantidadPulida']);
	$bean->setCantidadCortada($_REQUEST['cantidadCortada']);
	$bean->setFechaEntregaCorta($_REQUEST['fechaEntrega']);
	$bean->setObservaciones($_REQUEST['observacionesOPD']);
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