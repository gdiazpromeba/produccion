<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Empleado.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/EmpleadosSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');

//header("Content-Type: multipart/mixed; charset=utf-8");


  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  
  $svc = new EmpleadosSvcImpl();

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
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombreCompleto']=$bean->getNombreCompleto();
	  $arrBean['empleadoApellido']=$bean->getApellido();
	  $arrBean['empleadoNombre']=$bean->getNombre();
	  $arrBean['tarjetaNumero']=$bean->getTarjetaNumero();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo $callback . "(" .  json_encode($resultado) . ");";
    
  } else if ($ultimo=='selecciona'){
    //parametros de paginación
    $desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
    $apellido=$_REQUEST['apellido'];
	$beans=$svc->selTodos($desde, $cuantos, $apellido);
	$cuenta=$svc->selTodosCuenta($apellido);
    $datos=array();
    foreach ($beans as $bean){
      $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombre']=$bean->getNombre();
	  $arrBean['apellido']=$bean->getApellido();
	  $arrBean['tarjetaNumero']=$bean->getTarjetaNumero();
	  $arrBean['categoriaId']=$bean->getCategoriaId();
	  $arrBean['categoriaNombre']=$bean->getCategoriaNombre();
	  $arrBean['fechaInicio']=$bean->getFechaInicioLarga();
	  $arrBean['nacimiento']=$bean->getNacimientoLarga();
      $arrBean['sindicalizado']=$bean->isSindicalizado();
      $arrBean['dependientes']=$bean->getDependientes();
      $arrBean['direccion']=$bean->getDireccion();
      $arrBean['cuil']=$bean->getCuil();
	  $datos[]=$arrBean;
	}  
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado) ;

   } else if ($ultimo=='inserta'){
	   	$bean=new Empleado(); 
		$bean->setNombre($_REQUEST['empleadoNombre']);
		$bean->setApellido($_REQUEST['empleadoApellido']);
		$bean->setCategoriaId($_REQUEST['categoriaId']);
		$bean->setSindicalizado(empty($_REQUEST['sindicalizado'])?0:1);
		$bean->setDependientes($_REQUEST['dependientes']);
		$bean->setTarjetaNumero($_REQUEST['tarjetaNumero']);
		$bean->setFechaInicioCorta($_REQUEST['fechaInicio']);
		$bean->setNacimientoCorta($_REQUEST['nacimiento']);
		$bean->setDireccion($_REQUEST['direccion']);
		$bean->setCuil($_REQUEST['cuil']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
		
   } else if ($ultimo=='actualiza'){
	   	$bean=new Empleado(); 
		$bean->setId($_REQUEST['empleadoId']);
		$bean->setNombre($_REQUEST['empleadoNombre']);
		$bean->setApellido($_REQUEST['empleadoApellido']);
		$bean->setCategoriaId($_REQUEST['categoriaId']);
		$bean->setSindicalizado(empty($_REQUEST['sindicalizado'])?0:1);
		$bean->setDependientes($_REQUEST['dependientes']);
		$bean->setTarjetaNumero($_REQUEST['tarjetaNumero']);
		$bean->setFechaInicioCorta($_REQUEST['fechaInicio']);
		$bean->setNacimientoCorta($_REQUEST['nacimiento']);
		$bean->setDireccion($_REQUEST['direccion']);
		$bean->setCuil($_REQUEST['cuil']);
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