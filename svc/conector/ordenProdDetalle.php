<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenProduccionDetalle.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenProduccion.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/OrdenesProduccionDetSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/OrdenesProduccionCabSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
    
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new OrdenesProduccionDetSvcImpl();
  $svcCab = new OrdenesProduccionCabSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$ordenProdCabId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $ordenProdCabId);
		$cuenta=$svc->selTodosCuenta($ordenProdCabId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['ordProdDetId']=$bean->getId();
	      $arrBean['ordProdCabId']=$bean->getCabeceraId();
	      $arrBean['piezaId']=$bean->getPiezaId();
	      $arrBean['piezaNombre']=$bean->getPiezaNombre();
	      $arrBean['cantidad']=$bean->getCantidad();
	      $arrBean['observaciones']=$bean->getObservaciones();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;	
		


  }else if ($ultimo=='obtiene'){
    $id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
    $arrBean['ordProdDetId']=$bean->getId();
    $arrBean['ordProdCabId']=$bean->getCabeceraId();
    $arrBean['ordenNumero']=$bean->getNumero();
    $arrBean['piezaId']=$bean->getPiezaId();
    $arrBean['piezaNombre']=$bean->getPiezaNombre();
    $arrBean['cantidad']=$bean->getCantidad();
    $arrBean['observaciones']=$bean->getObservaciones();
    echo json_encode($arrBean);	 
     
  } else if ($ultimo=='inserta'){
    $bean=new OrdenProduccionDetalle();
	$bean->setCabeceraId($_REQUEST['valorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaIdOPD']);
	$bean->setCantidad($_REQUEST['cantidadOPD']);
	$bean->setObservaciones($_REQUEST['observacionesOPD']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new OrdenProduccionDetalle();
    $bean->setId($_REQUEST['ordProdDetId']);
	$bean->setCabeceraId($_REQUEST['valorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaIdOPD']);
	$bean->setCantidad($_REQUEST['cantidadOPD']);
	$bean->setObservaciones($_REQUEST['observacionesOPD']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
	
	
  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='reporteTerminacionesPorOPHTML'){
  	
  	$ordProdCabId=$_REQUEST['ordProdCabId'];
  	header("Content-Type: text/html; charset=utf-8");
  	
 	$op=$svcCab->obtiene($ordProdCabId);
  	$arr=$svc->reporteTerminacionesPorOP($ordProdCabId);
  	
//  	fb($arr, "el array");
  	
  	
    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>Chapas previstas por orden de producción</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;left:170px;top:5px' class='subtitulo-pedido'>O.P.:&nbsp;" .  $op->getNumero()  . "</div> \n";
	$html.= "      <div style='position:absolute;top:0px;width:90px;' class='subtitulo-pedido-caja'>" . $op->getFechaCorta() . "</div> \n";
	$html.= "    </div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;position:relative;top:30px' border=1> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Cantidad</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Enchapado</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Medida</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Orientación</td> \n";
	$html.= "      </tr> \n";
	foreach ($arr as $fila){
      $html.= "  <tr> \n";
      $html.= "    <td class='item-tabla-pedido' style='text-align:left'>" . $fila['cantidadChapas'] . "</td> \n";
      $html.= "    <td class='item-tabla-pedido' style='text-align:left'>" . $fila['terminacion'] . "</td> \n";
      $html.= "    <td class='item-tabla-pedido' style='text-align:left'>" . $fila['medidaChapas'] . "</td> \n";
      $html.= "    <td class='item-tabla-pedido' style='text-align:left'>" . $fila['orientacionChapas'] . "</td> \n";
      $html.= "  </tr> \n";
    }
	$html.= "    </table> \n";

	$html.= "  </body> \n";
	$html.= "</html> \n";		
		
    echo $html;  	
  }
  
  function cantidadTerminaciones($arr, $linea){
    $valorLinea=$arr[$linea];
    $terminaciones=array_keys($valorLinea);
    return count($terminaciones);    
  }

?>