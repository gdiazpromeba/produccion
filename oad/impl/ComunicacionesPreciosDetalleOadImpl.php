<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ComunicacionesPreciosDetalleOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ComunicacionPreciosDetalle.php'; 
//require_once('FirePHPCore/fb.php');

   class ComunicacionesPreciosDetalleOadImpl extends AOD implements ComunicacionesPreciosDetalleOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CPD.COM_PREC_DET_ID,     \n"; 
         $sql.="  CPD.COM_PREC_CAB_ID,     \n"; 
         $sql.="  CPD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  CPD.PRECIO,    \n";
         $sql.="  CPD.USA_GENERAL    \n";
         $sql.="FROM  \n"; 
         $sql.="  COMUNICACIONES_PRECIOS_DETALLE CPD \n";
         $sql.="  INNER JOIN PIEZAS PIE ON CPD.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  CPD.COM_PREC_DET_ID='" . $id .  "'  \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new ComunicacionPreciosDetalle();  
         $id=null;  
         $comPrecCabId=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $precio=null;
         $usaGeneral=null;    
         $stm->bind_result($id, $comPrecCabId, $piezaId, $piezaNombre, $precio, $usaGeneral); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setComPrecCabId($comPrecCabId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPrecio($precio);
            $bean->setUsaGeneral($usaGeneral);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO COMUNICACIONES_PRECIOS_DETALLE (   \n"; 
         $sql.="  COM_PREC_DET_ID,     \n"; 
         $sql.="  COM_PREC_CAB_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  PRECIO,    \n";
         $sql.="  USA_GENERAL)    \n";  
         $sql.="VALUES (?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssdi",$bean->getId(), $bean->getComPrecCabId(), $bean->getPiezaId(), $bean->getPrecio(), $bean->isUsaGeneral()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM COMUNICACIONES_PRECIOS_DETALLE   \n"; 
         $sql.="WHERE COM_PREC_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE COMUNICACIONES_PRECIOS_DETALLE SET   \n"; 
         $sql.="  COM_PREC_CAB_ID=?,     \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  PRECIO=?,     \n";
         $sql.="  USA_GENERAL=?     \n";
         $sql.="WHERE COM_PREC_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssdis", $bean->getComPrecCabId(), $bean->getPiezaId(), $bean->getPrecio(), $bean->isUsaGeneral(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $comPrecCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CPD.COM_PREC_DET_ID,     \n"; 
         $sql.="  CPD.COM_PREC_CAB_ID,     \n"; 
         $sql.="  CPD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  CPD.PRECIO,    \n";
         $sql.="  CPD.USA_GENERAL    \n";
         $sql.="FROM  \n"; 
         $sql.="  COMUNICACIONES_PRECIOS_DETALLE CPD \n";
         $sql.="  INNER JOIN PIEZAS PIE ON CPD.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  CPD.COM_PREC_CAB_ID='" . $comPrecCabId .  "'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PIE.PIEZA_FICHA,  \n";
         $sql.="  PIE.PIEZA_NOMBRE  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $comPrecCabId=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $precio=null;  
         $usaGeneral=null;
         $stm->bind_result($id, $comPrecCabId, $piezaId, $piezaNombre, $precio, $usaGeneral); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new ComunicacionPreciosDetalle();  
            $bean->setId($id);
            $bean->setComPrecCabId($comPrecCabId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPrecio($precio);
            $bean->setUsaGeneral($usaGeneral);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($comPrecCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM COMUNICACIONES_PRECIOS_DETALLE CPD \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  CPD.COM_PREC_CAB_ID='" . $comPrecCabId .  "'  \n";          
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
     public function selReporteComunicacion($comPrecCabId){ 
     	$conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  CPC.DESTINATARIO,     \n";
         $sql.="  CPC.COM_PREC_FECHA,     \n";
         $sql.="  USU.USUARIO_NOMBRE_COMPLETO AS AUTORIZADOR,     \n";
         $sql.="  PIE.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  CPD.PRECIO,    \n";
         $sql.="  CPD.USA_GENERAL    \n";
         $sql.="FROM  \n"; 
         $sql.="  COMUNICACIONES_PRECIOS_CABECERA CPC  \n";
         $sql.="  INNER JOIN COMUNICACIONES_PRECIOS_DETALLE CPD ON CPC.COM_PREC_CAB_ID=CPD.COM_PREC_CAB_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON CPD.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CPC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="  LEFT JOIN USUARIOS USU ON CPC.AUTORIZADO_POR=USU.USUARIO_ID  \n";
         $sql.="WHERE     \n";
         $sql.="  CPC.COM_PREC_CAB_ID='" . $comPrecCabId . "'    \n";
         $sql.="ORDER BY     \n";
         $sql.="  PIE.PIEZA_FICHA     \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteNombre=null;
         $destinatario=null;
         $fecha=null;
         $autorizador=null;
         $piezaId=null;
         $piezaNombre=null;
         $precio=null;
         $usaGeneral=null;
         $stm->bind_result($clienteNombre, $destinatario, $fecha,  $autorizador, $piezaId, $piezaNombre, $precio, $usaGeneral); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['clienteNombre']=$clienteNombre;
         	$fila['destinatario']=$destinatario;
         	$fila['fecha']= FechaUtils::cadenaLargaADMA($fecha);
         	$fila['autorizador']=$autorizador;
         	$fila['piezaId']=$piezaId;
         	$fila['piezaNombre']=$piezaNombre;
         	$fila['precio']=$precio;
         	$fila['usaGeneral']=$usaGeneral;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selIdDetalle($clienteId, $piezaId){ 
        $conexion=$this->conectarse();
        $sql="SELECT \n";
        $sql.="  CPD.COM_PREC_DET_ID \n";  
        $sql.="from  \n";  
        $sql.="  COMUNICACIONES_PRECIOS_CABECERA CPC \n"; 
        $sql.="  join COMUNICACIONES_PRECIOS_DETALLE CPD on  CPC.COM_PREC_CAB_ID = CPD.COM_PREC_CAB_ID \n";    
        $sql.="where  \n";
        $sql.="    CPC.COM_PREC_FECHA =  \n"; 
        $sql.="     (select MAX(CPC2.COM_PREC_FECHA)   \n";  
        $sql.="    FROM COMUNICACIONES_PRECIOS_CABECERA CPC2 \n";
        $sql.="    WHERE   CPC2.CLIENTE_ID = CPC.CLIENTE_ID  and  CPC2.COM_PREC_FECHA <= curdate()) \n";       
        $sql.="  AND  CPD.USA_GENERAL = 0   \n";
        $sql.="  AND CPD.PIEZA_ID='" . $piezaId . "' \n";
        $sql.="  AND CPC.CLIENTE_ID='" . $clienteId .  "'   \n";   
        $stm=$this->preparar($conexion, $sql);  
        $stm->execute();  
        $comPrecDetId=null; 
        $stm->bind_result($comPrecDetId); 
        $stm->fetch();  
        $this->cierra($conexion, $stm); 
        return $comPrecDetId; 
      }                 
      

   } 
?>