<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdChapa.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PlanProdChapaCabSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);


  $svc = new PlanProdChapaCabSvcImpl();

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
	      $arrBean['plPrChapCabId']=$bean->getId();
	      $arrBean['empleadoId']=$bean->getEmpleadoId();
	      $arrBean['empleadoNombre']=$bean->getEmpleadoNombre();
	      $arrBean['empleadoApellido']=$bean->getEmpleadoApellido();
	      $arrBean['tarjetaNumero']=$bean->getTarjetaNumero();
	      $arrBean['planillaFecha']=$bean->getFechaLarga();
	      $arrBean['observacionesCab']=$bean->getObservaciones();
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
    $arrBean['plPrChapCabId']=$bean->getId();
    $arrBean['empleadoId']=$bean->getEmpleadoId();
    $arrBean['empleadoNombre']=$bean->getEmpleadoNombre();
    $arrBean['empleadoApellido']=$bean->getClienteNombre();
    $arrBean['tarjetaNumero']=$bean->getTarjetaNumero();
    $arrBean['planillaFecha']=$bean->getFechaLarga();
    $arrBean['observacionesCab']=$bean->getObservaciones();
    echo json_encode($arrBean);

  } else if ($ultimo=='inserta'){
    $bean=new PlanProdChapa();
	$bean->setEmpleadoId($_REQUEST['empleadoId']);
	$bean->setFechaCorta($_REQUEST['planillaFecha']);
	$bean->setObservaciones($_REQUEST['observacionesCab']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;

  } else if ($ultimo=='actualiza'){
    $bean=new PlanProdChapa();
    $bean->setId($_REQUEST['plPrChapCabId']);
	$bean->setEmpleadoId($_REQUEST['empleadoId']);
	$bean->setFechaCorta($_REQUEST['planillaFecha']);
	$bean->setObservaciones($_REQUEST['observacionesCab']);
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
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' class='subtitulo-pedido-caja'>PROGRAMA DE PRODUCCIÓN - CHAPA </div> \n";
	$html.= "      <div style='position:absolute;left:7px;top:40px' class='subtitulo-pedido'>" . "NÚMERO: "  .  "</div> \n";
	$html.= "    <br/> \n";
	$html.= "    </div> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:85px' border='1'> \n";
	$html.= "      <tr> \n";
    $html.= "        <td class='encabezado-tabla-pedido' rowspan='2'>Día</td> \n";	
	$html.= "        <td style='width:140px' class='encabezado-tabla-pedido' rowspan='2'>Medida</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' >Paquetes (x8)</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' colspan='3'>Enchapado</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' rowspan='2' >Observaciones</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Gua.</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Par.</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido' width='100px'>Otro</td> \n";
	$html.= "      </tr> \n";

    
	$dias=array('lun', 'mar', 'mié', 'jue', 'vie');
	for ($h=0; $h<5; $h++){
	  //$oFecha=new DateTime(); $oFecha->setDate($año, $mes, $dia);
	  //$oFecha->add(new DateInterval('P' . $h . 'D'));
	  $fechaSemana=FechaUtils::agregaDiasAMDA($fecha, $h);
//	  $fechaSemana=date($año . '-' . $mes . '-' . ($dia + $h));
	  $html.= "      <tr> \n";
	  $html.= "          <td class='fecha-pprod' rowspan='7'> \n";
	  $html.= "            " . $dias[$h] . ' <br/>' . substr($fechaSemana, 0, 5);
	  $html.= "          </td>  \n";	
      	
	  $html.= "      <tr> \n";
	  $html.= "        <td class='celdaEnchapado'>90 x 55</td> \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";	
		$html.= "        <td>&nbsp;</td>  \n";
		$html.= "      </tr> \n";
	
		$html.= "      <tr> \n";
		$html.= "        <td class='celdaEnchapado'>110 x 55</td> \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
		$html.= "      </tr> \n";
	
		$html.= "      <tr> \n";
		$html.= "        <td class='celdaEnchapado'>120 x 65</td> \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td>&nbsp;</td>  \n";	
		$html.= "      </tr> \n";
		  
		$html.= "      <tr> \n";
	    $html.= "        <td class='celdaEnchapado'>130 x 55</td> \n";
		$html.= "        <td>&nbsp;</td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
		$html.= "      </tr> \n";
	
		$html.= "      <tr> \n";
		$html.= "        <td class='celdaEnchapado'>75 x 50</td> \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td>&nbsp;</td>  \n";	
		$html.= "      </tr> \n";
	
		$html.= "      <tr> \n";
		$html.= "        <td class='celdaEnchapado'>75 x 75</td> \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td class='celdaTick'><input type='check' class='tick'/></td>  \n";
		$html.= "        <td>&nbsp;</td>  \n";
	    $html.= "        <td>&nbsp;</td>  \n";	
		$html.= "      </tr> \n";

	    $html.= "      </tr> \n";
	}
	$html.= "    </table> \n";

	$html.= "    <div style='position:relative'> \n";
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