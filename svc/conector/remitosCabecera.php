<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Remito.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/RemitosCabeceraSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc = new RemitosCabeceraSvcImpl();



  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$clienteId=$_REQUEST['clienteId'];
		$estado=$_REQUEST['remitoEstado'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
    	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$numero=$_REQUEST['remitoNumero'];
		$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
		$cuenta=$svc->selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['remitoCabeceraId']=$bean->getId();
	      $arrBean['clienteId']=$bean->getClienteId();
	      $arrBean['clienteNombre']=$bean->getClienteNombre();
	      $arrBean['remitoFecha']=$bean->getFechaLarga();
	      $arrBean['remitoNumero']=$bean->getNumero();
	      $arrBean['remitoEstado']=$bean->getEstado();
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
    $arrBean['remitoCabeceraId']=$bean->getId();
    $arrBean['clienteId']=$bean->getClienteId();
    $arrBean['clienteNombre']=$bean->getClienteNombre();
    $arrBean['remitoFecha']=$bean->getFechaLarga();
    $arrBean['remitoNumero']=$bean->getNumero();
    $arrBean['remitoEstado']=$bean->getEstado();
    $arrBean['observaciones']=$bean->getObservaciones();
    echo json_encode($arrBean);

  }else if ($ultimo=='generaFactura'){
    $remitoCabeceraId=$_REQUEST['remitoCabeceraId'];
    $exito=$svc->generaFactura($remitoCabeceraId);
	echo json_encode($exito) ;

  } else if ($ultimo=='inserta'){
    $bean=new Remito(); 
	$bean->setClienteId($_REQUEST['clienteIdCabRem']);
	$bean->setFechaCorta($_REQUEST['remitoFecha']);
	$bean->setNumero($_REQUEST['remitoNumero']);
	$bean->setEstado($_REQUEST['remitoEstado']);
	$bean->setObservaciones($_REQUEST['observaciones']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='actualiza'){
    $bean=new Remito();
    $bean->setId($_REQUEST['remitoCabeceraId']);
	$bean->setClienteId($_REQUEST['clienteIdCabRem']);
	$bean->setFechaCorta($_REQUEST['remitoFecha']);
	$bean->setNumero($_REQUEST['remitoNumero']);
	$bean->setEstado($_REQUEST['remitoEstado']);
	$bean->setObservaciones($_REQUEST['observaciones']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	

  

  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	

  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	

  } else if ($ultimo=='selReporte'){
  	header("Content-Type: text/html; charset=utf-8");
	//parametros 
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$remitoCabeceraId = $_REQUEST['remitoCabeceraId'];
	$datos=$svc->selReporteRemito($remitoCabeceraId);
    $cliente=$datos[0]['clienteNombre'];
    $direccion=$datos[0]['direccion'];
    $localidad=$datos[0]['localidad'];
    $telefono=$datos[0]['telefono'];
    $condicionIva=$datos[0]['condicionIva'];
    $cuit=$datos[0]['cuit'];
    $fecha=$datos[0]['remitoFecha'];
    $numero=$datos[0]['numero'];
    $observaciones=$datos[0]['observaciones'];
    $arrFecha=explode("/", $fecha);

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='cabecera-remito'> \n";
	$html.= "    <div style='position:absolute;top:60px;left:595px'>" . $arrFecha[0] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:60px;left:630px'>" . $arrFecha[1] .  "</div> \n";
	$html.= "    <div style='position:absolute;top:60px;left:665px'>" . substr($arrFecha[2],2) .  "</div> \n";

	if ($condicionIva=='Responsable inscripto'){
      $html.= "      <div style='position:absolute;top:170px;left:95px'>Responsable inscripto</div> \n";
      $html.= "      <div style='position:absolute;top:170px;left:595px'>"  . $cuit . "</div> \n";
	}else if ($condicionIva=='Responsable no inscripto'){
      $html.= "      <div style='position:absolute;top:170px;left:135px'>Responsable no inscripto</div> \n";
	} 

	$html.= "      <div style='position:absolute;top:195px;left:50px'>Señor(es):&nbsp;" . $cliente  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:220px;left:50px'>Domicilio:&nbsp;" . $direccion  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:245px;left:50px'>Localidad:&nbsp;" . $localidad  .  "</div>  \n";
	$html.= "      <div style='position:absolute;top:245px;left:550px'>Teléfono:&nbsp;" . $telefono  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "    <table style='border-style:full;width:100%;position:absolute;top:300px'> \n";
	$html.= "    <tr> \n";
	$html.= "      <td class='encabezado-tabla-remito' style='text-align:right'>Cantidad</td> \n";
	$html.= "      <td class='encabezado-tabla-remito' style='text-align:left'>Descripción</td> \n";
	$html.= "    </tr> \n";  
	for ($i=0; $i<count($datos); $i++){
	  $fila=$datos[$i];
	  $html.= "    <tr> \n";
	  $html.= "      <td class='item-tabla-remito' style='text-align:right'>" . $fila['cantidad'] . "</td> \n";
	  $html.= "      <td class='item-tabla-remito' style='text-align:left'>" . $fila['piezaNombre'] . "</td> \n";
	  $html.= "    </tr> \n";  
	}
	$html.= "    </table> \n";
    $html.= "    <div class='cabecera-remito'> \n";
	$html.= "      <div style='position:absolute;top:930px;left:120px'>" . $observaciones  .  "</div>  \n";
    $html.= "    </div'> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";		
    echo $html;

    

  } else if ($ultimo=='anulaRemito'){
  	$id=$_REQUEST['id'];
  	$exito=$svc->anulaRemito($id);
  	echo json_encode($exito) ;	
  }



?>