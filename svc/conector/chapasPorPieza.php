<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ChapaPorPieza.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/ChapasPorPiezaSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new ChapasPorPiezaSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$piezaId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $piezaId);
		$cuenta=$svc->selTodosCuenta($piezaId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['chXPId']=$bean->getId();
	      $arrBean['piezaId']=$bean->getPiezaId();
	      $arrBean['terminacion']=$bean->getTerminacion();
	      $arrBean['cantidad']=$bean->getCantidad();
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
    $arrBean['chXPId']=$bean->getId();
    $arrBean['piezaId']=$bean->getPiezaId();
    $arrBean['terminacion']=$bean->getTerminacion();
    $arrBean['cantidad']=$bean->getCantidad();    
    $arrBean['largo']=$bean->getLargo();
    $arrBean['ancho']=$bean->getAncho();
    $arrBean['cruzada']=$bean->getCruzada();
    echo json_encode($arrBean);	 
     
  } else if ($ultimo=='inserta'){
    $bean=new ChapaPorPieza();
	$bean->setPiezaId($_REQUEST['valorIdPadre']);
	$bean->setTerminacion($_REQUEST['terminacion']);
    $bean->setCantidad($_REQUEST['cantidad']);	
	$bean->setLargo($_REQUEST['largo']);
	$bean->setAncho($_REQUEST['ancho']);
	$bean->setCruzada(empty($_REQUEST['cruzada'])?0:1);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new ChapaPorPieza();
    $bean->setId($_REQUEST['chXPId']);
	$bean->setPiezaId($_REQUEST['valorIdPadre']);
    $bean->setTerminacion($_REQUEST['terminacion']);
	$bean->setCantidad($_REQUEST['cantidad']);
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