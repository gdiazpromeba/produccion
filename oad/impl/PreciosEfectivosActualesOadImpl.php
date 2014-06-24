<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PreciosEfectivosActualesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PrecioEfectivoActual.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');



   class PreciosEfectivosActualesOadImpl extends AOD implements PreciosEfectivosActualesOad { 
   	 

      public function selEfectivosActuales($desde, $cuantos, $clienteId, $piezaId, $nombrePiezaOParte){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CLIENTE_ID,     \n";
         $sql.="  CLIENTE_NOMBRE,     \n";
         $sql.="  FECHA,     \n";
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  PIEZA_NOMBRE,     \n";
         $sql.="  PRECIO    \n"; 
         $sql.="FROM                  \n"; 
         $sql.="  VW_EFECTIVOS_ACTUALES   \n";
         $sql.="WHERE 1=1 \n";
         if (!empty($clienteId)){
           $sql.="  AND CLIENTE_ID='" . $clienteId . "'  \n";
         }
         if (!empty($piezaId)){
           $sql.="  AND PIEZA_ID='" . $piezaId . "'  \n";
         }
         if (!empty($nombrePiezaOParte)){
           $sql.="  AND PIEZA_NOMBRE LIKE '%" . $nombrePiezaOParte . "%'  \n";
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  PIEZA_NOMBRE,  \n";
         $sql.="  CLIENTE_NOMBRE  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteId=null;
         $clienteNombre=null;
         $fecha=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $precio=null;  
         $stm->bind_result($clienteId, $clienteNombre, $fecha, $piezaId, $piezaNombre, $precio); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PrecioEfectivoActual();
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setEfectivoDesdeLarga($fecha);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPrecio($precio);
            $filas[]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       


      public function selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*)  \n"; 
         $sql.="FROM VW_EFECTIVOS_ACTUALES     \n"; 
         $sql.="WHERE 1=1  \n";  
         if (!empty($clienteId)){
           $sql.="  AND CLIENTE_ID='" . $clienteId . "'  \n";
         }
         if (!empty($piezaId)){
           $sql.="  AND PIEZA_ID='" . $piezaId . "'  \n";
         }
         if (!empty($nombrePiezaOParte)){
           $sql.="  AND PIEZA_NOMBRE LIKE '%" . $nombrePiezaOParte . "%'  \n";
         }
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta;  
      }     
      
      public function obtienePrecioEspecifico($clienteId, $piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PRECIO     \n";
         $sql.="FROM      \n";
         $sql.="VW_EFECTIVOS_ACTUALES      \n";
         $sql.="WHERE                  \n"; 
         $sql.="  CLIENTE_ID='" . $clienteId  ."' \n";
         $sql.="  AND PIEZA_ID='" . $piezaId  ."' \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $precio=null;
         $stm->bind_result($precio);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $precio; 
      }
      
      public function obtienePrecioGeneral($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PRECIO     \n";
         $sql.="FROM      \n";
         $sql.="VW_EFECTIVOS_ACTUALES      \n";
         $sql.="WHERE                  \n"; 
         $sql.="  CLIENTE_ID IS NULL  \n";
         $sql.="  AND PIEZA_ID='" . $piezaId  ."' \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $precio=null;
         $stm->bind_result($precio);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $precio; 
      }                 
                       



   } 
?>