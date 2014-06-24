<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Ficha.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/FichasSvcImpl.php';
  header("Content-Type: text/plain; charset=utf-8");

  $url=$_SERVER['PHP_SELF'];
   
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);

  $svc = new FichasSvcImpl();


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
	  $arrBean['fichaId']=$bean->getId();
	  $arrBean['piezaFicha']=$bean->getFicha();
	  $datos[]=$arrBean;
	}
	
	$resultado=array();
	$resultado['total']=$cuenta;
	$resultado['data']=$datos;
	
	echo $callback . "(" .  json_encode($resultado) . ");";

  }else if ($ultimo=='selecciona'){
		//parametros de paginación
		$desde=$_REQUEST['start'];
		$cuantos=$_REQUEST['limit'];
		$numeroOParte=$_REQUEST['numeroOParte'];
		$parteContenido=$_REQUEST['parteContenido'];
		
		$beans=$svc->selTodos($desde, $cuantos, $numeroOParte, $parteContenido);
		$cuenta=$svc->selTodosCuenta($nombreOParte, $parteContenido);
		
		$datos=array();
		foreach ($beans as $bean){
		  $arrBean=array();
		  $arrBean['fichaId']=$bean->getId();
		  $arrBean['piezaFicha']=$bean->getFicha();
		  $arrBean['fichaContenido']=$bean->getContenido();
		  $datos[]=$arrBean;
		}  
		$resultado=array();
		$resultado['total']=$cuenta;
		$resultado['data']=$datos;
		echo json_encode($resultado) ;
		
   } else if ($ultimo=='subeFoto'){
   	    header("Content-Type: text/html; charset=utf-8");
        $uploads_dir = '../../recursos/imagenes/fichas';
        if (!is_uploaded_file($_FILES['fichaFotoFU']['tmp_name'])) {
          $exito=array();
          $exito['success']=false;
          $exito['errors']="No se ha podido leer o subir el archivo";
          echo json_encode($exito);
          return;
        }        
        $nombreOrig=$_FILES["fichaFotoFU"]["tmp_name"];
        $nombre=$_FILES["fichaFotoFU"]["name"];
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
	   	$bean=new Ficha(); 
		$bean->setFicha($_REQUEST['piezaFicha']);
		$bean->setContenido($_REQUEST['fichaContenido']);
		$exito=$svc->inserta($bean);
		echo json_encode($exito) ;
 
  } else if ($ultimo=='actualiza'){
		$bean=new Ficha();
		$bean->setId($_REQUEST['fichaId']);
		$bean->setFicha($_REQUEST['piezaFicha']);
		$bean->setContenido($_REQUEST['fichaContenido']);
		$exito=$svc->actualiza($bean);
		echo json_encode($exito) ;	
  
  } else if ($ultimo=='borra'){
	$exito=$svc->borra($_REQUEST['id']);
	echo json_encode($exito) ;	

  } else if ($ultimo=='inhabilita'){
	$exito=$svc->inhabilita($_REQUEST['id']);
	echo json_encode($exito) ;	
  }

?>