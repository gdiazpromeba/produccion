<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ComunicacionPreciosDetalle.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/ComunicacionesPreciosDetalleSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new ComunicacionesPreciosDetalleSvcImpl();

  if ($ultimo=='selecciona'){
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$comPrecCabId=$_REQUEST['valorIdPadre'];
		$beans=$svc->selTodos($desde, $cuantos, $comPrecCabId);
		$cuenta=$svc->selTodosCuenta($comPrecCabId);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['comPrecDetId']=$bean->getId();
	      $arrBean['comPrecCabId']=$bean->getComPrecCabId();
	      $arrBean['piezaId']=$bean->getPiezaId();
	      $arrBean['piezaNombre']=$bean->getPiezaNombre();
	      $arrBean['precio']=$bean->getPrecio();
	      $arrBean['usaGeneral']=$bean->isUsaGeneral();
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
	$arrBean['comPrecDetId']=$bean->getId();
    $arrBean['comPrecCabId']=$bean->getComPrecCabId();
    $arrBean['piezaId']=$bean->getPiezaId();
    $arrBean['piezaNombre']=$bean->getPiezaNombre();
    $arrBean['precio']=$bean->getPrecio();
    $arrBean['usaGeneral']=$bean->isUsaGeneral();
    echo json_encode($arrBean);	  
    
  } else if ($ultimo=='inserta'){
    $bean=new ComunicacionPreciosDetalle(); 
	$bean->setComPrecCabId($_REQUEST['valorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaIdComDet']);
	$bean->setPrecio($_REQUEST['comDetPrecio']);
	$bean->setUsaGeneral(empty($_REQUEST['usaGeneral'])?0:1);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
	
  } else if ($ultimo=='haceUsarGeneral'){
    $piezaId=$_REQUEST['piezaId'];
    $clienteId=$_REQUEST['clienteId'];
	$exito=$svc->haceUsarGeneral($piezaId, $clienteId);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='actualiza'){
    $bean=new ComunicacionPreciosDetalle();
    $bean->setId($_REQUEST['comPrecDetId']);
    $bean->setComPrecCabId($_REQUEST['valorIdPadre']);
	$bean->setPiezaId($_REQUEST['piezaIdComDet']);
	$bean->setUsaGeneral(empty($_REQUEST['usaGeneral'])?0:1);
	$bean->setPrecio($_REQUEST['comDetPrecio']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
	
  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;
		
  } else if ($ultimo=='selReporteComunicacion'){
  	header("Content-Type: text/html; charset=utf-8");
	//parametros 
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$comPrecCabId = $_REQUEST['comPrecCabId'];
	$datos=$svc->selReporteComunicacion($comPrecCabId);
    $cliente=$datos[0]['clienteNombre'];
    $fecha=$datos[0]['fecha'];
    $destinatario=$datos[0]['destinatario'];
    $autorizador=$datos[0]['autorizador'];

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body class='texto-cotizacion'> \n";
	$html.= "    <img src='/produccion/recursos/iconos/logoAlmar.png' /> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div class='texto-membrete'  style='position:absolute;top:10px;left:500px'> \n";
	$html.= "      Almar Multilaminados S.A.<br/> \n";
	$html.= "      Calle 103 Nº 4349<br/> \n";
	$html.= "      B1653GMF<br/> \n";
	$html.= "      Villa Ballester, Pcia de Buenos Aires<br/> \n";
	$html.= "      Argentina<br/> \n";
	$html.= "      Tel: 4849-0148 <br/> \n";
	$html.= "      Tel/Fax: 4768-3970 <br/> \n";
	$html.= "      Tel/Fax: 4768-3970 <br/> \n";
	$html.= "      www.almarlaminados.com \n";
	$html.= "    </div>  \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' > Sres "  . $cliente . ": </div> \n";
	$html.= "      <div style='position:absolute;top:0px;left:550px;' > " . FechaUtils::ahoraDMA() . " </div> \n";
	if (!empty($destinatario)){
	  $html.= "      <div style='position:absolute;top:15px;width:350px;' > Atención "  . $destinatario . ": </div> \n";
	}
	$html.= "      <div style='position:absolute;top:45px'>Nos dirigimos a ustedes para comunicarles nuestra nueva lista de precios, de los " .
			" artículos que se detallan a continuación. Dicha lista tiene vigencia desde el día " . $fecha . " </div> \n";
	$html.= "    <table style='border-style:full;position:absolute;top:95px' border=1> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:560px'>Artículo</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Precio</td> \n";
	$html.= "      </tr> \n";
	for ($i=0; $i<count($datos); $i++){
	  $fila=$datos[$i];
	  //$topFila=110 + ($i+1) * 18;
	  $html.= "      <tr> \n";
	  $html.= "        <td class='item-tabla-cotizacion' style='text-align:left'>" . $fila['piezaNombre'] . "</td> \n";
	  $html.= "        <td class='precio-tabla-cotizacion'> " . number_format ($fila['precio'], 2, ',', '.' ) . "</td> \n";
	  $html.= "      </tr> \n";  
	}
	$html.= "    </table> \n";
	$yFirma=count($datos) * 18 + 250;
	$html.= "    <div style='position:absolute;top:" .$yFirma . "'>Atentamente: \n";
	$html.= "      <br/>";
	$html.= "      <br/>";
	$html.= "      <div style='position:relative;left:50px'>" . $autorizador . "</div>";
	$html.= "    </div>\n";
    $html.= "  </body> \n";
	$html.= "</html> \n";		
		
    echo $html;
		
  }

?>