<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/AtributosValorSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  if ($ultimo=='selecciona'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	
	$svc = new AtributosValorSvcImpl();
	$beans=$svc->selTodos($desde, $cuantos, '48f52dbe1d04e44132c06c753c7f417b');
	$cuenta=$svc->selTodosCuenta('48f52dbe1d04e44132c06c753c7f417b');
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombre']=$bean->getValorAlfanumerico();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
	echo json_encode($resultado);
  	
}
?>