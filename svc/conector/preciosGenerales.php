<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ItemPrecioGeneral.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosGeneralesSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
  //require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  $svc = new PreciosGeneralesSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$piezaId=$_REQUEST['piezaId'];
		$nombrePiezaOParte=$_REQUEST['nombrePiezaOParte'];
		$efectivoDesde=FechaUtils::cadenaAObjeto($_REQUEST['efectivoDesde']);
		$svc = new PreciosGeneralesSvcImpl();
		$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $piezaId, $nombrePiezaOParte, $efectivoDesde);
		$cuenta=$svc->selTodosCuenta($piezaId, $nombrePiezaOParte, $efectivoDesde);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['id']=$bean->getId();
		  $arrBean['piezaId']=$bean->getPiezaId();
		  $arrBean['piezaNombre']=$bean->getPiezaNombre();
		  $arrBean['precio']=$bean->getPrecio();
		  $arrBean['sinonimos']=$bean->getSinonimos();
		  $arrBean['actualizado']=$bean->getActualizado();
		  $arrBean['efectivoDesde']=$bean->getEfectivoDesde();
		  $datos[]=$arrBean;
		}
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

  } else if ($ultimo=='lote'){
		$desde=0;
		$cuantos=10000;
		//$sort=null;
		//$dir=$_REQUEST['dir'];
		//$piezaId=$_REQUEST['piezaId'];
		//$nombrePiezaOParte=$_REQUEST['nombrePiezaOParte'];
		$efectivoDesde=FechaUtils::cadenaAObjeto($_REQUEST['2011-06-01']);
		$svc = new PreciosGeneralesSvcImpl();
		$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $piezaId, $nombrePiezaOParte, $efectivoDesde);
		$cuenta=$svc->selTodosCuenta($piezaId, $nombrePiezaOParte, $efectivoDesde);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['id']=$bean->getId();
		  $arrBean['piezaId']=$bean->getPiezaId();
		  $arrBean['piezaNombre']=$bean->getPiezaNombre();
		  $arrBean['precio']=$bean->getPrecio();
		  $arrBean['sinonimos']=$bean->getSinonimos();
		  $arrBean['actualizado']=$bean->getActualizado();
		  $arrBean['efectivoDesde']=$bean->getEfectivoDesde();
		  $datos[]=$arrBean;
		}
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

  } else if ($ultimo=='inserta'){
    $bean=new ItemPrecioGeneral();
    $bean->setPiezaId($_REQUEST['piezaIdPrecTod']);
    $bean->setPrecio($_REQUEST['precioPrecTod']);
    $efectivoDesde=FechaUtils::cadenaDMAAObjeto($_REQUEST['efectivoDesdePrecTod']);
    $bean->setEfectivoDesde($efectivoDesde);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='insertaAhora'){
    $bean=new ItemPrecioGeneral();
    $bean->setPiezaId($_REQUEST['piezaIdPrecTod']);
    $bean->setPrecio($_REQUEST['precioPrecTod']);
    $bean->setEfectivoDesde(date("d/m/Y"));
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;


  } else if ($ultimo=='actualiza'){
  	//el clienteId viene como texto vacío, no null
    $clienteId=$_REQUEST['clienteIdPrecTod'];
    if (trim($clienteId)==''){
    	$clienteId=null;
    }
    $bean=new ItemPrecioGeneral();
    $bean->setId($_REQUEST['itemListaPreciosId']);
    $bean->setPiezaId($_REQUEST['piezaIdPrecTod']);
    $bean->setPrecio($_REQUEST['precioPrecTod']);
    //FB::log('efectivo desde como cadena=' . $_REQUEST['efectivoDesdePrecTod']);
    //FB::log('efectivo desde como objeto=' . FechaUtils::cadenaDMAAObjeto($_REQUEST['efectivoDesdePrecTod'])->format('Y-m-d H:i:s'));
    $efectivoDesde=FechaUtils::cadenaDMAAObjeto($_REQUEST['efectivoDesdePrecTod']);
    $bean->setEfectivoDesde($efectivoDesde);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;
  }

?>