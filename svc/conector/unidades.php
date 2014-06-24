<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Unidad.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/UnidadesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  if ($ultimo=='selecciona'){

	$svc = new UnidadesSvcImpl();
	$beans=$svc->selTodos(0, 100);
	$cuenta=$svc->selTodosCuenta();
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['texto']=$bean->getTexto();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	//$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
    echo json_encode($resultado);  
  }

?>