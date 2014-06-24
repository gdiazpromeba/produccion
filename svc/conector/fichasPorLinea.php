<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FichaPorLinea.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/FichasPorLineaSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  $svc = new FichasPorLineaSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$lineaId=$_REQUEST['valorIdPadre'];
		
		$beans=$svc->selTodos($desde, $cuantos, $lineaId);
		$cuenta=$svc->selTodosCuenta($lineaId);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['fxlId']=$bean->getId();
		  $arrBean['lineaId']=$bean->getLineaId();
		  $arrBean['piezaFicha']=$bean->getPiezaFicha();
		  $arrBean['observaciones']=$bean->getObservaciones();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

   } else if ($ultimo=='inserta'){
	   	$bean=new FichaPorLinea(); 
		$bean->setLineaId($_REQUEST['valorIdPadre']);
		$bean->setPiezaFicha($_REQUEST['piezaFicha']);
		$bean->setObservaciones($_REQUEST['observaciones']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
 
  } else if ($ultimo=='actualiza'){
		$bean=new FichaPorLinea();
		$bean->setId($_REQUEST['fxlId']);
		$bean->setLineaId($_REQUEST['valorIdPadre']);
		$bean->setPiezaFicha($_REQUEST['piezaFicha']);
		$bean->setObservaciones($_REQUEST['observaciones']);
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