<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Usuario.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/UsuarioSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  if ($ultimo=='verifica'){
	//parametros de paginación
	$login=$_REQUEST['login'];
	$clave=$_REQUEST['clave'];
	
	$svc = new UsuarioSvcImpl();
	$resultado = $svc->validaUsuario($login, $clave);
//	fb('devolviendo algo: ' . $resultado);
	echo json_encode($resultado);

  }else if ($ultimo=='cambiaClave'){
	//parametros de paginación
	$usuario=$_REQUEST['usuario'];
	$claveAnterior=$_REQUEST['claveAnterior'];
	$claveNueva=$_REQUEST['claveNueva'];
	$svc = new UsuarioSvcImpl();
	$resultado = $svc->cambiaClave($usuario, $claveAnterior, $claveNueva);
//	fb('devolviendo algo: ' . $resultado);
	echo json_encode($resultado);
  	
  }else if ($ultimo=='selecciona'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$nombreOParte=$_REQUEST['nombreOParte'];
	$grupoId=$_REQUEST['grupoId'];
	$svc = new UsuarioSvcImpl();
	$beans=$svc->selTodos($desde, $cuantos, $nombreOParte, $grupoId);
	$cuenta=$svc->selTodosCuenta($nombreOParte, $grupoId);
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['usuarioId']=$bean->getId();
	  $arrBean['usuarioNombreCompleto']=$bean->getNombreCompleto();
      $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
	echo json_encode($resultado);

  	
  }else if ($ultimo=='inserta'){
	  $bean= new Usuario();
	  $bean->setId($_REQUEST['idUsuario']);
	  $bean->setNombre($_REQUEST['nombreUsuario']);
	  $bean->setUsuario($_REQUEST['usuario']);
	  $bean->setClave($_REQUEST['clave']);
	  $bean->setHabilitado(true);
	  $svc = new UsuarioSvcImpl();
	  $exito=$svc->insUsuario($bean);
	  echo json_encode($exito) ;  	
  	
  }else if ($ultimo=='borra'){
	//parametros de paginación
	$id=$_REQUEST['data'];
	$id=json_decode($id);
	
	$svc = new UsuarioSvcImpl();
	$exito=$svc->borUsuario($id);
	echo json_encode($exito) ;
  
  }else if ($ultimo=='inhabilita'){
	$id=$_REQUEST['id'];
	$svc = new UsuarioSvcImpl();
	$exito=$svc->inhabilita($id);
    echo json_encode($exito) ;	
    
  }else if ($ultimo=='actualiza'){
	  $bean= new Usuario();
	  $bean->setId($_REQUEST['idUsuario']);
	  $bean->setNombre($_REQUEST['nombreUsuario']);
	  $bean->setUsuario($_REQUEST['usuario']);
	  $bean->setClave($_REQUEST['clave']);
	  $bean->setHabilitado(true);
	  $svc = new UsuarioSvcImpl();
	  $exito=$svc->actUsuario($bean);
	  echo json_encode($exito) ;
  
  }else if ($ultimo=='actualizaPorId'){
	  $data=$_REQUEST['data'];
	  $arr=json_decode($data, true);
	  $id=$arr['idUsuario'];
	
	  $svc = new UsuarioSvcImpl();
	  $bean=$svc->obtUsuarioPorId($id);
	  
	  if ($bean!=null){
	  	$nombre=$arr['nombreUsuario']; if ($nombre!=null) $bean->setNombre($nombre);
	  	$usuario=$arr['usuario']; if ($usuario!=null) $bean->setUsuario($usuario);
	  	$clave=$arr['clave']; if ($clave!=null) $bean->setClave($clave);
	  }
	  
	  $exito=$svc->actUsuario($bean);
	  echo json_encode($exito) ;
  }
?>