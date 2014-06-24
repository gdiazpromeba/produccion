<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ComunicacionesPreciosCabeceraOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ComunicacionPrecios.php';  
//require_once('FirePHPCore/fb.php');

   class ComunicacionesPreciosCabeceraOadImpl extends AOD implements ComunicacionesPreciosCabeceraOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CPC.COM_PREC_CAB_ID,     \n"; 
         $sql.="  CPC.CLIENTE_ID,     \n"; 
         $sql.="  CLI.CLIENTE_NOMBRE,     \n"; 
         $sql.="  CPC.DESTINATARIO,     \n";
         $sql.="  CPC.COM_PREC_FECHA,     \n"; 
         $sql.="  CPC.AUTORIZADO_POR,     \n"; 
         $sql.="  USU.USUARIO_NOMBRE_COMPLETO,     \n"; 
         $sql.="  CPC.METODO_ENVIO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  COMUNICACIONES_PRECIOS_CABECERA CPC \n"; 
         $sql.="  INNER JOIN CLIENTES CLI ON CPC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="  INNER JOIN USUARIOS USU ON USU.USUARIO_ID=CPC.AUTORIZADO_POR  \n";
         $sql.="WHERE  \n"; 
         $sql.="  CPC.COM_PREC_CAB_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new ComunicacionPrecios();  
         $id=null;  
         $clienteId=null;  
         $clienteNombre=null;  
         $destinatario=null;
         $fecha=null;  
         $autorizadorId=null;  
         $autorizadorNombre=null;  
         $metodoEnvio=null;  
         $stm->bind_result($id, $clienteId, $clienteNombre, $destinatario, $fecha, $autorizadorId, $autorizadorNombre, $metodoEnvio); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setDestinatario($destinatario);
            $bean->setFechaLarga($fecha);
            $bean->setAutorizadorId($autorizadorId);
            $bean->setAutorizadorNombre($autorizadorNombre);
            $bean->setMetodoEnvio($metodoEnvio);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO COMUNICACIONES_PRECIOS_CABECERA (   \n"; 
         $sql.="  COM_PREC_CAB_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DESTINATARIO,     \n";
         $sql.="  COM_PREC_FECHA,     \n"; 
         $sql.="  AUTORIZADO_POR,     \n"; 
         $sql.="  METODO_ENVIO)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssss",$bean->getId(), $bean->getClienteId(), $bean->getDestinatario(), $bean->getFechaLarga(), $bean->getAutorizadorId(), $bean->getMetodoEnvio()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM COMUNICACIONES_PRECIOS_CABECERA   \n"; 
         $sql.="WHERE COM_PREC_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE COMUNICACIONES_PRECIOS_CABECERA SET   \n"; 
         $sql.="  CLIENTE_ID=?,     \n"; 
         $sql.="  DESTINATARIO=?,     \n";
         $sql.="  COM_PREC_FECHA=?,     \n"; 
         $sql.="  AUTORIZADO_POR=?,     \n"; 
         $sql.="  METODO_ENVIO=?     \n"; 
         $sql.="WHERE COM_PREC_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssssss", $bean->getClienteId(), $bean->getDestinatario(), $bean->getFechaLarga(), $bean->getAutorizadorId(), $bean->getMetodoEnvio(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CPC.COM_PREC_CAB_ID,     \n"; 
         $sql.="  CPC.CLIENTE_ID,     \n"; 
         $sql.="  CLI.CLIENTE_NOMBRE,     \n"; 
         $sql.="  CPC.DESTINATARIO,     \n";
         $sql.="  CPC.COM_PREC_FECHA,     \n"; 
         $sql.="  CPC.AUTORIZADO_POR,     \n"; 
         $sql.="  USU.USUARIO_NOMBRE_COMPLETO,     \n"; 
         $sql.="  CPC.METODO_ENVIO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  COMUNICACIONES_PRECIOS_CABECERA CPC \n"; 
         $sql.="  INNER JOIN CLIENTES CLI ON CPC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="  INNER JOIN USUARIOS USU ON USU.USUARIO_ID=CPC.AUTORIZADO_POR  \n";
         $sql.="WHERE  1=1  \n";
         if (!empty($clienteId)){
           $sql.="AND CPC.CLIENTE_ID='".  $clienteId . "'  \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND CPC.COM_PREC_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND CPC.COM_PREC_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }  
         if (!empty($sort)){
           $sql.="ORDER BY \n";
         }
         if ($sort=="clienteNombre"){
           $sql.="  CLI.CLIENTE_NOMBRE " . $dir . "\n";
         }
         if ($sort=="fecha"){
           $sql.="  CPC.COM_PREC_FECHA " . $dir . "\n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $clienteId=null;  
         $clienteNombre=null;  
         $destinatario=null;
         $fecha=null;  
         $autorizadorId=null;  
         $autorizadorNombre=null;  
         $metodoEnvio=null;  
         $stm->bind_result($id, $clienteId, $clienteNombre, $destinatario, $fecha, $autorizadorId, $autorizadorNombre, $metodoEnvio); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new ComunicacionPrecios();  
            $bean->setId($id);
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setDestinatario($destinatario);
            $bean->setFechaLarga($fecha);
            $bean->setAutorizadorId($autorizadorId);
            $bean->setAutorizadorNombre($autorizadorNombre);
            $bean->setMetodoEnvio($metodoEnvio);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 




      public function selTodosCuenta($clienteId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM COMUNICACIONES_PRECIOS_CABECERA CPC \n";
         $sql.="WHERE 1=1  \n";  
         if (!empty($clienteId)){
           $sql.="AND CPC.CLIENTE_ID='".  $clienteId . "'  \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND CPC.COM_PREC_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND CPC.COM_PREC_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }  
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      

   } 
?>