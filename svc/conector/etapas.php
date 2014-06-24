<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Etapa.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/EtapasSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc = new EtapasSvcImpl();

  if ($ultimo=='selecciona'){
	$beans=$svc->selTodos(0, 100);
	$cuenta=$svc->selTodosCuenta();
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombre']=$bean->getNombre();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	//$resultado['total']=$cuenta;
	$resultado['data']=$datos;
    echo json_encode($resultado);
      
  }  else if ($ultimo=='obtiene'){
    $id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
	$arrBean['id']=$bean->getId();
	$arrBean['nombre']=$bean->getNombre();
    echo json_encode($arrBean);
  }	

?>