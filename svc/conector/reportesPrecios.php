<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosGeneralesSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new PreciosGeneralesSvcImpl();

if ($ultimo=='sillones'){
  	header("Content-Type: text/html; charset=utf-8");
	
	//parametros
	$fecha=date("Y-m-d");
	
	$año=substr($fecha, 0, 4);
	$mes=substr($fecha, 5, 2);
	$dia=substr($fecha, 8, 2);
	$fecha=$dia . '/' . $mes . '/' . $año;
    
	$precios=$svc->selSillones();

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>ALMAR MULTILAMINADOS</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' class='subtitulo-pedido-caja'>Precios Generales - SILLONES</div> \n";
	$html.= "      <div style='position:absolute;top:0px;left:370px;width:100px;' class='subtitulo-pedido-caja'>" . $fecha . "</div> \n";
	$html.= "    <br/> \n";
	$html.= "    </div> \n";
	
	//Suraki
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Línea Tango o Suraki</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Tamaño</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin contacto</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto entero</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto recortado</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Bajo</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiBajoSci'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiBajoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiBajoCir'] . "</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Mediano</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiMedianoSci'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiMedianoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiMedianoCir'] . "</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Alto</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiAltoSci'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiAltoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['surakiAltoCir'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";
    
	//Aillites
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Estructura Aillites</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Tamaño</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin contacto</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto entero</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto recortado</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Bajo</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesBajoSci'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesBajoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesBajoCir'] . "</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Mediano</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesMedianoSci'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesMedianoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesMedianoCir'] . "</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Alto</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesAltoSci'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesAltoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['aillitesAltoCir'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";
    
	//Chino
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Estructura Chino</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Tamaño</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto entero</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto recortado</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Bajo</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['chinoBajoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['chinoBajoCir'] . "</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Alto</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['chinoAltoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['chinoAltoCir'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";    
    
	//Berlín
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Estructura Berlín</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Tamaño</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto entero</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto recortado</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Bajo</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['berlinBajoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['berlinBajoCir'] . "</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Alto</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['berlinAltoCie'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['berlinAltoCir'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";       
    
	//Fórmula general
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Comparación general</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Tamaño</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin contacto</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto entero</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Contacto recortado</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Bajo</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>100%</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>108%</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>116%</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Mediano</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>111%</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>116%</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>127%</td> \n";
    $html.= "      <tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Alto</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>120%</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>127%</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>138%</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";        

	$html.= "  </body> \n";
	$html.= "</html> \n";		
		
    echo $html;
 
  }else if ($ultimo=='sillas'){
  	header("Content-Type: text/html; charset=utf-8");
	
	//parametros
	$fecha=date("Y-m-d");
	
	$año=substr($fecha, 0, 4);
	$mes=substr($fecha, 5, 2);
	$dia=substr($fecha, 8, 2);
	$fecha=$dia . '/' . $mes . '/' . $año;
    
	$precios=$svc->selSillas();

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>ALMAR MULTILAMINADOS</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' class='subtitulo-pedido-caja'>Precios Generales - SILLAS</div> \n";
	$html.= "      <div style='position:absolute;top:0px;left:370px;width:100px;' class='subtitulo-pedido-caja'>" . $fecha . "</div> \n";
	$html.= "    <br/> \n";
	$html.= "    </div> \n";
	
	//Jacobsen Mariposa
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";	
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Jacobsen Mariposa</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Enchapado</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin tacos</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Con tacos</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Guatambú</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['jacomariGuatSin'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['jacomariGuatCon'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";
    
	
	//Service
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";	
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Service</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Enchapado</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin tacos</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Con tacos</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Guatambú</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['serviceGuatSin'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['servceGuatCon'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";
    
	//New
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";	
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>New</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Enchapado</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin tacos</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Con tacos</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Guatambú</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['newGuatSin'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['newGuatCon'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";
    
	//Expo
    $html.= "    <br/> \n";
	$html.= "    <br/> \n";	
	$html.= "    <table style='border-style:full;width:100%;position:relative;top:70px' border='1'> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px' colspan=4>Expo</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Enchapado</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Sin tacos</td> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Con tacos</td> \n";
	$html.= "      </tr> \n";
	$html.= "      <tr> \n";
	$html.= "        <td class='encabezado-tabla-pedido' style='width:60px'>Guatambú</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['expoGuatSin'] . "</td> \n";
	$html.= "        <td class='item-tabla-precios' style='width:60px'>" . $precios['expoGuatCon'] . "</td> \n";
    $html.= "      <tr> \n";
    $html.= "    </table> \n";
    
	$html.= "  </body> \n";
	$html.= "</html> \n";		
		
    echo $html;
 
  }  
  
  else if ($ultimo=='selPlano'){
		//parametros 
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$empleadoId=$_REQUEST['empleadoId'];
		$matrizId=$_REQUEST['matrizId'];
		$matrizTipo=$_REQUEST['matrizTipo'];
		$estacionTrabajo=$_REQUEST['estacionTrabajo'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
		$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$reparada=CheckUtils::procesaCheck($_REQUEST['reparada']);
		$descartada=CheckUtils::procesaCheck($_REQUEST['descartada']);
        $beans=$svc->selPlano($desde, $cuantos, $empleadoId, $estacionTrabajo,  $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
        $cuenta=$svc->selPlanoCuenta($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
		$datos=array();
		
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['empleadoId']=$bean->getEmpleadoId();
		  $arrBean['empleadoApellido']=$bean->getEmpleadoApellido();
		  $arrBean['empleadoNombre']=$bean->getEmpleadoNombre();
		  $arrBean['matrizId']=$bean->getMatrizId();
		  $arrBean['matrizNombre']=$bean->getMatrizNombre();
		  $arrBean['matrizTipo']=$bean->getMatrizTipo();
		  $arrBean['estacionTrabajo']=$bean->getEstacionTrabajo();
		  $arrBean['fecha']=$bean->getFechaLarga();
		  $arrBean['cantidad']=$bean->getCantidad();
		  $arrBean['cantidadTotal']=$bean->getCantidadTotal();
		  $arrBean['reparada']=$bean->isReparada();
		  $arrBean['descartada']=$bean->isDescartada();
		  $arrBean['observaciones']=$bean->getObservacionesDet();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;			
  }
  

?>