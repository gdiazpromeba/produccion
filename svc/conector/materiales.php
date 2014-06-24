<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Material.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/MaterialesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new MaterialesSvcImpl();

  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_GET['start'];
	$cuantos=$_GET['limit'];
	$cadena=$_GET['query'];
	$callback=$_GET['callback'];
	$beans=$svc->selPorComienzo($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorComienzoCuenta($cadena);
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['materialId']=$bean->getId();
	  $arrBean['materialNombre']=$bean->getNombre();
	  $arrBean['precio']=$bean->getPrecio();
	  $arrBean['unidadId']=$bean->getUnidadId();
	  $arrBean['unidadTexto']=$bean->getUnidadTexto();
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
		$nombreOParte=$_REQUEST['nombreOParte'];
		$beans=$svc->selTodos($desde, $cuantos, $nombreOParte);
		$cuenta=$svc->selTodosCuenta($nombreOParte);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['materialId']=$bean->getId();
	      $arrBean['materialNombre']=$bean->getNombre();
	      $arrBean['precio']=$bean->getPrecio();
	      $arrBean['unidadId']=$bean->getUnidadId();
	      $arrBean['unidadTexto']=$bean->getUnidadTexto();
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
	$arrBean['materialId']=$bean->getId();
	$arrBean['materialNombre']=$bean->getNombre();
	$arrBean['precio']=$bean->getPrecio();
	$arrBean['unidadId']=$bean->getUnidadId();
	$arrBean['unidadTexto']=$bean->getUnidadTexto();
    echo json_encode($arrBean);	  
  } else if ($ultimo=='inserta'){
    $bean=new Material(); 
	$bean->setNombre($_REQUEST['materialNombre']);
	$bean->setUnidadId($_REQUEST['unidadIdMat']);
	$bean->setPrecio($_REQUEST['precio']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new Material();
	$bean->setId($_REQUEST['materialId']);
	$bean->setNombre($_REQUEST['materialNombre']);
	$bean->setUnidadId($_REQUEST['unidadIdMat']);
	$bean->setPrecio($_REQUEST['precio']);
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