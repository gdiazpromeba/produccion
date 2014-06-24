<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PreciosPorMaterialOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PrecioPorMaterial.php';  
//require_once('FirePHPCore/fb.php');

   class PreciosPorMaterialOadImpl extends AOD implements PreciosPorMaterialOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPM.PPM_ID,     \n"; 
         $sql.="  PPM.MATERIAL_ID,     \n"; 
         $sql.="  PPM.PRECIO,     \n"; 
         $sql.="  PPM.FECHA,    \n";
         $sql.="  PPM.PROVEEDOR_ID,    \n";
         $sql.="  PRO.NOMBRE,    \n";
         $sql.="  PPM.OBSERVACIONES    \n";
         $sql.="FROM  \n"; 
         $sql.="  PRECIOS_POR_MATERIAL  PPM \n";
         $sql.="  INNER JOIN PROVEEDORES PRO ON PRO.PROVEEDOR_ID=PPM.PROVEEDOR_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPM.PPM_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PrecioPorMaterial();  
         $id=null;  
         $materialId=null;  
         $precio=null;  
         $fecha=null;  
         $stm->bind_result($id, $materialId, $precio, $fecha, $proveedorId, $proveedorNombre, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setMaterialId($materialId);
            $bean->setPrecio($precio);
            $bean->setFechaLarga($fecha);
            $bean->setProveedorId($proveedorId);
            $bean->setProveedorNombre($proveedorNombre);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PRECIOS_POR_MATERIAL (   \n"; 
         $sql.="  PPM_ID,     \n"; 
         $sql.="  MATERIAL_ID,     \n"; 
         $sql.="  PRECIO,     \n"; 
         $sql.="  FECHA,    \n";
         $sql.="  PROVEEDOR_ID,    \n";
         $sql.="  OBSERVACIONES)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssdsss",$bean->getId(), $bean->getMaterialId(), $bean->getPrecio(), $bean->getFechaLarga(), $bean->getProveedorId(), $bean->getObservaciones());
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PRECIOS_POR_MATERIAL   \n"; 
         $sql.="WHERE PPM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PRECIOS_POR_MATERIAL SET   \n"; 
         $sql.="  MATERIAL_ID=?,     \n"; 
         $sql.="  PRECIO=?,     \n"; 
         $sql.="  FECHA=?,     \n";
         $sql.="  PROVEEDOR_ID=?,     \n";
         $sql.="  OBSERVACIONES=?     \n";
         $sql.="WHERE PPM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sdssss", $bean->getMaterialId(), $bean->getPrecio(), $bean->getFechaLarga(), $bean->getProveedorId(), $bean->getObservaciones(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $materialId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPM.PPM_ID,     \n"; 
         $sql.="  PPM.MATERIAL_ID,     \n"; 
         $sql.="  PPM.PRECIO,     \n"; 
         $sql.="  PPM.FECHA,    \n";
         $sql.="  PPM.PROVEEDOR_ID,    \n";
         $sql.="  PRO.NOMBRE,    \n";
         $sql.="  PPM.OBSERVACIONES    \n";
         $sql.="FROM  \n"; 
         $sql.="  PRECIOS_POR_MATERIAL  PPM \n";
         $sql.="  INNER JOIN PROVEEDORES PRO ON PRO.PROVEEDOR_ID=PPM.PROVEEDOR_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPM.MATERIAL_ID='" . $materialId . "'\n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PPM.FECHA DESC  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $stm->bind_result($id, $materialId, $precio, $fecha, $proveedorId, $proveedorNombre, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PrecioPorMaterial();  
            $bean->setId($id);
            $bean->setMaterialId($materialId);
            $bean->setPrecio($precio);
            $bean->setFechaLarga($fecha);
            $bean->setProveedorId($proveedorId);
            $bean->setProveedorNombre($proveedorNombre);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selVistaPreciosPorMaterial($materialIds){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MATERIAL_ID,     \n";
         $sql.="  MATERIAL_NOMBRE,     \n";
         $sql.="  MATERIAL_UNIDAD_ID,     \n";
         $sql.="  UNIDAD_TEXTO,     \n";
         $sql.="  PRECIO     \n";
         $sql.="FROM  \n"; 
         $sql.="  VW_PRECIOS_POR_MATERIAL VPM \n";
         $sql.="WHERE  \n"; 
         $sql.="  MATERIAL_ID IN (";
		 for ($i=0; $i<count($materialIds); $i++){
		 	$sql.="'" . $materialIds[$i] . "'";
		 	if ($i<count($materialIds)-1){
		 		$sql.=",";
		 	} 
		 }
         $sql.=") \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $stm->bind_result($materialId, $materialNombre,  $unidadId, $unidadTexto,  $precio); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['materialNombre']=$materialNombre;
         	$fila['unidadId']=$unidadId;
         	$fila['unidadTexto']=$unidadTexto;
         	$fila['precio']=$precio;
            $filas[$materialId]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       


      public function selTodosCuenta($materialId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  COUNT(*) \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PRECIOS_POR_MATERIAL  PPM \n";
         $sql.="  INNER JOIN PROVEEDORES PRO ON PRO.PROVEEDOR_ID=PPM.PROVEEDOR_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPM.MATERIAL_ID='" . $materialId . "'\n"; 
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