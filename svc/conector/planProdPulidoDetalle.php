<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdPulidoDet.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PlanProdPulidoDetSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new PlanProdPulidoDetSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$planProdPulidoCabId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $planProdPulidoCabId);
		$cuenta=$svc->selTodosCuenta($planProdPulidoCabId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['planProdPulidoDetId']=$bean->getId();
	      $arrBean['planProdPulidoCabId']=$bean->getplanProdPulidoCabId();
	      $arrBean['piezaFicha']=$bean->getPiezaFicha();
	      $arrBean['cantidad']=$bean->getCantidad();
	      $arrBean['terminacion']=$bean->getTerminacion();
	      $arrBean['reparada']=$bean->isReparada();
	      $arrBean['tapizarMini']=$bean->isTapizarMini();
	      $arrBean['rota']=$bean->isRota();
	      $arrBean['pulido']=$bean->isPulido();
	      $arrBean['tupi']=$bean->isTupi();
	      $arrBean['cantos']=$bean->isCantos();
	      $arrBean['lijadoPelota']=$bean->isLijadoPelota();
	      $arrBean['rotocort']=$bean->isRotocort();
	      $arrBean['tacos']=$bean->isTacos();
	      $arrBean['escuadraGarlopa']=$bean->isEscuadraGarlopa();
	      $arrBean['otra']=$bean->isOtra();
	      $arrBean['observacionesDet']=$bean->getObservaciones();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;	
		
  	

  } else if ($ultimo=='obtiene'){
    $id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
    $arrBean['planProdPulidoDetId']=$bean->getId();
    $arrBean['planProdPulidoCabId']=$bean->getplanProdPulidoCabId();
    $arrBean['piezaFicha']=$bean->getPiezaFicha();
    $arrBean['cantidad']=$bean->getCantidad();
    $arrBean['terminacion']=$bean->getTerminacion();
    $arrBean['reparada']=$bean->isReparada();
    $arrBean['tapizarMini']=$bean->isTapizarMini();
    $arrBean['rota']=$bean->isRota();
    $arrBean['pulido']=$bean->isPulido();
    $arrBean['tupi']=$bean->isTupi();
    $arrBean['cantos']=$bean->isCantos();
    $arrBean['lijadoPelota']=$bean->isLijadoPelota();
    $arrBean['rotocort']=$bean->isRotocort();
    $arrBean['tacos']=$bean->isTacos();
    $arrBean['escuadraGarlopa']=$bean->isEscuadraGarlopa();
    $arrBean['otra']=$bean->isOtra();
    $arrBean['observacionesDet']=$bean->getObservaciones();
    echo json_encode($arrBean);	 
     
  } else if ($ultimo=='inserta'){
    $bean=new PlanProdPulidoDet();
	$bean->setplanProdPulidoCabId($_REQUEST['valorIdPadre']);
	$bean->setPiezaFicha($_REQUEST['piezaFicha']);
	$bean->setCantidad($_REQUEST['cantidadPPD']);
	$bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setReparada(empty($_REQUEST['reparadas'])?0:1);
	$bean->setTapizarMini(empty($_REQUEST['tapizarMini'])?0:1);
	$bean->setRota(empty($_REQUEST['rota'])?0:1);
	$bean->setPulido(empty($_REQUEST['pulido'])?0:1);
	$bean->setTupi(empty($_REQUEST['tupi'])?0:1);
	$bean->setCantos(empty($_REQUEST['cantos'])?0:1);
	$bean->setLijadoPelota(empty($_REQUEST['lijadoPelota'])?0:1);
	$bean->setRotocort(empty($_REQUEST['rotocort'])?0:1);
	$bean->setTacos(empty($_REQUEST['tacos'])?0:1);
	$bean->setEscuadraGarlopa(empty($_REQUEST['escuadraGarlopa'])?0:1);
	$bean->setOtra(empty($_REQUEST['otra'])?0:1);
	$bean->setObservaciones($_REQUEST['observacionesDet']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new PlanProdPulidoDet();
    $bean->setId($_REQUEST['planProdPulidoDetId']);
	$bean->setplanProdPulidoCabId($_REQUEST['valorIdPadre']);
	$bean->setPiezaFicha($_REQUEST['piezaFicha']);
	$bean->setCantidad($_REQUEST['cantidadPPD']);
	$bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setReparada(empty($_REQUEST['reparadas'])?0:1);
	$bean->setTapizarMini(empty($_REQUEST['tapizarMini'])?0:1);
	$bean->setRota(empty($_REQUEST['rota'])?0:1);
	$bean->setPulido(empty($_REQUEST['pulido'])?0:1);
	$bean->setTupi(empty($_REQUEST['tupi'])?0:1);
	$bean->setCantos(empty($_REQUEST['cantos'])?0:1);
	$bean->setLijadoPelota(empty($_REQUEST['lijadoPelota'])?0:1);
	$bean->setRotocort(empty($_REQUEST['rotocort'])?0:1);
	$bean->setTacos(empty($_REQUEST['tacos'])?0:1);
	$bean->setEscuadraGarlopa(empty($_REQUEST['escuadraGarlopa'])?0:1);
	$bean->setOtra(empty($_REQUEST['otra'])?0:1);
	$bean->setObservaciones($_REQUEST['observacionesDet']);
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