<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/AtributoValor.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/AtributosValorSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$atributoId=$_REQUEST['atributoId'];
		$svc = new AtributosValorSvcImpl();
		$beans=$svc->selTodos($desde, $cuantos, $atributoId);
		$cuenta=$svc->selTodosCuenta($nombreOParte, $atributoId);
		$datos=array();
		
		//primero lleno los atributos
		$atrUsados=array();
		foreach ($beans as $bean){
	      if (!array_key_exists($bean->getAtributoId(), $atrUsados)){
		    $fila=array();
		    $fila["id"]=$bean->getAtributoId();
		    $fila["text"]=$bean->getAtributoNombre();
		    $fila["leaf"]=false;
		    $fila["cls"]='folder';
		    $fila["children"]=array();
		    $atrUsados[$bean->getAtributoId()]=$fila;	    
	      }
		}
		
		//ahora lleno los hijos
		foreach ($beans as $bean){
		  $fila=$atrUsados[$bean->getAtributoId()];
		  $otraFila=array();
		  $otraFila["id"]=$bean->getId();
		  $otraFila["text"]=$bean->getValorAlfanumerico();
		  $otraFila["leaf"]=true;
		  $otraFila["cls"]='file';
		  $otraFila["checked"]=false;
		  $atrUsados[$bean->getAtributoId()]['children'][]=$otraFila;
	    }

		echo json_encode(array_values($atrUsados));
  }

?>