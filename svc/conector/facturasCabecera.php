<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/FacturasCabeceraSvcImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FacturaCabecera.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/MonedaUtils.php';
//require_once('FirePHPCore/fb.php');
header("Content-Type: text/plain; charset=utf-8");

   $url=$_SERVER['PHP_SELF'];
   $arr=explode("/", $url);
   $ultimo=array_pop($arr);
   $svc=new FacturasCabeceraSvcImpl();



  if ($ultimo=='selecciona'){
  	//parametros de paginaciÃ³n
  	$desde=$_REQUEST['start'];
 	$cuantos=$_REQUEST['limit'];
 	$sort=$_REQUEST['sort'];
 	$dir=$_REQUEST['dir'];
 	$clienteId=$_REQUEST['clienteIdBusCabFac'];
 	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
 	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
 	$facturaEstado=$_REQUEST['facturaEstado'];
 	$tipo=$_REQUEST['tipo'];
 	$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta, $facturaEstado, $tipo);
 	$cuenta=$svc->selTodosCuenta($clienteId, $fechaDesde, $fechaHasta, $facturaEstado, $tipo);
 	$subtotalGeneral=$svc->selSubtotalGeneral($clienteId, $fechaDesde, $fechaHasta, $estado, $tipo);
 	$datos=array();
 	foreach ($beans as $bean){
         $arrBean=array();
         $arrBean['facturaCabId']=$bean->getId();
         $arrBean['facturaNumero']=$bean->getNumero();
         $arrBean['facturaFecha']=$bean->getFechaLarga();
         $arrBean['clienteId']=$bean->getClienteId();
         $arrBean['remitoNumero']=$bean->getRemitoNumero();
         $arrBean['clienteNombre']=$bean->getClienteNombre();
         $arrBean['clienteTelefono']=$bean->getClienteTelefono();
         $arrBean['clienteLocalidad']=$bean->getClienteLocalidad();
         $arrBean['clienteCondicionIva']=$bean->getClienteCondicionIva();
         $arrBean['clienteCuit']=$bean->getClienteCuit();
         $arrBean['condicionesVenta']=$bean->getCondicionesVenta();
         $arrBean['subtotal']=$bean->getSubtotal();
         $arrBean['facturaTipo']=$bean->getTipo();
         $arrBean['ivaInscripto']=$bean->getIvaInscripto();
         $arrBean['descuento']=$bean->getDescuento();
         $arrBean['observacionesCab']=$bean->getObservaciones();
         $arrBean['estado']=$bean->getEstado();
         $arrBean['facturaTotal']=$bean->getTotal();
         $arrBean['subtotalGeneral']= $subtotalGeneral;
         $datos[]=$arrBean;
 	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
    echo json_encode($resultado) ;


  }else if ($ultimo=='calculaTotal'){
  	$facturaCabeceraId=$_REQUEST['facturaCabeceraId'];
  	$descuento=$_REQUEST['descuento'];
	$bean=$svc->calculaTotal($facturaCabeceraId, $descuento);
	$resultado=array();
	$resultado['subtotal']=$bean->getSubtotal();
	$resultado['ivaInscripto']=$bean->getIvaInscripto();
	$resultado['facturaTotal']=$bean->getTotal();
	echo json_encode($resultado) ;



   }else if ($ultimo=='obtiene'){
     $id=$_REQUEST['id'];
     $bean=$svc->obtiene($id);
     $arrBean['facturaCabId']=$bean->getId();
     $arrBean['facturaNumero']=$bean->getNumero();
     $arrBean['facturaFecha']=$bean->getFecha();
     $arrBean['clienteId']=$bean->getClienteId();
     $arrBean['remitoNumero']=$bean->getRemitoNumero();
     $arrBean['clienteNombre']=$bean->getClienteNombre();
     $arrBean['clienteTelefono']=$bean->getClienteTelefono();
     $arrBean['clienteLocalidad']=$bean->getClienteLocalidad();
     $arrBean['clienteCondicionIva']=$bean->getClienteCondicionIva();
     $arrBean['clienteCuit']=$bean->getClienteCuit();
     $arrBean['condicionesVenta']=$bean->getCondicionesVenta();
     $arrBean['subtotal']=$bean->getSubtotal();
     $arrBean['facturaTipo']=$bean->getTipo();
     $arrBean['ivaInscripto']=$bean->getIvaInscripto();
     $arrBean['descuento']=$bean->getDescuento();
     $arrBean['observacionesCab']=$bean->getObservaciones();
     $arrBean['estado']=$bean->getEstado();
     $arrBean['notaCredito']=$bean->isNotaCredito();
     $arrBean['facturaTotal']=$bean->getTotal();
     echo json_encode($resultado) ;


   }else if ($ultimo=='actualiza'){
     $bean= new FacturaCabecera();
     $bean->setId($_REQUEST['facturaCabId']);
     $bean->setNumero($_REQUEST['facturaNumero']);
     $bean->setFechaCorta($_REQUEST['facturaFecha']);
     $bean->setClienteId($_REQUEST['clienteIdCabFac']);
     $bean->setRemitoNumero($_REQUEST['remitoNumero']);
     $bean->setCondicionesVenta($_REQUEST['condicionesVenta']);
     $bean->setSubtotal($_REQUEST['subtotal']);
     $bean->setIvaInscripto($_REQUEST['ivaInscripto']);
     $bean->setDescuento($_REQUEST['descuento']);
     $bean->setObservaciones($_REQUEST['observacionesCab']);
     $bean->setEstado($_REQUEST['facturaEstado']);
     $bean->setTipo($_REQUEST['facturaTipo']);
     $bean->setTotal($_REQUEST['facturaTotal']);
 	 $exito=$svc->actualiza($bean);
	 echo json_encode($exito) ;


   }else if ($ultimo=='inserta'){
     $bean= new FacturaCabecera();
     $bean->setNumero($_REQUEST['facturaNumero']);
     $bean->setFechaCorta( $_REQUEST['facturaFecha']);
     $bean->setClienteId($_REQUEST['clienteIdCabFac']);
     $bean->setRemitoNumero($_REQUEST['remitoNumero']);
     $bean->setCondicionesVenta($_REQUEST['condicionesVenta']);
     $bean->setSubtotal($_REQUEST['subtotal']);
     $bean->setIvaInscripto($_REQUEST['ivaInscripto']);
     $bean->setDescuento($_REQUEST['descuento']);
     $bean->setObservaciones($_REQUEST['observacionesCab']);
     $bean->setEstado($_REQUEST['facturaEstado']);
     $bean->setTipo($_REQUEST['facturaTipo']);
     $bean->setTotal($_REQUEST['facturaTotal']);
 	 $exito=$svc->inserta($bean);
	 echo json_encode($exito) ;


 	} else if ($ultimo=='borra'){
 	  $exito=$svc->borra($_REQUEST['id']);
 	  echo json_encode($exito) ;

  } else if ($ultimo=='imprimeA'){
  	header("Content-Type: text/html; charset=utf-8");
  	setlocale(LC_MONETARY, 'es_AR');
	//parametros
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$facturaCabId = $_REQUEST['facturaCabId'];
	$mostrarReferencia = $_REQUEST['mostrarReferencia'];
	$datos=$svc->selReporteFactura($facturaCabId);

    $cliente=$datos[0]['clienteNombre'];
    $direccion=$datos[0]['direccion'];
    $localidad=$datos[0]['localidad'];
    $telefono=$datos[0]['telefono'];
    $condicionIva=$datos[0]['condicionIva'];
    $cuit=$datos[0]['cuit'];
    $facturaFecha=$datos[0]['facturaFecha'];
    $remitoNumero=$datos[0]['remitoNumero'];
    $observacionesCab=$datos[0]['observacionesCab'];
    $subtotal=$datos[0]['subtotal'];
    $ivaInscripto=$datos[0]['ivaInscripto'];
    $total=$datos[0]['total'];
    $arrFecha=explode("/", $facturaFecha);

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "    <div style='position:absolute;top:55px;left:560px'>" . $arrFecha[0] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:55px;left:595px'>" . $arrFecha[1] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:55px;left:630px'>" . substr($arrFecha[2],2) .  "</div> \n";
	$html.= "      <div style='position:absolute;top:175px;left:50px'>" . $cliente  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:175px;left:535px'>" . $telefono  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:200px;left:50px'>" . $direccion  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:200px;left:500px'>" . $localidad  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:225px;left:50px'>" . $condicionIva .  "</div> \n";
    $html.= "      <div style='position:absolute;top:225px;left:440px'>"  . $cuit . "</div> \n";
    $html.= "    </div'> \n";
	$html.= "    <div style='position:absolute;top:255px;left:490px'>" . $remitoNumero .  "</div> \n";
	$html.= "    <table style='border-style:full;width:100%;position:absolute;top:300px;left:-15px'> \n";
	for ($i=0; $i<count($datos); $i++){
	  $fila=$datos[$i];
	  $pieza = $fila['piezaNombre'];
	  if ($mostrarReferencia == 'true'){
	  	$pieza = $pieza . " " .  $fila['referenciaPedido'];
	  }
	  $html.= "    <tr> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:right;width:8%;height:20px'>" . $fila['cantidad'] . "</td> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:left;left:100px'>" . $pieza . "</td> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:right;width:8%'>" . money_format('%.2n', $fila['precioUnitario']) . "</td> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:right;left:565px'>" . money_format('%.2n', $fila['importe']) . "</td> \n";
	  $html.= "    </tr> \n";
	}
	$html.= "    </table> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:870px;left:150px'>" . $observacionesCab  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:840px;left:540px'>Subtotal</div>  \n";
	$html.= "      <div style='position:absolute;top:840px;left:610px'>" . $subtotal  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:860px;left:540px'>Inscripto</div>  \n";
	$html.= "      <div style='position:absolute;top:860px;left:610px'>" . $ivaInscripto  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:880px;left:550px'>Total</div>  \n";
	$html.= "      <div style='position:absolute;top:880px;left:610px'>" . $total  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;

  } else if ($ultimo=='imprimeB'){
  	header("Content-Type: text/html; charset=utf-8");
  	setlocale(LC_MONETARY, 'es_AR');
	//parametros
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$facturaCabId = $_REQUEST['facturaCabId'];
	$mostrarReferencia = $_REQUEST['mostrarReferencia'];
	$datos=$svc->selReporteFactura($facturaCabId);

    $cliente=$datos[0]['clienteNombre'];
    $direccion=$datos[0]['direccion'];
    $localidad=$datos[0]['localidad'];
    $telefono=$datos[0]['telefono'];
    $condicionIva=$datos[0]['condicionIva'];
    $cuit=$datos[0]['cuit'];
    $facturaFecha=$datos[0]['facturaFecha'];
    $remitoNumero=$datos[0]['remitoNumero'];
    $observacionesCab=$datos[0]['observacionesCab'];
    $subtotal=$datos[0]['subtotal'];
    $ivaInscripto=$datos[0]['ivaInscripto'];
    $total=$datos[0]['total'];
    $arrFecha=explode("/", $facturaFecha);

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "    <div style='position:absolute;top:55px;left:560px'>" . $arrFecha[0] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:55px;left:595px'>" . $arrFecha[1] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:55px;left:630px'>" . substr($arrFecha[2],2) .  "</div> \n";
	$html.= "      <div style='position:absolute;top:175px;left:50px'>" . $cliente  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:200px;left:50px'>" . $direccion  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:225px;left:50px'>" . $localidad  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:225px;left:535px'>" . $telefono  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <table style='border-style:full;width:100%;position:absolute;top:300px;left:-15px'> \n";
	for ($i=0; $i<count($datos); $i++){
	  $fila=$datos[$i];
	  $pieza = $fila['piezaNombre'];
	  if ($mostrarReferencia == 'true'){
	  	$pieza = $pieza . " " .  $fila['referenciaPedido'];
	  }
	  $precioUnitario = $fila['precioUnitario'] * 1.21;
	  $importe = $fila['importe'] * 1.21;
	  $html.= "    <tr> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:right;width:8%;height:20px'>" . $fila['cantidad'] . "</td> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:left;left:100px'>" . $pieza . "</td> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:right;width:8%'>" . MonedaUtils::money_format($precioUnitario) . "</td> \n";
	  $html.= "      <td class='item-tabla-factura' style='text-align:right;left:565px'>" . MonedaUtils::money_format($importe) . "</td> \n";
	  $html.= "    </tr> \n";
	}
	$html.= "    </table> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:870px;left:150px'>" . $observacionesCab  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:700px;left:530px'>Total</div>  \n";
	$html.= "      <div style='position:absolute;top:700px;left:565px'>" . $total  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;


  } else if ($ultimo=='imprimeNC'){
  	header("Content-Type: text/html; charset=utf-8");
  	setlocale(LC_MONETARY, 'es_AR');
	//parametros
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$facturaCabId = $_REQUEST['facturaCabId'];
	$mostrarReferencia = $_REQUEST['mostrarReferencia'];
	$datos=$svc->selReporteFactura($facturaCabId);

    $cliente=$datos[0]['clienteNombre'];
    $direccion=$datos[0]['direccion'];
    $localidad=$datos[0]['localidad'];
    $telefono=$datos[0]['telefono'];
    $condicionIva=$datos[0]['condicionIva'];
    $cuit=$datos[0]['cuit'];
    $facturaFecha=$datos[0]['facturaFecha'];
    $remitoNumero=$datos[0]['remitoNumero'];
    $observacionesCab=$datos[0]['observacionesCab'];
    $subtotal=$datos[0]['subtotal'];
    $ivaInscripto=$datos[0]['ivaInscripto'];
    $total=$datos[0]['total'];
    $arrFecha=explode("/", $facturaFecha);

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "    <div style='position:absolute;top:35px;left:525px'>" . $arrFecha[0] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:35px;left:560px'>" . $arrFecha[1] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:35px;left:595px'>" . substr($arrFecha[2],2) .  "</div> \n";
	$html.= "      <div style='position:absolute;top:155px;left:50px'>" . $cliente  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:155px;left:535px'>" . $telefono  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:180px;left:50px'>" . $direccion  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:180px;left:500px'>" . $localidad  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:205px;left:50px'>" . $condicionIva .  "</div> \n";
    $html.= "      <div style='position:absolute;top:205px;left:440px'>"  . $cuit . "</div> \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:400px;left:120px;font-size:48px'>NOTA DE CRÉDITO</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:930px;left:120px'>" . $observacionesCab  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:800px;left:565px'>" . $subtotal  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:865px;left:565px'>" . $ivaInscripto  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:910px;left:565px'>" . $total  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;

  } else if ($ultimo=='imprimeND'){
  	header("Content-Type: text/html; charset=utf-8");
  	setlocale(LC_MONETARY, 'es_AR');
	//parametros
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$facturaCabId = $_REQUEST['facturaCabId'];
	$mostrarReferencia = $_REQUEST['mostrarReferencia'];
	$datos=$svc->selReporteFactura($facturaCabId);

    $cliente=$datos[0]['clienteNombre'];
    $direccion=$datos[0]['direccion'];
    $localidad=$datos[0]['localidad'];
    $telefono=$datos[0]['telefono'];
    $condicionIva=$datos[0]['condicionIva'];
    $cuit=$datos[0]['cuit'];
    $facturaFecha=$datos[0]['facturaFecha'];
    $remitoNumero=$datos[0]['remitoNumero'];
    $observacionesCab=$datos[0]['observacionesCab'];
    $subtotal=$datos[0]['subtotal'];
    $ivaInscripto=$datos[0]['ivaInscripto'];
    $total=$datos[0]['total'];
    $arrFecha=explode("/", $facturaFecha);

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "    <div style='position:absolute;top:35px;left:525px'>" . $arrFecha[0] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:35px;left:560px'>" . $arrFecha[1] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:35px;left:595px'>" . substr($arrFecha[2],2) .  "</div> \n";
	$html.= "      <div style='position:absolute;top:155px;left:50px'>" . $cliente  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:155px;left:535px'>" . $telefono  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:180px;left:50px'>" . $direccion  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:180px;left:500px'>" . $localidad  .  "</div>  \n";
    $html.= "      <div style='position:absolute;top:205px;left:50px'>" . $condicionIva .  "</div> \n";
    $html.= "      <div style='position:absolute;top:205px;left:440px'>"  . $cuit . "</div> \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:400px;left:120px;font-size:48px'>NOTA DE DÉBITO</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:930px;left:120px'>" . $observacionesCab  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:800px;left:565px'>" . $subtotal  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:865px;left:565px'>" . $ivaInscripto  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:910px;left:565px'>" . $total  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;



  } else if ($ultimo=='anulaFactura'){
  	$id=$_REQUEST['id'];
  	$exito=$svc->anulaFactura($id);
  	echo json_encode($exito) ;

  } else if ($ultimo=='inhabilita'){
 	  $exito=$svc->borra($_REQUEST['id']);
 	  echo json_encode($exito) ;
  }
