<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdChapDet.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PlanProdChapDetSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new PlanProdChapDetSvcImpl();

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
	      $arrBean['plPrChapDetId']=$bean->getId();
	      $arrBean['plPrChapCabtId']=$bean->getPlPrChapCabId();
	      $arrBean['unidades']=$bean->getUnidades();
	      $arrBean['terminacion']=$bean->getTerminacion();
	      $arrBean['ancho']=$bean->getAncho();
	      $arrBean['largo']=$bean->getLargo();
	      $arrBean['cruzada']=$bean->getCruzada();
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
    $arrBean['plPrChapDetId']=$bean->getId();
    $arrBean['plPrChapCabId']=$bean->getPlPrChapCabId();
    $arrBean['unidades']=$bean->getUnidades();
    $arrBean['terminacion']=$bean->getTerminacion();
    $arrBean['largo']=$bean->getLargo();
    $arrBean['ancho']=$bean->getAncho();
    $arrBean['cruzada']=$bean->getCruzada();
    echo json_encode($arrBean);	 
     
  } else if ($ultimo=='inserta'){
    $bean=new PlanProdChapDet();
	$bean->setPlPrChapCabId($_REQUEST['valorIdPadre']);
	$bean->setUnidades($_REQUEST['unidades']);
	$bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setLargo($_REQUEST['largo']);
	$bean->setAncho($_REQUEST['ancho']);
	$bean->setCruzada(empty($_REQUEST['cruzada'])?0:1);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new PlanProdChapDet();
    $bean->setId($_REQUEST['plPrChapDetId']);
	$bean->setPlPrChapCabId($_REQUEST['valorIdPadre']);
	$bean->setUnidades($_REQUEST['unidades']);
	$bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setLargo($_REQUEST['largo']);
	$bean->setAncho($_REQUEST['ancho']);
	$bean->setCruzada(empty($_REQUEST['cruzada'])?0:1);
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