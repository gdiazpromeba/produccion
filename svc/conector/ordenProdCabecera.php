<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenProduccion.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/OrdenesProduccionCabSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//  require_once('FirePHPCore/fb.php');
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  
  $svc = new OrdenesProduccionCabSvcImpl();

  if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$ordenNumero=$_REQUEST['ordenNumero'];
		$ordenEstado=$_REQUEST['ordenEstado'];
		$sort=$_REQUEST['sort'];
		$dir=$_REQUEST['dir'];
		$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
		$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
		$beans=$svc->selTodos($desde, $cuantos, $sort, $dir, $ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta);
		$cuenta=$svc->selTodosCuenta($ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta);
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
	      $arrBean['ordProdCabId']=$bean->getId();
	      $arrBean['ordenNumero']=$bean->getNumero();
	      $arrBean['ordenEstado']=$bean->getEstado();
	      $arrBean['ordenFecha']=$bean->getFechaLarga();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;	
		
  }else if ($ultimo=='selReporte'){
  	header("Content-Type: text/html; charset=utf-8");
	//parametros 
	$desde=0;
	$cuantos=1000;
	$sort=null;
	$dir=null;
	$ordProdCabId = $_REQUEST['ordProdCabId'];
	$datos=$svc->selReporteAltaOrden($ordProdCabId);
  
			
    $fecha=$datos[0]['ordenFecha'];
    $numero=$datos[0]['ordenNumero'];

    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	$html.= "    <div class='titulo-pedido'>ALMAR MULTILAMINADOS</div> \n";
	$html.= "    <br/> \n";
	$html.= "    <br/> \n";
	$html.= "    <div style='position:relative'> \n";
	$html.= "      <div style='position:absolute;top:0px;width:350px;' class='subtitulo-pedido-caja'>ORDEN DE PRODUCCIÓN</div> \n";
	$html.= "      <div style='position:absolute;left:470px;top:5px' class='subtitulo-pedido'>nº</div> \n";
	$html.= "      <div style='position:absolute;left:500px;top:0px;width:100px;' class='subtitulo-pedido-caja'>" . $numero . "</div> \n";
	$html.= "    <br/> \n";
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
	$html.= "      <tr><td class='encabezado-tabla-pedido' colspan='2'>Entregas parciales</td></tr> \n";
	$html.= "      <tr> \n";
	for ($h=0; $h<2 ; $h++){
	  $html.= "      <td>  \n";
	  $html.= "        <table>  \n";
	  $html.= "          <tr> \n";
	  $html.= "            <td class='encabezado-tabla-pedido' style=''>Ítem</td> \n";
	  $html.= "            <td class='encabezado-tabla-pedido' style=''>Fecha</td> \n";
	  $html.= "            <td class='encabezado-tabla-pedido' style=''>Cantidad</td> \n";
	  $html.= "            <td class='encabezado-tabla-pedido' style='width:220px'>Observaciones</td> \n";
	  $html.= "          </tr> \n";
	  for ($i=0; $i<15; $i++){
	    $html.= "      <tr> \n";
	    $html.= "        <td class='item-parcial-pedido' style='height:30px'>&nbsp;</td> \n";
	    $html.= "        <td class='item-parcial-pedido'>&nbsp;</td> \n";
	    $html.= "        <td class='item-parcial-pedido'>&nbsp;</td> \n";
	    $html.= "        <td class='item-parcial-pedido'>&nbsp;</td> \n";
	    $html.= "      </tr> \n";  
	  }
	  $html.= "        </table>  \n";
	  $html.= "      </td>  \n";
	}
	$html.= "      </tr> \n";
	$html.= "    </table> \n";
	$html.= "  </body> \n";
	$html.= "</html> \n";		
		
    echo $html;
		
		
		
  			
		
  }else if ($ultimo=='obtiene'){
    $id=$_REQUEST['id'];
	$bean=$svc->obtiene($id);
	$arrBean=array();
    $arrBean['ordProdCabId']=$bean->getId();
    $arrBean['ordenNumero']=$bean->getNumero();
    $arrBean['ordenFecha']=$bean->getFechaLarga();
    $arrBean['ordenEstado']=$bean->getEstado();
    echo json_encode($arrBean);	  
    
  } else if ($ultimo=='inserta'){
    $bean=new OrdenProduccion(); 
    $bean->setNumero($_REQUEST['ordenNumero']);
	$bean->setFechaCorta($_REQUEST['ordenFecha']);
	$bean->setEstado($_REQUEST['ordenEstado']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new OrdenProduccion();
    $bean->setId($_REQUEST['ordProdCabId']);
    $bean->setNumero($_REQUEST['ordenNumero']);
	$bean->setFechaCorta($_REQUEST['ordenFecha']);
	$bean->setEstado($_REQUEST['ordenEstado']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
	
  }else if ($ultimo=='sugiereNumero'){		
		$max=$svc->sugiereNumero();
		$resultado=array();
		$resultado['total']=1;
		$resultado['data']=$max;
		echo json_encode($resultado) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
	
  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  }

?>