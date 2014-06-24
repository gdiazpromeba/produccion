<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/CostoSvcImpl.php';
header('Content-Type: text/html; charset=UTF-8');
//require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  $svc=new CostoSvcImpl();

  if ($ultimo=='arbol'){
    $piezaId=$_REQUEST['piezaId'];
    $raiz=$svc->arbol($piezaId);
    echo  "[" .  json_encode($raiz) . "]";  //esto devuelve la jerarquía completa, raíz incluido
    //echo  json_encode($raiz['children']) ;  //esto devuelve la jerarquía sin la raíz, empezando desde los primeros hijos
  
  
  }else if ($ultimo=='test') {
  	$piezaId='afcaf6817d171176d73dc9e798fb4212';
  	$etapaId='d2d18dda8f043d1508f2941923c53f7f';
  	$exito = $svc->test($piezaId, $etapaId);
    //echo json_encode($exito) ;	
    
  }else if ($ultimo=='insumosPorEtapa') {
  	$piezaId=$_REQUEST['piezaId']; 
  	$etapaId=$_REQUEST['etapaId'];
  	$ins = $svc->insumosPorEtapa($piezaId, $etapaId);
  	$filas=array();
  	foreach ($ins as $clave=>$valor){
  		$fila=array();
  		$fila['materialId']=$clave;
  		$fila['materialNombre']=$valor[0];
  		$fila['cantidad']=$valor[1];
  		$fila['unidadTexto']=$valor[2];
  		$fila['precioUnitario']=$valor[3];
  		$fila['precioTotal']=$valor[4];
  		$filas[]=$fila;
  	}
  	ordenaPorPrecioDesc($filas);
  	$res=array();
  	$res['total']=count($filas);
  	$res['data']=$filas;
    echo json_encode($res) ;

    
  }else if ($ultimo=='horasHombrePorEtapa') {
  	$piezaId=$_REQUEST['piezaId']; 
  	$etapaId=$_REQUEST['etapaId'];
  	$segundos = $svc->horasHombrePorEtapa($piezaId, $etapaId);
  	$res=FechaUtils::segundosAArrayHMS($segundos);
  	$costoPromedioHh=$svc->getCostoPromedioHh();
  	$costoHh=$segundos/3600 * $costoPromedioHh;
  	$res['costoHh']=$costoHh;
  	echo json_encode($res) ;
  	
  }else if ($ultimo=='horasHombre') {
  	$piezaId=$_REQUEST['piezaId']; 
  	$segundos = $svc->horasHombre($piezaId);
  	$res=FechaUtils::segundosAArrayHMS($segundos);
  	$costoPromedioHh=$svc->getCostoPromedioHh();
  	$costoHh=$segundos/3600 * $costoPromedioHh;
  	$res['costoHh']=$costoHh;
  	echo json_encode($res) ;  	
    
  }else if ($ultimo=='insumos') {
  	$piezaId=$_REQUEST['piezaId']; 
  	$ins = $svc->insumos($piezaId);
  	$filas=array();
  	foreach ($ins as $clave=>$valor){
  		$fila=array();
  		$fila['materialId']=$clave;
  		$fila['materialNombre']=$valor[0];
  		$fila['cantidad']=$valor[1];
  		$fila['unidadTexto']=$valor[2];
  		$fila['precioUnitario']=$valor[3];
  		$fila['precioTotal']=$valor[4];
  		$filas[]=$fila;
  	}
  	ordenaPorPrecioDesc($filas);
  	$res=array();
  	$res['total']=count($filas);
  	$res['data']=$filas;
    echo json_encode($res) ;  	
   
    
  }else if ($ultimo=='insertaProceso') {
  	$exito = $svc->insertaProceso($_REQUEST['piezaId'], $_REQUEST['padreId'], $_REQUEST['procesoId'],  $_REQUEST['procesoNombre'], 
  	                              $_REQUEST['orden'], $_REQUEST['tiempo'], $_REQUEST['dotacionSugerida'], $_REQUEST['ajuste']);
    echo json_encode($exito) ;	
    
  }else if ($ultimo=='modificaProceso') {
  	$exito = $svc->modificaProceso($_REQUEST['costoItemId'], $_REQUEST['procesoId'],  $_REQUEST['procesoNombre'], 
  	                               $_REQUEST['tiempo'], $_REQUEST['dotacionSugerida'], $_REQUEST['ajuste']);
    echo json_encode($exito) ;

  }else if ($ultimo=='insertaEtapa') {
  	$exito = $svc->insertaEtapa($_REQUEST['piezaId'], $_REQUEST['padreId'], $_REQUEST['etapaId'],  $_REQUEST['etapaNombre'], $_REQUEST['orden']);
    echo json_encode($exito) ;	
    
  }else if ($ultimo=='modificaEtapa') {
  	$exito = $svc->modificaEtapa($_REQUEST['costoItemId'], $_REQUEST['etapaId'],  $_REQUEST['etapaNombre']);
    echo json_encode($exito) ;    
    

  }else if ($ultimo=='modificaMaterial') {
  	$exito = $svc->modificaMaterial($_REQUEST['costoItemId'], $_REQUEST['materialId'], $_REQUEST['materialNombre'], $_REQUEST['cantidad']);
    echo json_encode($exito) ;      
        
  }else if ($ultimo=='insertaMaterial') {
  	$materialCantidad=$_REQUEST['materialCantidad'];
  	$exito = $svc->insertaMaterial($_REQUEST['piezaId'], $_REQUEST['padreId'], $_REQUEST['materialId'],  $_REQUEST['materialNombre'], $_REQUEST['orden'], $materialCantidad);
    echo json_encode($exito) ;	

  }else if ($ultimo=='insertaAjuste') {
  	$exito = $svc->insertaAjuste($_REQUEST['piezaId'], $_REQUEST['padreId'], $_REQUEST['ajusteNombre'], $_REQUEST['orden'], $_REQUEST['porcentaje']);
    echo json_encode($exito) ;	
    
  }else if ($ultimo=='insertaRaiz') {
  	$exito = $svc->insertaRaiz($_REQUEST['piezaId']);
    echo json_encode($exito) ;	    
  
  }else if ($ultimo=='borraNodo') {
  	$exito = $svc->borraNodo($_REQUEST['id']);
    echo json_encode($exito) ;

  }else if ($ultimo=='obtiene') {
  	$bean = $svc->obtiene($_REQUEST['id']);
    echo json_encode($bean) ;	
    	
  
  }else if ($ultimo=='corrigeIndices') {
  	$exito = $svc->corrigeOrdenes($_REQUEST);
    echo json_encode($exito) ;	
  
  }else{
  	echo "error, ninguno de los métodos del conector" ;
  }
  
  
  
  function ordenaPorPrecioDesc(&$filas){
  	$precioTotal=array();
    foreach ($filas as $fila) {
      $precioTotal[]  = $fila['precioTotal'];
    }
    array_multisort($precioTotal, SORT_DESC, $filas);
  }
?>