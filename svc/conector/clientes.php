<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Cliente.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/ClientesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$cadena=$_REQUEST['query'];
	$callback=$_REQUEST['callback'];
	
	$svc = new ClientesSvcImpl();
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
		$nombreOParte=$_REQUEST['nombreOParte'];
		
		$svc = new ClientesSvcImpl();
		$beans=$svc->selTodos($desde, $cuantos, $nombreOParte);
		$cuenta=$svc->selTodosCuenta($nombreOParte);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['id']=$bean->getId();
		  $arrBean['nombre']=$bean->getNombre();
		  $arrBean['condicionesPago']=$bean->getCondicionesPago();
		  $arrBean['conducta']=$bean->getConducta();
		  $arrBean['contactoCompras']=$bean->getContactoCompras();
		  $arrBean['direccion']=$bean->getDireccion();
		  $arrBean['localidad']=$bean->getLocalidad();
		  $arrBean['telefono']=$bean->getTelefono();
		  $arrBean['condicionIva']=$bean->getCondicionIva();
		  $arrBean['cuit']=$bean->getCuit();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

   } else if ($ultimo=='inserta'){
	   	$bean=new Cliente(); 
		$svc = new ClientesSvcImpl();
		$bean->setNombre($_REQUEST['nombreCliente']);
		$bean->setCondicionesPago($_REQUEST['condicionesPago']);
		$bean->setConducta($_REQUEST['conducta']);
		$bean->setContactoCompras($_REQUEST['contactoCompras']);
		$bean->setDireccion($_REQUEST['direccion']);
		$bean->setLocalidad($_REQUEST['localidad']);
		$bean->setTelefono($_REQUEST['telefono']);
		$bean->setCondicionIva($_REQUEST['condicionIva']);
		$bean->setCuit($_REQUEST['cuit']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
 
  } else if ($ultimo=='actualiza'){
		$bean=new Cliente();
		$bean->setId($_REQUEST['idCliente']);
		$bean->setNombre($_REQUEST['nombreCliente']);
		$bean->setCondicionesPago($_REQUEST['condicionesPago']);
		$bean->setConducta($_REQUEST['conducta']);
		$bean->setContactoCompras($_REQUEST['contactoCompras']);
		$bean->setDireccion($_REQUEST['direccion']);
		$bean->setLocalidad($_REQUEST['localidad']);
		$bean->setTelefono($_REQUEST['telefono']);
		$bean->setCondicionIva($_REQUEST['condicionIva']);
		$bean->setCuit($_REQUEST['cuit']);
		$svc = new ClientesSvcImpl();
		$exito=$svc->actualiza($bean);
		echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$svc = new ClientesSvcImpl();
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	

  } else if ($ultimo=='inhabilita'){
	$svc = new ClientesSvcImpl();
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  }

?>