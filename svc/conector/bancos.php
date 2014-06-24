<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Banco.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/BancosSvcImpl.php';
header("Content-Type: text/plain; charset=utf-8");

$url=$_SERVER['PHP_SELF'];
$arr=explode("/", $url);
$ultimo=array_pop($arr);
$svc = new BancosSvcImpl();

if ($ultimo=='selecciona'){
	$beans=$svc->selPorParte("", 0, 100);
	$cuenta=$svc->selPorParteCuenta("");
	$datos=array();
	foreach ($beans as $bean){
		$arrBean=array();
		$arrBean['bancoId']=$bean->getId();
		$arrBean['bancoNombre']=$bean->getNombre();
		$datos[]=$arrBean;
	}
	$resultado=array();
	//$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado);
	
}else if ($ultimo=='selPorParte'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$cadena=$_REQUEST['nombreOParte'];
	$beans=$svc->selPorParte($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorParteCuenta($cadena);
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['bancoId']=$bean->getId();
	  $arrBean['bancoNombre']=$bean->getNombre();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado);
	//echo $callback . "(" .  json_encode($resultado) . ");";	

}  else if ($ultimo=='obtiene'){
	$id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
	$arrBean['bancoId']=$bean->getId();
	$arrBean['bancoNombre']=$bean->getNombre();
	echo json_encode($arrBean);


} else if ($ultimo=='inserta'){
	$bean=new Banco();
	$svc = new BancosSvcImpl();
	$bean->setNombre($_REQUEST['bancoNombre']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;

} else if ($ultimo=='actualiza'){
	$bean=new Banco();
	$bean->setId($_REQUEST['bancoId']);
	$bean->setNombre($_REQUEST['bancoNombre']);
	$svc = new BancosSvcImpl();
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;

} else if ($ultimo=='borra'){
	$svc = new BancosSvcImpl();
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;		
}

?>