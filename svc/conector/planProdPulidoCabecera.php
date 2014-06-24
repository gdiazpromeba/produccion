<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdPulidoCab.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PlanProdPulidoCabSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);


  $svc = new PlanProdPulidoCabSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$empleadoId=$_REQUEST['empleadoId'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
		$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$beans=$svc->selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta);
		$cuenta=$svc->selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['planProdPulidoCabId']=$bean->getId();
	      $arrBean['empleadoId']=$bean->getEmpleadoId();
	      $arrBean['empleadoNombre']=$bean->getEmpleadoNombre();
	      $arrBean['empleadoApellido']=$bean->getEmpleadoApellido();
	      $arrBean['tarjetaNumero']=$bean->getTarjetaNumero();
	      $arrBean['planillaFecha']=$bean->getFechaLarga();
	      $arrBean['observacionesCab']=$bean->getObservacionesCab();
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
    $arrBean['planProdPulidoCabId']=$bean->getId();
    $arrBean['empleadoId']=$bean->getEmpleadoId();
    $arrBean['empleadoNombre']=$bean->getEmpleadoNombre();
    $arrBean['empleadoApellido']=$bean->getClienteNombre();
    $arrBean['tarjetaNumero']=$bean->getTarjetaNumero();
    $arrBean['planillaFecha']=$bean->getFechaLarga();
    $arrBean['observacionesCab']=$bean->getObservacionesCab();
    echo json_encode($arrBean);

  } else if ($ultimo=='inserta'){
    $bean=new PlanProdPulidoCab();
	$bean->setEmpleadoId($_REQUEST['empleadoId']);
	$bean->setFechaCorta($_REQUEST['planillaFecha']);
	$bean->setObservacionesCab($_REQUEST['observacionesCab']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='actualiza'){
    $bean=new PlanProdPulidoCab();
    $bean->setId($_REQUEST['planProdPulidoCabId']);
	$bean->setEmpleadoId($_REQUEST['empleadoId']);
	$bean->setFechaCorta($_REQUEST['planillaFecha']);
	$bean->setObservacionesCab($_REQUEST['observacionesCab']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;

  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;

  } else if ($ultimo=='planillaVacia'){
  	header("Content-Type: text/html; charset=utf-8");

	//parametros
	$fecha=$_REQUEST['planillaFecha'];
	$apellido=$_REQUEST['empleadoApellido'];
	$nombre=$_REQUEST['empleadoNombre'];
	$tarjetaNumero=$_REQUEST['tarjetaNumero'];

	$tarjetaNumero=str_pad($tarjetaNumero, 5 , "0", STR_PAD_LEFT );


	$format="JPEG";
	$width=300;
	$año=substr($fecha, 0, 4);
	$mes=substr($fecha, 5, 2);
	$dia=substr($fecha, 8, 2);
	$fecha=$dia . '/' . $mes . '/' . $año;
    $barcode=$año . $mes . $dia . $tarjetaNumero;

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
//	$html.= "    <img src='/produccion/recursos/imagenes/codigoBarras.png'> \n";
	$html.= "    <div class='titulo-pedido'>ALMAR MULTILAMINADOS</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
    $html.= "      <img style='position:relative;top:-60px;left:450px;' src='/produccion/util/barcode.php?barcode=" . $barcode . "&width=320&height=100'>  \n";
	$html.= "      <div style='position:absolute;top:-10px;width:350px;' class='subtitulo-pedido-caja'>PLANILLA DE PRODUCCIÓN - PULIDO </div> \n";
	$html.= "      <div style='position:relative;left:750px;top:-155px' class='subtitulo-pedido'>" . $apellido . ", ".  $nombre .  "</div> \n";
	$html.= "      <div style='position:relative;left:750px;top:-130px;width:100px;' class='subtitulo-pedido-caja'>" . $fecha . "</div> \n";
	$html.= "      <br/> \n";
	$html.= "    </div> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:-90px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:60px'>Día</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:60px'>Cantidad</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:60px'>Modelo</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' colspan='4'>Terminación</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/pulido.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/reparacion.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/tupi.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/lijaPelota.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/tacos.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/rotocort.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/escuadraGarlopa.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:30px'><img style='width:20px;height:80px' src='/produccion/recursos/imagenes/planillas/otra.jpg'/></td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:60px'>A Tapizar <br/>o mini</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:60px'>Rota</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' style='width:360px'>Observaciones</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Gua.</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Par.</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>p/Tap.</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido' width='100px'>Otro</td> \n";
	$html.= "      </tr> \n";

	$dias=array('lun', 'mar', 'mié', 'jue', 'vie');
	for ($h=0; $h<5; $h++){
	  $fechaSemana=FechaUtils::agregaDiasAMDA($fecha, $h);
	  $html.= "      <tr> \n";
	  $html.= "          <td class='fecha-pprod' rowspan='7'> \n";
	  $html.= "            " . $dias[$h] . ' <br/>' . substr($fechaSemana, 0, 5);
	  $html.= "          </td>  \n";
	  for ($i=0; $i<6; $i++){
			  $html.= "      <tr> \n";
			  $html.= "        <td style='height:30px'>&nbsp;</td> \n";
			  $html.= "        <td style='height:30px'>&nbsp;</td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td style='height:30px'>&nbsp;</td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td class='celdaTickChica'><input type='check' class='tickChico'/></td>  \n";
			  $html.= "        <td style='height:30px'>&nbsp;</td>  \n";
			  $html.= "      </tr> \n";
	  }
	}
	$html.= "    </table> \n";

	$html.= "    <div style='position:relative;top:-50px'> \n";
	$html.= "        <div style='position:absolute;top:120px;z-index:1' class='subtitulo-pedido'>V° B° Empleado</div>\n";
	$html.= "        <div style='position:absolute;width:240px;top:128px;left:150px;z-index:2'><hr/></div>\n";
	$html.= "        <div style='position:absolute;top:120px;z-index:1;left:570px' class='subtitulo-pedido'>V° B° Supervisor</div>\n";
	$html.= "        <div style='position:absolute;width:240px;top:128px;left:750px;z-index:2'><hr/></div>\n";
	$html.= "    </div> \n";

	$html.= "  </body> \n";
	$html.= "</html> \n";

    echo $html;
  }





?>