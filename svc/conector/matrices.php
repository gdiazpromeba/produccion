<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Matriz.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/MatricesSvcImpl.php';
//  require_once('FirePHPCore/fb.php');

//header("Content-Type: multipart/mixed; charset=utf-8");


  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  
  $svc = new MatricesSvcImpl();

  if ($ultimo=='selPorComienzo'){
	//parametros de paginación
	$desde=$_REQUEST['start'];
	$cuantos=$_REQUEST['limit'];
	$cadena=$_REQUEST['query'];
	$callback=$_REQUEST['callback'];
	
	$beans=$svc->selPorComienzo($cadena, $desde, $cuantos);
	$cuenta=$svc->selPorComienzoCuenta($cadena);
	
	$datos=array();
	foreach ($beans as $bean){
	  $arrBean=array();
	  $arrBean['id']=$bean->getId();
	  $arrBean['nombre']=$bean->getNombre();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
	echo $callback . "(" .  json_encode($resultado) . ");";

  }else if ($ultimo=='selecciona'){
  	    header("Content-Type: text/plain; charset=utf-8");
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$nombreOParte=$_REQUEST['nombreOParte'];
		$depositoId=$_REQUEST['depositoId'];
		
		$beans=$svc->selTodos($desde, $cuantos, $nombreOParte, $depositoId);
		$cuenta=$svc->selTodosCuenta($nombreOParte, $depositoId);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['matrizId']=$bean->getId();
		  $arrBean['matrizNombre']=$bean->getNombre();
		  $arrBean['matrizTipo']=$bean->getTipo();
		  $arrBean['depositoId']=$bean->getDepositoId();
		  $arrBean['depositoNombre']=$bean->getDepositoNombre();
		  $arrBean['anchoBase']=$bean->getAnchoBase();
		  $arrBean['largoBase']=$bean->getLargoBase();
		  $arrBean['alturaConjunto']=$bean->getAlturaConjunto();
		  $arrBean['matrizForma']=$bean->getForma();
		  $arrBean['matrizCondicion']=$bean->getCondicion();
		  $arrBean['matrizFoto']=$bean->getFoto();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;
   
   } else if ($ultimo=='subeFoto'){
   	    header("Content-Type: text/html; charset=utf-8");
        $uploads_dir = '../../recursos/imagenes';
        if (!is_uploaded_file($_FILES['matrizFotoFU']['tmp_name'])) {
          $exito=array();
          $exito['success']=false;
          $exito['errors']="No se ha podido leer o subir el archivo";
          echo json_encode($exito);
          return;
        }        
        $nombreOrig=$_FILES["matrizFotoFU"]["tmp_name"];
        $nombre=$_FILES["matrizFotoFU"]["name"];
        $movimiento=move_uploaded_file($nombreOrig, "$uploads_dir/$nombre");
        if (!$movimiento){
          $exito=array();
          $exito['success']=false;
          $exito['errors']="No se ha podido mover el archivo a su destino final";
          echo json_encode($exito);
        }else{
          $exito=array();
          $exito['success']=true;
          $exito['archivo']=$nombre;
        }
        echo json_encode($exito);

   } else if ($ultimo=='inserta'){
	   	$bean=new Matriz(); 
		$bean->setNombre($_REQUEST['matrizNombre']);
		$bean->setTipo($_REQUEST['matrizTipo']);
		$bean->setDepositoId($_REQUEST['depositoIdMat']);
		$bean->setAnchoBase($_REQUEST['anchoBase']);
		$bean->setLargoBase($_REQUEST['largoBase']);
		$bean->setAlturaConjunto($_REQUEST['alturaConjunto']);
		$bean->setForma($_REQUEST['matrizForma']);
		$bean->setCondicion($_REQUEST['matrizCondicion']);
		$bean->setFoto($_REQUEST['matrizFoto']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
 
  } else if ($ultimo=='actualiza'){
	   	$bean=new Matriz(); 
	   	$bean->setId($_REQUEST['matrizId']);
		$bean->setNombre($_REQUEST['matrizNombre']);
		$bean->setTipo($_REQUEST['matrizTipo']);
		$bean->setDepositoId($_REQUEST['depositoIdMat']);
		$bean->setAnchoBase($_REQUEST['anchoBase']);
		$bean->setLargoBase($_REQUEST['largoBase']);
		$bean->setAlturaConjunto($_REQUEST['alturaConjunto']);
		$bean->setForma($_REQUEST['matrizForma']);
		$bean->setCondicion($_REQUEST['matrizCondicion']);
		$bean->setFoto($_REQUEST['matrizFoto']);
		$exito=$svc->actualiza($bean);
		echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
  	header("Content-Type: text/plain; charset=utf-8");
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	

  } else if ($ultimo=='inhabilita'){
  	header("Content-Type: text/plain; charset=utf-8");
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  }

?>