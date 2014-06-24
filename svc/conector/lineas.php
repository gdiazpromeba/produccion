<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Linea.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/LineasSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  $svc = new LineasSvcImpl();


  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$cadena=$_REQUEST['query'];
	$callback=$_REQUEST['callback'];
	
	$beans=$svc->selPorComienzo($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorComienzoCuenta($cadena);
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['lineaId']=$bean->getId();
	  $arrBean['lineaDescripcion']=$bean->getDescripcion();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
	echo $callback . "(" .  json_encode($resultado) . ");";

  }else if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$lineaDescripcion=$_REQUEST['lineaDescripcion'];
		$observaciones=$_REQUEST['observaciones'];
		
		$beans=$svc->selTodos($desde, $cuantos, $lineaDescripcion, $observaciones);
		$cuenta=$svc->selTodosCuenta($lineaDescripcion, $observaciones);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['lineaId']=$bean->getId();
		  $arrBean['lineaDescripcion']=$bean->getDescripcion();
		  $arrBean['observaciones']=$bean->getObservaciones();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

   } else if ($ultimo=='inserta'){
	   	$bean=new Linea(); 
		$bean->setDescripcion($_REQUEST['lineaDescripcion']);
		$bean->setObservaciones($_REQUEST['observaciones']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
 
  } else if ($ultimo=='actualiza'){
		$bean=new Linea();
		$bean->setId($_REQUEST['lineaId']);
		$bean->setDescripcion($_REQUEST['lineaDescripcion']);
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