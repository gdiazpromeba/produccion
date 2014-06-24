<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php'; 
//  require_once('FirePHPCore/fb.php');
  
  
  
   function preparar($conexion, $sql){
      if (!$statement = $conexion->prepare($sql)){     
        echo $conexion->error;
        exit();
      }
      return $statement;
    }
  
  //obtengo una lista de los detalles
  $conexion=new mysqli("localhost", 'almarlam_gonzalo' , 'manuela' , 'almarlam_prod');
  $conexion->set_charset("utf8");
      
  //$db_connection->query("SET NAMES 'utf8'");
  if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
  }

  
  $sql="SELECT  \n";
  $sql.="  CPD.COM_PREC_DET_ID,     \n";
  $sql.="  CPC.COM_PREC_FECHA,     \n";
  $sql.="  CPD.PIEZA_ID,     \n";
  $sql.="  CPD.PRECIO     \n";
  $sql.="FROM  \n"; 
  $sql.="  COMUNICACIONES_PRECIOS_CABECERA CPC  \n";
  $sql.="  INNER JOIN COMUNICACIONES_PRECIOS_DETALLE CPD ON CPC.COM_PREC_CAB_ID=CPD.COM_PREC_CAB_ID   \n";
  $stm = preparar($conexion, $sql);  
  $stm->execute();  
  $id=null;
  $piezaId=null;
  $fecha=null;
  $precio=null;
  $stm->bind_result($id, $fecha, $piezaId, $precio); 
  $filas = array(); 
  while ($stm->fetch()) {
  	$fila=array();
  	$fila['id'] =$id;
  	$fila['piezaId'] =$piezaId;
  	$fila['fecha'] =$fecha;
  	$fila['precio'] =$precio;
  	$fila['usaGeneral'] =false;
    $filas[]=$fila; 
  }
  $stm->close();
  
  //pueblo usaGeneral según corresponda
  foreach($filas as &$fila){
  	$sqlExi="SELECT count(*) FROM LISTA_PRECIOS WHERE EFECTIVO_DESDE='" . $fila['fecha'] . "' AND PIEZA_ID='" .  $fila['piezaId'] .  "' AND PRECIO=" . $fila['precio'];
    $stmExi = preparar($conexion, $sqlExi);
    $cuenta=null;
    $stmExi->bind_result($cuenta);
    $stmExi->execute();  
    $cuenta=null;
    if ($stmExi->fetch()){
    	if ($cuenta>0){
    	  $fila['usaGeneral']=true;
    	}
    }
    $stmExi->close();
  }
  
  //actualizo la BD
  foreach($filas as $fila){
    if ($fila['usaGeneral']){
          $sqlUpd="UPDATE COMUNICACIONES_PRECIOS_DETALLE SET USA_GENERAL=1 WHERE COM_PREC_DET_ID='" . $fila['id'] .  "'  \n";
          $stmUpd = preparar($conexion, $sqlUpd);
          $stmUpd->execute();
          $stmUpd->close();
    	  echo 'para la fecha ' . $fila['fecha'] .  ' y el precio ' . $fila['precio'] . ' hay general' . '<br/>';  
    }
  }
  
  $conexion->close();
 
?>
