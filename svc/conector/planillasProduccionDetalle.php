<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanillaProduccionDet.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PlanillasProduccionDetSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new PlanillasProduccionDetSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$planProdCabId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $planProdCabId);
		$cuenta=$svc->selTodosCuenta($planProdCabId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['planProdDetId']=$bean->getId();
	      $arrBean['planProdCabId']=$bean->getPlanProdCabId();
	      $arrBean['matrizId']=$bean->getMatrizId();
	      $arrBean['matrizNombre']=$bean->getMatrizNombre();
	      $arrBean['cantidad']=$bean->getCantidad();
	      $arrBean['espesor']=$bean->getEspesor();
	      $arrBean['terminacion']=$bean->getTerminacion();
	      $arrBean['reparada']=$bean->isReparada();
	      $arrBean['descartada']=$bean->isDescartada();
	      $arrBean['estacionTrabajo']=$bean->getEstacionTrabajo();
	      $arrBean['observacionesDet']=$bean->getObservacionesDet();
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
    $arrBean['planProdDetId']=$bean->getId();
    $arrBean['planProdCabId']=$bean->getPlanProdCabId();
    $arrBean['matrizId']=$bean->getMatrizId();
    $arrBean['matrizNombre']=$bean->getMatrizNombre();
    $arrBean['espesor']=$bean->getEspesor();
    $arrBean['terminacion']=$bean->getTerminacion();
    $arrBean['reparada']=$bean->isReparada();
    $arrBean['descartada']=$bean->isDescartada();
    $arrBean['estacionTrabajo']=$bean->getEstacionTrabajo();
    $arrBean['observacionesDet']=$bean->getObservacionesDet();
    echo json_encode($arrBean);	 
     
  } else if ($ultimo=='inserta'){
    $bean=new PlanillaProduccionDet();
	$bean->setPlanProdCabId($_REQUEST['valorIdPadre']);
	$bean->setMatrizId($_REQUEST['matrizId']);
	$bean->setEspesor($_REQUEST['espesor']);
	$bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setReparada(empty($_REQUEST['reparadas'])?0:1);
	$bean->setDescartada(empty($_REQUEST['descartadas'])?0:1);
	$bean->setCantidad($_REQUEST['cantidadOPD']);
	$bean->setEstacionTrabajo($_REQUEST['estacionTrabajo']);
	$bean->setObservacionesDet($_REQUEST['observacionesDet']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new PlanillaProduccionDet();
    $bean->setId($_REQUEST['planProdDetId']);
	$bean->setPlanProdCabId($_REQUEST['valorIdPadre']);
	$bean->setMatrizId($_REQUEST['matrizId']);
	$bean->setCantidad($_REQUEST['cantidadOPD']);
	$bean->setEspesor($_REQUEST['espesor']);
	$bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setReparada(empty($_REQUEST['reparadas'])?0:1);
	$bean->setDescartada(empty($_REQUEST['descartadas'])?0:1);
	$bean->setEstacionTrabajo($_REQUEST['estacionTrabajo']);
	$bean->setObservacionesDet($_REQUEST['observacionesDet']);
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