<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/LineaPorMatriz.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/LineasPorMatrizSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  $svc = new LineasPorMatrizSvcImpl();


  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$matrizId=$_REQUEST['valorIdPadre'];
		
		$beans=$svc->selTodos($desde, $cuantos, $matrizId);
		$cuenta=$svc->selTodosCuenta($matrizId);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['lxmId']=$bean->getId();
		  $arrBean['matrizId']=$bean->getMatrizId();
		  $arrBean['lineaId']=$bean->getLineaId();
		  $arrBean['lineaDescripcion']=$bean->getLineaDescripcion();
		  $arrBean['observaciones']=$bean->getObservaciones();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

   } else if ($ultimo=='inserta'){
	   	$bean=new LineaPorMatriz(); 
		$bean->setLineaId($_REQUEST['lineaIdMatDet']);
		$bean->setMatrizId($_REQUEST['valorIdPadre']);
		$bean->setObservaciones($_REQUEST['observaciones']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
 
  } else if ($ultimo=='actualiza'){
		$bean=new LineaPorMatriz();
		$bean->setId($_REQUEST['lxmId']);
		$bean->setLineaId($_REQUEST['lineaIdMatDet']);
		$bean->setMatrizId($_REQUEST['valorIdPadre']);
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