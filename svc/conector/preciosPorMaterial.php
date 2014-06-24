<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PrecioPorMaterial.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosPorMaterialSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
  //require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new PreciosPorMaterialSvcImpl();

  if ($ultimo=='selecciona'){
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$padreId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $padreId);
		$cuenta=$svc->selTodosCuenta($padreId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['id']=$bean->getId();
	      $arrBean['materialId']=$bean->getMaterialId();
	      $arrBean['precio']=$bean->getPrecio();
	      $arrBean['fecha']=$bean->getFechaLarga();
	      $arrBean['proveedorId']=$bean->getProveedorId();
	      $arrBean['proveedorNombre']=$bean->getProveedorNombre();
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
	$arrBean['id']=$bean->getId();
    $arrBean['materialId']=$bean->getMaterialId();
    $arrBean['precio']=$bean->getPrecio();
    $arrBean['fecha']=$bean->getFechaLarga();
	$arrBean['proveedorId']=$bean->getProveedorId();
	$arrBean['proveedorNombre']=$bean->getProveedorNombre();
	$arrBean['observaciones']=$bean->getObservaciones();
    echo json_encode($arrBean);	  
    
  } else if ($ultimo=='inserta'){
    $bean=new PrecioPorMaterial(); 
	$bean->setMaterialId($_REQUEST['valorIdPadre']);
	$bean->setPrecio($_REQUEST['ppmPrecio']);
	$bean->setFecha(FechaUtils::cadenaDMAAObjeto($_REQUEST['ppmFecha']));
	$bean->setProveedorId($_REQUEST['ppmProveedorId']);
	$bean->setObservaciones($_REQUEST['ppmObservaciones']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
	
  
  } else if ($ultimo=='actualiza'){
    $bean=new PrecioPorMaterial();
    $bean->setId($_REQUEST['ppmId']); 
	$bean->setMaterialId($_REQUEST['valorIdPadre']);
	$bean->setPrecio($_REQUEST['ppmPrecio']);
	$bean->setFecha(FechaUtils::cadenaDMAAObjeto($_REQUEST['ppmFecha']));
	$bean->setProveedorId($_REQUEST['ppmProveedorId']);
	$bean->setObservaciones($_REQUEST['ppmObservaciones']);
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