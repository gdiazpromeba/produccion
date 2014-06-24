<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PreciosGeneralesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ItemPrecioGeneral.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');



   class PreciosGeneralesOadImpl extends AOD implements PreciosGeneralesOad { 
   	 
      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LIP.ITEM_LISTA_PRECIOS_ID,     \n"; 
         $sql.="  LIP.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  LIP.PRECIO,    \n"; 
         $sql.="  LIP.ACTUALIZADO,    \n";
         $sql.="  LIP.EFECTIVO_DESDE    \n";
         $sql.="FROM  \n"; 
         $sql.="  LISTA_PRECIOS LIP \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON LIP.PIEZA_ID=LIP.PIEZA_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  LIP.ITEM_LISTA_PRECIOS_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new ItemPrecioGeneral();  
         $id=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $precio=null;  
         $actualizado=null;
         $efectivoDesde=null;
         $stm->bind_result($id, $piezaId, $piezaNombre, $precio, $actualizado, $efectivoDesde); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPrecio($precio);
            $bean->setActualizado($actualizado);
            $bean->setEfectivoDesde($efectivoDesde);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 
      
      /**
       * Devuelve un bean (o ninguno) con la más tardía información general efectiva sobre un precio
       */
      public function obtieneUltimoGeneral($piezaId, $fecha){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LIP.ITEM_LISTA_PRECIOS_ID,     \n"; 
         $sql.="  LIP.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  LIP.PRECIO,    \n"; 
         $sql.="  LIP.ACTUALIZADO,    \n";
         $sql.="  LIP.EFECTIVO_DESDE    \n";
         $sql.="FROM  \n"; 
         $sql.="  LISTA_PRECIOS LIP \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON LIP.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  LIP.PIEZA_ID='" .  $piezaId . "' \n";
         $sql.="  AND DATE('" .  $fecha  . "') >= LIP.EFECTIVO_DESDE   \n";
         $sql.="  AND LIP.EFECTIVO_DESDE=(SELECT MAX(LIP2.EFECTIVO_DESDE) FROM LISTA_PRECIOS LIP2  \n";
         $sql.="                          WHERE LIP2.PIEZA_ID='" .  $piezaId . "'  \n";
         $sql.="                          AND DATE('" .  $fecha  . "') >= LIP2.EFECTIVO_DESDE   \n";
         $sql.="                          ) \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $precio=null;  
         $actualizado=null;
         $efectivoDesde=null;
         $stm->bind_result($id, $piezaId, $piezaNombre, $precio, $actualizado, $efectivoDesde); 
		 $resultado=array();
         while ($stm->fetch()) {
         	$bean=new ItemPrecioGeneral(); 
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPrecio($precio);
            $bean->setActualizado($actualizado);
            $bean->setEfectivoDesde($efectivoDesde);
            $resultado[]=$bean;
         } 
         $this->cierra($conexion, $stm); 
         return $resultado; 
      }      
      
      public function obtienePrecioGeneral($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PRECIO     \n"; 
         $sql.="FROM  \n"; 
         $sql.="  VW_PRECIOS_GENERALES \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  PIEZA_ID='" .  $piezaId . "' \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $precio=null;  
         $stm->bind_result($precio); 
		 $resultado=null;
         if ($stm->fetch()) {
         	$resultado=$precio;
         }else{
           $resultado=null;
         }
         $this->cierra($conexion, $stm); 
         return $resultado; 
      }        
      
      
      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO LISTA_PRECIOS (   \n"; 
         $sql.="  ITEM_LISTA_PRECIOS_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  PRECIO,     \n"; 
         $sql.="  ACTUALIZADO,         \n";
         $sql.="  EFECTIVO_DESDE         \n";
         $sql.=") VALUES (?, ?, ?,  CURRENT_DATE, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssds",$bean->getId(), $bean->getPiezaId(), $bean->getPrecio(), $bean->getEfectivoDesdeLargo()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM LISTA_PRECIOS   \n"; 
         $sql.="WHERE ITEM_LISTA_PRECIOS_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE LISTA_PRECIOS SET   \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  PRECIO=?,      \n"; 
         $sql.="  ACTUALIZADO=CURRENT_DATE,      \n";
         $sql.="  EFECTIVO_DESDE=?      \n";
         $sql.="WHERE ITEM_LISTA_PRECIOS_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sdss", $bean->getPiezaId(), $bean->getPrecio(), $bean->getEfectivoDesdeLargo(), $bean->getId());
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $sort, $dir, $piezaId, $nombrePiezaOParte, $efectivoDesde){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LIP.ITEM_LISTA_PRECIOS_ID,     \n"; 
         $sql.="  LIP.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  LIP.PRECIO,    \n"; 
         $sql.="  LIP.ACTUALIZADO,    \n";
         $sql.="  LIP.EFECTIVO_DESDE    \n";
         $sql.="FROM  \n"; 
         $sql.="  LISTA_PRECIOS LIP \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON LIP.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE 1=1  \n";  
         if (!empty($piezaId)){
           $sql.="  AND LIP.PIEZA_ID='" . $piezaId . "'  \n";
         }
         if (!empty($nombrePiezaOParte)){
           $sql.="  AND PIE.PIEZA_NOMBRE LIKE '%" . $nombrePiezaOParte . "%'  \n";
         }
         if (!empty($efectivoDesde)){
           $sql.="  AND LIP.EFECTIVO_DESDE= '" . FechaUtils::dateTimeACadena($efectivoDesde) . "'  \n";
         }         
         if (!empty($sort)){
           $sql.="ORDER BY  \n";
         }
         if ($sort=="piezaNombre"){
           $sql.="  PIEZA_NOMBRE  " . $dir . "\n";
         }
         if ($sort=="efectivoDesde"){
           $sql.="  EFECTIVO_DESDE  " . $dir . "\n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $precio=null;  
         $actualizado=null;
         $efectivoDesde=null;
         $stm->bind_result($id, $piezaId, $piezaNombre, $precio, $actualizado, $efectivoDesde); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new ItemPrecioGeneral();  
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPrecio($precio);
            $bean->setActualizado($actualizado);
            $bean->setEfectivoDesde($efectivoDesde);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($piezaId, $nombrePiezaOParte, $efectivoDesde){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*)  "; 
         $sql.="FROM  \n"; 
         $sql.="  LISTA_PRECIOS LIP \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON LIP.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE 1=1  \n";
         if (!empty($piezaId)){
           $sql.="  AND LIP.PIEZA_ID='" . $piezaId . "'  \n";
         }
         if (!empty($nombrePiezaOParte)){
           $sql.="  AND PIE.PIEZA_NOMBRE LIKE '%" . $nombrePiezaOParte . "%'  \n";
         }
         if (!empty($efectivoDesde)){
           $sql.="  AND LIP.EFECTIVO_DESDE= '" . FechaUtils::dateTimeACadena($efectivoDesde) . "'  \n";
         }                  
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selSillones(){ 
         $conexion=$this->conectarse();
         $sql="SELECT                         \n"; 
         $sql.="  PIEZA_NOMBRE,                \n"; 
         $sql.="  PRECIO                       \n"; 
         $sql.="FROM VW_PRECIOS_GENERALES      \n"; 
         $sql.="WHERE                          \n"; 
         $sql.="  PIEZA_NOMBRE LIKE '5800%'    \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '5801%'    \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '5802%'    \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '8800%' \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '8801%' \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '8802%' \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '3805%' \n"; 
         $sql.="  OR PIEZA_NOMBRE LIKE '8807%' \n"; 
         $sql.="  OR PIEZA_NOMBRE LIKE '8809%' \n";            
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $piezaNombre=null;  
         $precio=null;  
         $stm->bind_result($piezaNombre, $precio); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['piezaNombre']=$piezaNombre;
         	$fila['precio']=$precio;
         	$filas[]=$fila;
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selSillas(){ 
         $conexion=$this->conectarse();
         $sql="SELECT                         \n"; 
         $sql.="  PIEZA_NOMBRE,                \n"; 
         $sql.="  PRECIO                       \n"; 
         $sql.="FROM VW_PRECIOS_GENERALES      \n"; 
         $sql.="WHERE                          \n"; 
         $sql.="  PIEZA_NOMBRE LIKE '3830%'    \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '3827%'    \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '3840%'    \n";
         $sql.="  OR PIEZA_NOMBRE LIKE '3860%' \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $piezaNombre=null;  
         $precio=null;  
         $stm->bind_result($piezaNombre, $precio); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['piezaNombre']=$piezaNombre;
         	$fila['precio']=$precio;
         	$filas[]=$fila;
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      
      
   } 
?>