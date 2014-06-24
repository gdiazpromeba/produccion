<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/DatosRelojSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/DatoReloj.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
  
//  require_once('FirePHPCore/fb.php');
 
  
  $url=$_SERVER['PHP_SELF'];
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc=new DatosRelojSvcImpl();

  if ($ultimo=='selecciona'){
  	$desde=$_REQUEST['start'];
  	$hasta=$_REQUEST['limit'];
  	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
  	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
  	$empleadoId=$_REQUEST['empleadoId'];
    $beans=$svc->selTodos($desde, $hasta, $empleadoId,  $fechaDesde, $fechaHasta);
    $cuenta=$svc->selTodosCuenta($empleadoId,  $fechaDesde, $fechaHasta);
    
    $datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['empleadoId']=$bean->getEmpleadoId();
	  $arrBean['empleadoApellido']=$bean->getEmpleadoApellido();
	  $arrBean['empleadoNombre']=$bean->getEmpleadoNombre();
	  $arrBean['lecturaFechaHora']=$bean->getCadenaFechaHoraLarga();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
    echo json_encode($resultado);  

  } else if ($ultimo=='inserta'){
	   	$bean=new DatoReloj();
		$bean->setEmpleadoId($_REQUEST['empleadoId']);
		$fechaLectura=$_REQUEST['fechaLectura'];
		$horaLectura=$_REQUEST['horaLectura'];
		$fechaHora=FechaUtils::cadenaDMAYHoraAObjeto($fechaLectura, $horaLectura);
		$bean->setLecturaFechaHora($fechaHora);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
		
  } else if ($ultimo=='actualiza'){
	   	$bean=new DatoReloj();
	   	$bean->setId($_REQUEST['datoRelojId']);
		$bean->setEmpleadoId($_REQUEST['empleadoId']);
		$fechaLectura=$_REQUEST['fechaLectura'];
		$horaLectura=$_REQUEST['horaLectura'];
		$fechaHora=FechaUtils::cadenaDMAYHoraAObjeto($fechaLectura, $horaLectura);
		$bean->setLecturaFechaHora($fechaHora);
		$exito=$svc->actualiza($bean);
		echo json_encode($exito) ;

  } else if ($ultimo=='borra'){
	   	$id=$_REQUEST['id'];
		$exito=$svc->borra($id);
		echo json_encode($exito) ;
  }

 
?>
