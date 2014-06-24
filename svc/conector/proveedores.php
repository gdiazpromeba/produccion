<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Proveedor.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/ProveedoresSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_GET['start'];
	$cuantos=$_GET['limit'];
	$cadena=$_GET['query'];
	$callback=$_GET['callback'];
	
	$svc = new ProveedoresSvcImpl();
	$beans=$svc->selPorComienzo($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorComienzoCuenta($cadena);
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombre']=$bean->getNombre();
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
	$nombreOParte=$_REQUEST['nombreBusProv'];
	$rubros=$_REQUEST['rubroBusProv'];
	
	$svc = new ProveedoresSvcImpl();
	$beans=$svc->selTodos($desde, $cuantos, $nombreOParte, $rubros);
	$cuenta=$svc->selTodosCuenta($nombreOParte, $rubros);
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombre']=$bean->getNombre();
	  $arrBean['rubros']=$bean->getRubros();
	  $arrBean['observaciones']=$bean->getObservaciones();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
	echo json_encode($resultado) ;
  	
   } else if ($ultimo=='inserta'){
   	$bean=new Proveedor(); 
	$svc = new ProveedoresSvcImpl();
	$bean->setNombre($_REQUEST['nombreProveedor']);
	$bean->setRubros($_REQUEST['rubros']);
	$bean->setObservaciones($_REQUEST['observaciones']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
	
  
  } else if ($ultimo=='actualiza'){
	
	$bean=new Proveedor();
	$bean->setId($_POST['idProveedor']);
	$bean->setNombre($_POST['nombreProveedor']);
	$bean->setRubros($_REQUEST['rubros']);
	$bean->setObservaciones($_REQUEST['observaciones']);
	$svc = new ProveedoresSvcImpl();
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	

  }   else if ($ultimo=='borra'){

	$svc = new ProveedoresSvcImpl();
	$exito=$svc->borra($_POST['id']);
	echo json_encode($exito) ;
	

  } 

?>