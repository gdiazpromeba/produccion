<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PnaLaqueador.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/RemitoLaqueadoCabecera.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/RemitosLaqueadoSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
  //require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);


  $svc = new RemitosLaqueadoSvcImpl();

  if ($ultimo=='selPedidosNoAsignados'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$beans=$svc->selPedidosNoAsignados($desde, $cuantos);
	$cuenta=$svc->selPedidosNoAsignadosCuenta();
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
          $arrBean['clienteId']=$bean->getClienteId();
          $arrBean['clienteNombre']=$bean->getClienteNombre();
          $arrBean['pedidoCabeceraId']=$bean->getPedidoCabeceraId();
          $arrBean['pedidoDetalleId']=$bean->getPedidoDetalleId();
          $arrBean['pedidoNumero']=$bean->getPedidoNumero();
          $arrBean['piezaId']=$bean->getPiezaId();
          $arrBean['piezaNombre']=$bean->getPiezaNombre();
          $arrBean['cantidad']=$bean->getCantidad();
          $arrBean['fechaPrometida']=$bean->getFechaPrometidaLarga();
          $arrBean['terminacionId']=$bean->getTerminacionId();
          $arrBean['terminacionNombre']=$bean->getTerminacionNombre();
          $arrBean['asignado']=false;
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado) ;

  }else if ($ultimo=='selRemitosCabecera'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$laqueadorId=$_REQUEST['laqueadorId'];
        $envioDesde=FechaUtils::cadenaAObjeto($_REQUEST['envioDesde']);
	$envioHasta=FechaUtils::cadenaAObjeto($_REQUEST['envioHasta']);
	$estado=$_REQUEST['estado'];
	$beans=$svc->selCabecera($desde, $cuantos,  $laqueadorId, $envioDesde, $envioHasta, $estado );
	$cuenta=$svc->selCabeceraCuenta($laqueadorId, $envioDesde, $envioHasta, $estado );
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean['id']=$bean->getId();
	  $arrBean['laqueadorId']=$bean->getLaqueadorId();
	  $arrBean['laqueadorNombre']=$bean->getLaqueadorNombre();
	  $arrBean['fechaEnvio']=$bean->getFechaEnvioLarga();
          $arrBean['numero']=$bean->getNumero();
          $arrBean['estado']=$bean->getEstado();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado) ;
	
  }else if ($ultimo=='selRemitosDetalle'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$cabeceraId=$_REQUEST['cabeceraId'];
	$beans=$svc->selDetalles($desde, $cuantos,  $cabeceraId);
	$cuenta=$svc->selDetallesCuenta($cabeceraId);
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean['id']=$bean->getId();
	  $arrBean['cabeceraId']=$bean->getCabeceraId();
	  $arrBean['item']=$bean->getItem();
	  $arrBean['pedidoDetalleId']=$bean->getPedidoDetalleId();
	  $arrBean['cantidad']=$bean->getCantidad();
	  $arrBean['clienteNombre']=$bean->getClienteNombre();
	  $arrBean['terminacionNombre']=$bean->getTerminacionNombre();
	  $arrBean['piezaNombre']=$bean->getPiezaNombre();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo json_encode($resultado) ;	

  }else if ($ultimo=='generaRemito'){
        $jsondata=$_REQUEST['objetoJSON'];
        $data = json_decode($jsondata);
	$exito=$svc->genera($data);
	echo json_encode($exito) ;

  }else if ($ultimo=='remite'){
        $id=$_REQUEST['remLaqCabId'];
	    $exito = $svc->remiteRemCab($id);
	    echo json_encode($exito) ;
	    
  }else if ($ultimo=='completa'){
        $id=$_REQUEST['remLaqCabId'];
	    $exito = $svc->completaRemCab($id);
	    echo json_encode($exito) ;	    

  }else if ($ultimo=='borraRemCab'){
        $id=$_REQUEST['remLaqCabId'];
	    $exito = $svc->borraRemCab($id);
	    echo json_encode($exito) ;
  
  }else if ($ultimo=='imprimeRemLaq'){
          $id=$_REQUEST['remLaqCabId'];
  	  $rep = $svc->imprimeRemLaq($id);
  	  
  	  
	header("Content-Type: text/html; charset=utf-8");
	$laqueador=$rep['laqueadorNombre'];
	$numero=$rep['numero'];
	$fechaEnvio=$rep['fechaEnvio'];


      $html= "<html> \n";
      $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>ALMAR ARGENTINA - REMITO DE LAQUEADO</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' class='subtitulo-pedido-caja'>" . $laqueador . "</div> \n";
	$html.= "      <div style='position:absolute;left:470px;top:5px' class='subtitulo-pedido'>nº</div> \n";
	$html.= "      <div style='position:absolute;left:500px;top:0px;width:100px;' class='subtitulo-pedido-caja'>" . $numero . "</div> \n";
	$html.= "    <br/> \n";
	$html.= "      <div style='position:absolute;top:0px;left:670px;width:100px;' class='subtitulo-pedido-caja'>" . $fechaEnvio . "</div> \n";
	$html.= "    </div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:30px'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:20px'>Ítem</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:460px'>Artículo</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:460px'>Terminacion</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Cantidad</td> \n";
	$html.= "      </tr> \n";
	foreach ($rep['detalles'] as $det){
	  $html.= "      <tr> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:center'>" . $det['item'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:left'>" . $det['piezaNombre'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:left'>" . $det['terminacionNombre'] . "</td> \n";
	  $html.= "        <td class='item-tabla-pedido' style='text-align:right'>" . $det['cantidad'] . "</td> \n";
	  $html.= "      </tr> \n";  
	}
	$html.= "    </table> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";		
	  		
        echo $html;
  }


?>