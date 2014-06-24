<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PrecioEfectivoActual.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosEfectivosActualesSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ItemPrecioGeneral.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosGeneralesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
  
  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  
  $svcEfAct = new PreciosEfectivosActualesSvcImpl();
  $svcGen = new PreciosGeneralesSvcImpl();
      
		//parametros de paginación
		$desde=0;
		$cuantos=10000;
		//$clienteId=$_REQUEST['clienteId'];
		//$piezaId=$_REQUEST['piezaId'];
		//$nombrePiezaOParte=$_REQUEST['nombrePiezaOParte'];
		$arr=$svcEfAct->selEfectivosActuales($desde, $cuantos, $clienteId, $piezaId, $nombrePiezaOParte);
		$cuenta=$svcEfAct->selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte);
		$resultado=array();
		$filas=array();
		$i=0;
		foreach($arr as $bean){
		  $fila=array();
		  $fila['id']=$bean->getId();
		  $fila['clienteId']=$bean->getClienteId();
		  $fila['clienteNombre']=$bean->getClienteNombre();
		  $fila['piezaId']=$bean->getPiezaId();
		  $fila['piezaNombre']=$bean->getPiezaNombre();
		  $fila['efectivoDesde']=$bean->getEfectivoDesdeLarga();
		  $fila['precio']=$bean->getPrecio();
		  $precio=$bean->getPrecio();
		  $precioNuevo=ceil($precio * 1.07);
		  $fila['precioNuevo']=$precioNuevo;
		  $filas[]=$fila;
		  //creo bean general
		  $itemGeneral=new ItemPrecioGeneral();
		  $itemGeneral->setPiezaId($bean->getPiezaId());
		  $itemGeneral->setPrecio(ceil($precio * 1.07));
		  $itemGeneral->setEfectivoDesde(FechaUtils::cadenaDMAaObjeto('01/09/2011'));
		  if (!strpos($bean->getPiezaNombre(), "434")){
		  	$svcGen->inserta($itemGeneral);
		  	$i++;
		  	if ($i % 20 == 0){
		  	  echo "actualizando " . $i . " de " . $cuenta . "\n";	
		  	  echo $bean->getPiezaNombre() . " pasó de " . $bean->getPrecio() . " a " . $itemGeneral->getPrecio() . "\n";	
		  	}
		    
		  }
		}

  

  
?>