<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pieza.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PiezasSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");
//  require_once('FirePHPCore/fb.php');

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc = new PiezasSvcImpl();

  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_GET['start'];
	$cuantos=$_GET['limit'];
	$cadena=$_GET['query'];
	$callback=$_GET['callback'];
	$beans=$svc->selPorComienzo($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorComienzoCuenta($cadena);
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['piezaId']=$bean->getId();
	  $arrBean['piezaNombre']=$bean->getNombre();
	  $arrBean['piezaFicha']=$bean->getFicha();
	  $arrBean['piezaGenericaId']=$bean->getPiezaGenericaId();
	  $arrBean['piezaGenericaNombre']=$bean->getPiezaGenericaNombre();
	  $datos[]=$arrBean;
	}
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	echo $callback . "(" .  json_encode($resultado) . ");";
	
  }else if ($ultimo=='obtiene'){
	$id=$_REQUEST['id'];
	$svc = new PiezasSvcImpl();
	$bean=$svc->obtiene($id);
    $arrBean=array();
	$arrBean['piezaId']=$bean->getId();
	$arrBean['piezaNombre']=$bean->getNombre();
	$arrBean['piezaFicha']=$bean->getFicha();
    $arrBean['piezaGenericaId']=$bean->getPiezaGenericaId();
	$arrBean['piezaGenericaNombre']=$bean->getPiezaGenericaNombre();
	$arrBean['atributos']=$bean->getAtributos();
    $resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$arrBean;
	echo json_encode($resultado) ;	
	
  }else if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$nombreOParte=$_REQUEST['nombreOParte'];
		$piezaFicha=$_REQUEST['piezaFicha'];
		$piezaGenericaId=$_REQUEST['piezaGenericaId'];
		$valoresAtributo=$_REQUEST['valoresAtributo'];
		
		$svc = new PiezasSvcImpl();
		$beans=$svc->selTodos($desde, $cuantos, $nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo);
		$cuenta=$svc->selTodosCuenta($nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['piezaId']=$bean->getId();
		  $arrBean['piezaNombre']=$bean->getNombre();
		  $arrBean['piezaFicha']=$bean->getFicha();
		  $arrBean['piezaGenericaId']=$bean->getPiezaGenericaId();
		  $arrBean['piezaGenericaNombre']=$bean->getPiezaGenericaNombre();
		  $arrBean['tipoPataId']=$bean->getTipoPataId();
		  $arrBean['tipoPataNombre']=$bean->getTipoPataNombre();
		  $atris=$bean->getAtributos();
		  $cadena='';
		  foreach ($atris as $objVap){
		  	$cadena.="|";
		  	$cadena.=$objVap->getAtributoId();
		  	$cadena.="~" . $objVap->getAtributoNombre();
		  	$cadena.="~" . $objVap->getId();
		  	$cadena.="~" . $objVap->getValor();
		  }
		  if (strlen($cadena)>0){
		    $arrBean['atributos']=substr($cadena, 1);	
		  }else{
		  	$arrBean['atributos']=null;
		  }
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;	
  
  } else if ($ultimo=='inserta'){
    $bean=new Pieza(); 
	$bean->setNombre($_REQUEST['piezaNombre']);
	$bean->setFicha($_REQUEST['piezaFicha']);
	$bean->setPiezaGenericaId($_REQUEST['piezaGenericaId']);
	$bean->setTipoPataId($_REQUEST['tipoPataId']);
	$bean->setAtributos($_REQUEST['atributos']);
	$exito=$svc->inserta($bean);
	echo json_encode($exito) ;
  
  } else if ($ultimo=='actualiza'){
    $bean=new Pieza();
	$bean->setId($_REQUEST['piezaId']);
	$bean->setNombre($_REQUEST['piezaNombre']);
	$bean->setFicha($_REQUEST['piezaFicha']);
	$bean->setPiezaGenericaId($_REQUEST['piezaGenericaId']);
	$bean->setTipoPataId($_REQUEST['tipoPataId']);
	$bean->setAtributos($_REQUEST['atributos']);
	$exito=$svc->actualiza($bean);
	echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	
  
  }
  

?>