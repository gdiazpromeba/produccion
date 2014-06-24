<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PedidoDetalle.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PedidoPlano.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PedidosDetalleSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);


  $svc = new PedidosDetalleSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$pedidoCabeceraId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $pedidoCabeceraId);
		$cuenta=$svc->selTodosCuenta($pedidoCabeceraId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['pedidoDetalleId']=$bean->getId();
	      $arrBean['pedidoCabeceraId']=$bean->getCabeceraId();
	      $arrBean['piezaId']=$bean->getPiezaId();
	      $arrBean['piezaNombre']=$bean->getPiezaNombre();
	      $arrBean['sinPatas']=$bean->getSinPatas();
	      $arrBean['pedidoDetalleCantidad']=$bean->getCantidad();
	      $arrBean['remitidos']=$bean->getRemitidos();
	      $arrBean['pedidoDetalleObservaciones']=$bean->getObservaciones();
	      $arrBean['pedidoDetallePrecio']=$bean->getPrecio();
	      $arrBean['terminacionId']= $bean->getTerminacionId();
	      $arrBean['terminacionNombre']= $bean->getTerminacionNombre();
		  $datos[]=$arrBean;
		}
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

  }else if ($ultimo=='selReportePedido'){
  	header("Content-Type: text/html; charset=utf-8");
	//parametros
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$pedidoCabeceraId = $_REQUEST['pedidoCabeceraId'];
	$datos=$svc->selReportePedido($pedidoCabeceraId);


    $cliente=$datos[0]['clienteNombre'];
    $fecha=$datos[0]['pedidoFecha'];
    $numero=$datos[0]['numero'];

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>ALMAR MULTILAMINADOS</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' class='subtitulo-pedido-caja'>"  . $cliente . "</div> \n";
	$html.= "      <div style='position:absolute;left:470px;top:5px' class='subtitulo-pedido'>nº</div> \n";
	$html.= "      <div style='position:absolute;left:500px;top:0px;width:100px;' class='subtitulo-pedido-caja'>" . $numero . "</div> \n";$html.= "    <br/> \n";
	$html.= "      <div style='position:absolute;top:0px;left:670px;width:100px;' class='subtitulo-pedido-caja'>" . $fecha . "</div> \n";
	$html.= "    </div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:30px'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:20px'>Ítem</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Cantidad</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:460px'>Artículo</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido'>Observaciones</td> \n";
	$html.= "      </tr> \n";
	for ($i=0; $i<count($datos); $i++){
		$fila=$datos[$i];
	  $html.= "      <tr> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:center'>" . ($i + 1) . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:right'>" . $fila['cantidad'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:left'>" . $fila['piezaNombre'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:left'>" . $fila['observaciones'] . "</td> \n";
	  $html.= "      </tr> \n";
	}
	$html.= "    </table> \n";

	$html.= "    <table style='border-style:full;position:relative;width:100%;top:310px'> \n";
	$html.= "      <tr><td class='encabezado-tabla-pedido' colspan='4'>Entregas parciales</td> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:20px'>Ítem</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Fecha</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:30px'>Cantidad</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido'>Observaciones</td> \n";
	$html.= "      </tr> \n";
	for ($i=0; $i<15; $i++){
	  $html.= "      <tr> \n";
	  $html.= "        <td class='item-parcial-pedido' style='height:30px'>&nbsp;</td> \n";
	  $html.= "        <td class='item-parcial-pedido'>&nbsp;</td> \n";
	  $html.= "        <td class='item-parcial-pedido'>&nbsp;</td> \n";
	  $html.= "        <td class='item-parcial-pedido'>&nbsp;</td> \n";
	  $html.= "      </tr> \n";
	}
	$html.= "    </table> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;

  }else if ($ultimo=='selPlano'){
		//parametros
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$clienteId=$_REQUEST['clienteId'];
		$piezaId=$_REQUEST['piezaId'];
		$estado=$_REQUEST['estado'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
		$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$precioTotalDesde=$_REQUEST['precioTotalDesde'];
		$precioPendienteDesde=$_REQUEST['precioPendienteDesde'];
		$estadoLaqueado=$_REQUEST['estadoLaqueado'];
		$nombreOParte=$_REQUEST['nombreOParte'];
		$beans=$svc->selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta,
                                    $precioTotalDesde, $precioPendienteDesde, $estadoLaqueado, $nombreOParte);
		$cuenta=$svc->selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta,
                                    $precioTotalDesde, $precioPendienteDesde, $estadoLaqueado, $nombreOParte);
		$unidades=$svc->selUnidadesPendientesPlano($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta,
                                    $precioTotalDesde, $precioPendienteDesde, $estadoLaqueado, $nombreOParte);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['pedidoDetalleId']=$bean->getPedidoDetalleId();
		  $arrBean['pedidoCabeceraId']=$bean->getPedidoCabeceraId();
		  $arrBean['clienteId']=$bean->getClienteId();
		  $arrBean['clienteNombre']=$bean->getClienteNombre();
		  $arrBean['estado']=$bean->getEstado();
		  $arrBean['fecha']=$bean->getFechaLarga();
		  $arrBean['referencia']=$bean->getReferencia();
		  $arrBean['pedidoNumero']=$bean->getNumero();
		  $arrBean['piezaId']=$bean->getPiezaId();
		  $arrBean['piezaNombre']=$bean->getPiezaNombre();
		  $arrBean['ficha']=$bean->getFicha();
		  $arrBean['cantidad']=$bean->getCantidad();
		  $arrBean['remitidos']=$bean->getRemitidos();
		  $arrBean['pendientes']=$bean->getPendientes();
		  $arrBean['fechaPrometida']=$bean->getFechaPrometidaLarga();
		  $arrBean['precioUnitario']=$bean->getPrecioUnitario();
		  $arrBean['precioTotal']=$bean->getPrecioTotal();
		  $arrBean['precioPendiente']=$bean->getPrecioPendiente();
	      $arrBean['terminacionId']=$bean->getTerminacionId();
	      $arrBean['terminacionNombre']=$bean->getTerminacionNombre();
		  $arrBean['totalUnidadesPendientes']=$unidades;
		  $arrBean['laqueadorNombre']=$bean->getLaqueadorNombre();
		  $arrBean['fechaEnvio']=$bean->getFechaEnvioLarga();
		  $arrBean['estadoLaqueado']=$bean->getEstadoLaqueado();
		  $datos[]=$arrBean;
		}
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

  }else if ($ultimo=='sugierePedido'){
		$max=$svc->sugierePedido();
		$resultado=array();
		$resultado['total']=1;
		$resultado['data']=$max;
		echo json_encode($resultado) ;

  } else if ($ultimo=='seleccionaPendientes'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$clienteId=$_REQUEST['clienteId'];
		$beans=$svc->selItemsPendientes($desde, $cuantos, $sort, $dir, $clienteId);
		$cuenta=$svc->selItemsPendientesCuenta($clienteId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['pedidoDetalleId']=$bean->getDetalleId();
	      $arrBean['pedidoFecha']=$bean->getPedidoFechaLarga();
	      $arrBean['piezaId']=$bean->getPiezaId();
	      $arrBean['piezaNombre']=$bean->getPiezaNombre();
	      $arrBean['pedidoNumero']=$bean->getPedidoNumero();
	      $arrBean['terminacionId']=$bean->getTerminacionId();
	      $arrBean['terminacionNombre']=$bean->getTerminacionNombre();
	      $arrBean['cantidad']=$bean->getCantidad();
	      $arrBean['remitidos']=$bean->getRemitidos();
		  $datos[]=$arrBean;
		}
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;

  } else if ($ultimo=='reportePendientesPorLinea'){
  	$arr=$svc->reportePendientesPorLinea();
    $resultado=array();
    $resultado['total']=count($arr);
    $resultado['data']=$arr;
    echo json_encode($resultado) ;

  } else if ($ultimo=='reportePendientesPorTerminacion'){
  	$arr=$svc->reportePendientesPorTerminacion();
    $resultado=array();
    $resultado['total']=count($arr);
    $resultado['data']=$arr;
    echo json_encode($resultado) ;

  } else if ($ultimo=='reportePendientesPorLineaHTML'){
  	header("Content-Type: text/html; charset=utf-8");
  	$arr=$svc->reportePendientesPorLinea();

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>Unidades pendientes</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;left:170px;top:5px' class='subtitulo-pedido'>Agrupados por línea de productos</div> \n";
	$html.= "      <div style='position:absolute;top:0px;width:90px;' class='subtitulo-pedido-caja'>" . date('d/m/Y') . "</div> \n";
	$html.= "    </div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;position:relative;top:30px' border=1> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:200px'>Línea</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Pendientes</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:360px'>Terminaciones</td> \n";
	$html.= "      </tr> \n";
	for ($i=0; $i<count($arr); $i++){
	  $fila=$arr[$i];
	  if (empty($fila['lineaDescripcion'])) continue;
	  $html.= "      <tr> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:left'>" . $fila['lineaDescripcion'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:right'>" . $fila['cantidadPendiente'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:right'>" . $fila['terminaciones'] . "</td> \n";
	  $html.= "      </tr> \n";
	}
	$html.= "    </table> \n";

	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;

  } else if ($ultimo=='reporteTerminacionesPorLineaHTML'){
  	header("Content-Type: text/html; charset=utf-8");
  	$arr=$svc->reporteDetalladoTerminacionesPendientes();

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>Enchapados pendientes</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;left:170px;top:5px' class='subtitulo-pedido'>De todos los pedidos</div> \n";
	$html.= "      <div style='position:absolute;top:0px;width:90px;' class='subtitulo-pedido-caja'>" . date('d/m/Y') . "</div> \n";
	$html.= "    </div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;position:relative;top:30px' border=1> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:200px'>Medida</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:160px'>Terminación</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Cantidad</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Orientación</td> \n";
	$html.= "      </tr> \n";
	foreach ($arr as $linea){
      $html.= "      <td class='item-tabla-pedido' style='text-align:left'>" . $linea['medidas'] . "</td> \n";
      $html.= "      <td class='item-tabla-pedido' style='text-align:left'>" . $linea['terminacion'] . "</td> \n";
      $html.= "      <td class='item-tabla-pedido' style='text-align:left'>" . $linea['cantidad'] . "</td> \n";
      $html.= "      <td class='item-tabla-pedido' style='text-align:left'>" . $linea['orientacion'] . "</td> \n";
      $html.= "    </tr> \n";
	}
	$html.= "    </table> \n";

	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;


  }else if ($ultimo=='obtiene'){
    $id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
    $arrBean['pedidoDetalleId']=$bean->getId();
    $arrBean['pedidoCabeceraId']=$bean->getCabeceraId();
    $arrBean['piezaId']=$bean->getPiezaId();
    $arrBean['piezaNombre']=$bean->getPiezaNombre();
    $arrBean['sinPatas']=$bean->getSinPatas();
    $arrBean['pedidoDetalleCantidad']=$bean->getCantidad();
    $arrBean['remitidos']=$bean->getRemitidos();
    $arrBean['pedidoDetalleObservaciones']=$bean->getObservaciones();
    $arrBean['pedidoDetallePrecio']=$bean->getPrecio();
    $arrBean['terminacionId']=$bean->getTerminacionId();
    $arrBean['terminacionNombre']=$bean->getTerminacionNombre();
    echo json_encode($arrBean);

  } else if ($ultimo=='inserta'){
    $bean=new PedidoDetalle();
	$bean->setCabeceraId($_REQUEST['DetallePedidosvalorIdPadre']);
	$bean->setSinPatas(isset($_REQUEST['sinPatas'])?1:0);
	$bean->setPiezaId($_REQUEST['piezaIdPedDet']);
	$bean->setCantidad($_REQUEST['pedidoDetalleCantidad']);
	$bean->setRemitidos($_REQUEST['remitidos']);
	$bean->setPrecio($_REQUEST['pedidoDetallePrecio']);
	$bean->setObservaciones($_REQUEST['pedidoDetalleObservaciones']);
	$bean->setTerminacionId($_REQUEST['terminacionIdPedDet']);

	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='actualiza'){
    $bean=new PedidoDetalle();
    $bean->setId($_REQUEST['pedidoDetalleId']);
	$bean->setCabeceraId($_REQUEST['DetallePedidosvalorIdPadre']);
	$bean->setSinPatas(isset($_REQUEST['sinPatas'])?1:0);
	$bean->setPiezaId($_REQUEST['piezaIdPedDet']);
	$bean->setCantidad($_REQUEST['pedidoDetalleCantidad']);
	$bean->setRemitidos($_REQUEST['remitidos']);
	$bean->setPrecio($_REQUEST['pedidoDetallePrecio']);
	$bean->setObservaciones($_REQUEST['pedidoDetalleObservaciones']);
	$pedDet=$_REQUEST['terminacionIdPedDet'];
	$bean->setTerminacionId(empty($pedDet)?null:$pedDet);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;


  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;
  }

  function cantidadTerminaciones($arr, $linea){
    $valorLinea=$arr[$linea];
    $terminaciones=array_keys($valorLinea);
    return count($terminaciones);
  }

?>