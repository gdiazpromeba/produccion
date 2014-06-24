<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/RemitosCabeceraOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Remito.php';  

   class RemitosCabeceraOadImpl extends AOD implements RemitosCabeceraOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  REC.REMITO_CABECERA_ID,     \n"; 
         $sql.="  REC.CLIENTE_ID,     \n"; 
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  REC.REMITO_NUMERO,     \n"; 
         $sql.="  REC.REMITO_FECHA,     \n"; 
         $sql.="  REC.REMITO_ESTADO,    \n";
         $sql.="  REC.OBSERVACIONES    \n";
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_CABECERA REC \n";
         $sql.="  INNER JOIN CLIENTES CLI ON REC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  REC.REMITO_CABECERA_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Remito();  
         $id=null;  
         $clienteId=null;  
         $clienteNombre=null;  
         $numero=null;  
         $fecha=null;  
         $estado=null;  
         $observaciones=null;
         $stm->bind_result($id, $clienteId, $clienteNombre, $numero, $fecha, $estado, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setNumero($numero);
            $bean->setFechaLarga($fecha);
            $bean->setEstado($estado);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO REMITOS_CABECERA (   \n"; 
         $sql.="  REMITO_CABECERA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  REMITO_NUMERO,     \n"; 
         $sql.="  REMITO_FECHA,     \n"; 
         $sql.="  REMITO_ESTADO,    \n";
         $sql.="  OBSERVACIONES)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssisss",$bean->getId(), $bean->getClienteId(), $bean->getNumero(), $bean->getFechaLarga(), $bean->getEstado(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM REMITOS_CABECERA   \n"; 
         $sql.="WHERE REMITO_CABECERA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE REMITOS_CABECERA SET   \n"; 
         $sql.="  CLIENTE_ID=?,     \n"; 
         $sql.="  REMITO_NUMERO=?,     \n"; 
         $sql.="  REMITO_FECHA=?,     \n"; 
         $sql.="  REMITO_ESTADO=?,      \n";
         $sql.="  OBSERVACIONES=?      \n";
         $sql.="WHERE REMITO_CABECERA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sissss", $bean->getClienteId(), $bean->getNumero(), $bean->getFechaLarga(), $bean->getEstado(), $bean->getObservaciones(),  $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta, $numero){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  REC.REMITO_CABECERA_ID,     \n"; 
         $sql.="  REC.CLIENTE_ID,     \n"; 
         $sql.="  CLI.CLIENTE_NOMBRE,     \n"; 
         $sql.="  REC.REMITO_NUMERO,     \n"; 
         $sql.="  REC.REMITO_FECHA,     \n"; 
         $sql.="  REC.REMITO_ESTADO,    \n";
         $sql.="  REC.OBSERVACIONES    \n";
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_CABECERA REC \n"; 
         $sql.="  INNER JOIN CLIENTES CLI ON REC.CLIENTE_ID=CLI.CLIENTE_ID   \n";
         $sql.="WHERE 1=1 \n";
         if ($clienteId!=null){
         	$sql.="  AND REC.CLIENTE_ID='" .  $clienteId .   "' \n";
         }
         if (!empty($estado)){
         	$sql.="  AND REC.REMITO_ESTADO='" .  $estado .   "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND REC.REMITO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND REC.REMITO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }
         if (!empty($numero)){
         	$sql.="  AND REC.REMITO_NUMERO =" .  $numero .   " \n";
         }
         if (!empty($sort)){
           $sql.="ORDER BY  \n";  
         }
         if ($sort=="remitoFecha"){
		   $sql.="  REC.REMITO_FECHA " . $dir . "  \n";
         }
         if ($sort=="remitoNumero"){
		   $sql.="  REC.REMITO_NUMERO " . $dir . "  \n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $clienteId=null;  
         $clienteNombre=null;  
         $numero=null;  
         $fecha=null;  
         $estado=null;  
         $observaciones=null;
         $stm->bind_result($id, $clienteId, $clienteNombre, $numero, $fecha, $estado, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Remito();  
            $bean->setId($id);
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setNumero($numero);
            $bean->setFechaLarga($fecha);
            $bean->setEstado($estado);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
		

      public function selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta, $numero){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM REMITOS_CABECERA REC  \n"; 
         $sql.="WHERE 1=1  \n";
         if (!empty($clienteId)){
         	$sql.="  AND REC.CLIENTE_ID='" .  $clienteId .   "' \n";
         }
         if (!empty($estado)){
         	$sql.="  AND REC.REMITO_ESTADO='" .  $estado .   "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND REC.REMITO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND REC.REMITO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }         
         if (!empty($numero)){
         	$sql.="  AND REC.REMITO_NUMERO =" .  $numero .   " \n";
         }
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 

   
      public function selReporteRemito($remitoCabeceraId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  CLI.DIRECCION,     \n";
         $sql.="  CLI.LOCALIDAD,     \n";
         $sql.="  CLI.TELEFONO,     \n";
         $sql.="  CLI.CONDICION_IVA,     \n";
         $sql.="  CLI.CUIT,     \n";
         $sql.="  REC.REMITO_FECHA,     \n";
         $sql.="  REC.REMITO_NUMERO,     \n";
         $sql.="  RED.REMITO_ITEM_CANTIDAD,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  REC.OBSERVACIONES     \n";
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_DETALLE  RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID=RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=REC.CLIENTE_ID  \n";
         $sql.="WHERE     \n";
         $sql.="  REC.REMITO_CABECERA_ID='" . $remitoCabeceraId . "'    \n";
         $sql.="ORDER BY     \n";
         $sql.="  PIE.PIEZA_NOMBRE     \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteNombre=null;
         $direccion=null;
         $localidad=null;
         $telefono=null;
         $condicionIva=null;
         $cuit=null;
         $remitoFecha=null;
         $numero=null;
         $cantidad=null;
         $piezaNombre=null;
         $observaciones=null;
         $stm->bind_result($clienteNombre, $direccion, $localidad, $telefono, $condicionIva, $cuit, $remitoFecha, $numero,  $cantidad, $piezaNombre, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['clienteNombre']=$clienteNombre;
         	$fila['remitoFecha']= FechaUtils::cadenaLargaADMA($remitoFecha);
         	$fila['numero']=$numero;
         	$fila['cantidad']=$cantidad;
         	$fila['piezaNombre']=$piezaNombre;
         	$fila['direccion']=$direccion;
         	$fila['localidad']=$localidad;
         	$fila['telefono']=$telefono;
         	$fila['condicionIva']=$condicionIva;
         	$fila['cuit']=$cuit;
            $fila['observaciones']=$observaciones;         	
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      
   }
    
?>