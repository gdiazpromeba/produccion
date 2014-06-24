<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PrecioEfectivoActual.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosEfectivosActualesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
  
  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  
  $svc = new PreciosEfectivosActualesSvcImpl();

  if ($ultimo=='selEfectivosActuales'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$clienteId=$_REQUEST['clienteId'];
		$piezaId=$_REQUEST['piezaId'];
		$nombrePiezaOParte=$_REQUEST['nombrePiezaOParte'];
		$arr=$svc->selEfectivosActuales($desde, $cuantos, $clienteId, $piezaId, $nombrePiezaOParte);
		$cuenta=$svc->selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte);
		$resultado=array();
		$filas=array();
		foreach($arr as $bean){
		  $fila=array();
		  $fila['id']=$bean->getId();
		  $fila['clienteId']=$bean->getClienteId();
		  $fila['clienteNombre']=$bean->getClienteNombre();
		  $fila['piezaId']=$bean->getPiezaId();
		  $fila['piezaNombre']=$bean->getPiezaNombre();
		  $fila['efectivoDesde']=$bean->getEfectivoDesdeLarga();
		  $fila['precio']=$bean->getPrecio();
		  $filas[]=$fila;
		}
		$resultado['total']=$cuenta;
		$resultado['data']=$filas;
		echo json_encode($resultado) ;	
		
  }else if ($ultimo=='obtienePrecio'){
    $clienteId=$_REQUEST['clienteId'];
    $piezaId=$_REQUEST['piezaId'];
    $precio=$svc->obtienePrecio($clienteId, $piezaId);
    $resultado=array();
    if ($precio==null){
      $resultado['exito']=false;	
    }else{
      $resultado['exito']=true;
      $resultado['precio']=$precio;
    }
 	echo json_encode($resultado) ;
 	
  }
  
?>