<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PiezasOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pieza.php';  
//require_once('FirePHPCore/fb.php');

   class PiezasOadImpl extends AOD implements PiezasOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PIE.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  PIE.PIEZA_FICHA,     \n";
         $sql.="  PIE.TIPO_PATA_ID,     \n";
         $sql.="  TIP.TIPO_PATA_NOMBRE     \n";
         $sql.="FROM  \n"; 
         $sql.="  PIEZAS PIE  \n";
         $sql.="  LEFT JOIN TIPOS_PATA TIP ON PIE.TIPO_PATA_ID=TIP.TIPO_PATA_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  PIEZA_ID='" . $id . "' \n"; 
         $sql.="  AND HABILITADA=1 \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Pieza();  
         $id=null;  
         $piezaGenericaId=null;  
         $nombre=null;  
         $ficha=null;
         $tipoPataNombre=null;
         $tipoPataId=null;
         $ficha=null;
         $stm->bind_result($id, $piezaGenericaId, $nombre, $ficha, $tipoPataId, $tipoPataNombre); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPiezaGenericaId($piezaGenericaId);
            $bean->setNombre($nombre);
            $bean->setFicha($ficha);
            $bean->setTipoPataId($tipoPataId);
            $bean->setTipoPataNombre($tipoNombre);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PIEZAS (   \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIEZA_NOMBRE,     \n"; 
         $sql.="  PIEZA_FICHA,     \n";
         $sql.="  TIPO_PATA_ID,     \n";
         $sql.="  HABILITADA)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, 1)    \n"; 
         $nuevoId=$this->idUnico();
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssi",$bean->getId(), $bean->getPiezaGenericaId(), $bean->getNombre(), $bean->getFicha(), $bean->getTipoPataId());
         $exito=$this->ejecutaYCierra($conexion, $stm, $nuevoId);
         return $exito;
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PIEZAS   \n"; 
         $sql.="WHERE PIEZA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function inhabilita($id){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PIEZAS   \n"; 
         $sql.="SET HABILITADA=0   \n"; 
         $sql.="WHERE PIEZA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PIEZAS SET   \n"; 
         $sql.="  PIEZA_GENERICA_ID=?,     \n"; 
         $sql.="  PIEZA_NOMBRE=?,     \n"; 
         $sql.="  PIEZA_FICHA=?,     \n";
         $sql.="  TIPO_PATA_ID=?     \n";
         $sql.="WHERE PIEZA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssiss", $bean->getPiezaGenericaId(), $bean->getNombre(),  $bean->getFicha(), $bean->getTipoPataId(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PIE.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIG.PIEZA_GENERICA_NOMBRE,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  PIE.PIEZA_FICHA,     \n";
         $sql.="  PIE.TIPO_PATA_ID,     \n";
         $sql.="  TIP.TIPO_PATA_NOMBRE,     \n";
         $sql.="  PIE.HABILITADA    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PIEZAS PIE \n"; 
         $sql.="  INNER JOIN PIEZAS_GENERICAS PIG ON PIE.PIEZA_GENERICA_ID=PIG.PIEZA_GENERICA_ID  \n";
         $sql.="  LEFT JOIN TIPOS_PATA TIP ON PIE.TIPO_PATA_ID=TIP.TIPO_PATA_ID  \n";
         if ($valoresAtributo!=null){
           $sql.="  INNER JOIN ATRIBUTOS_VALOR_POR_PIEZA AVPP ON AVPP.PIEZA_ID=PIE.PIEZA_ID  \n";
         }
         
         $sql.="WHERE  \n"; 
         $sql.="  PIE.HABILITADA=1  \n"; 
         if ($nombreOParte!=null){
         	$sql.="  AND UPPER(PIE.PIEZA_NOMBRE) LIKE '%" . mb_strtoupper($nombreOParte, 'utf-8')   . "%'  \n"; 
         }
         if ($piezaFicha!=null){
         	$sql.="  AND PIE.PIEZA_FICHA=" . $piezaFicha  . "  \n"; 
         } 
         if ($piezaGenericaId!=null){
         	$sql.="  AND PIE.PIEZA_GENERICA_ID='" . $piezaGenericaId  . "'  \n"; 
         }
         if ($valoresAtributo!=null){
           $sql.="  AND AVPP.ATRIBUTO_VALOR_ID IN (" . $valoresAtributo .  ")  \n";
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  PIE.PIEZA_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaGenericaId=null;  
         $piezaGenericaNombre=null;
         $nombre=null;  
         $ficha=null;
         $tipoPataId=null;
         $tipoPataNombre=null;
         $habilitada=null;  
         $stm->bind_result($id, $piezaGenericaId, $piezaGenericaNombre, $nombre, $ficha, $tipoPataId, $tipoPataNombre, $habilitada); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Pieza();  
            $bean->setId($id);
            $bean->setPiezaGenericaId($piezaGenericaId);
            $bean->setPiezaGenericaNombre($piezaGenericaNombre);
            $bean->setNombre($nombre);
            $bean->setFicha($ficha);
            $bean->setTipoPataId($tipoPataId);
            $bean->setTipoPataNombre($tipoPataNombre);
            $bean->setHabilitada($habilitada);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      
      public function selPorComienzo($cadena, $desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PIE.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIG.PIEZA_GENERICA_NOMBRE,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  PIE.PIEZA_FICHA,     \n";
         $sql.="  PIE.TIPO_PATA_ID,     \n";
         $sql.="  TIP.TIPO_PATA_NOMBRE,     \n";
         $sql.="  PIE.HABILITADA    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PIEZAS PIE \n"; 
         $sql.="  INNER JOIN PIEZAS_GENERICAS PIG ON PIE.PIEZA_GENERICA_ID=PIG.PIEZA_GENERICA_ID  \n";
         $sql.="  LEFT JOIN TIPOS_PATA TIP ON PIE.TIPO_PATA_ID=TIP.TIPO_PATA_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  PIE.HABILITADA=1  \n"; 
         $sql.="  AND UPPER(PIE.PIEZA_NOMBRE) LIKE '" . mb_strtoupper($cadena, 'utf-8')   . "%'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PIE.PIEZA_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaGenericaId=null;  
         $piezaGenericaNombre=null;
         $nombre=null;  
         $ficha=null;
         $tipoPataId=null;
         $tipoPataNombre=null;
         $habilitada=null;  
         $stm->bind_result($id, $piezaGenericaId, $piezaGenericaNombre, $nombre, $ficha, $tipoPataId, $tipoPataNombre, $habilitada); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Pieza();  
            $bean->setId($id);
            $bean->setPiezaGenericaId($piezaGenericaId);
            $bean->setPiezaGenericaNombre($piezaGenericaNombre);
            $bean->setNombre($nombre);
            $bean->setFicha($ficha);
            $bean->setTipoPataId($tipoPataId);
            $bean->setTipoPataNombre($tipoPataNombre);
            $bean->setHabilitada($habilitada);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       


      public function selTodosCuenta($nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PIEZAS PIE   \n"; 
         $sql.="  LEFT JOIN TIPOS_PATA TIP ON PIE.TIPO_PATA_ID=TIP.TIPO_PATA_ID  \n";
         if ($valoresAtributo!=null){
         	$sql.=" INNER JOIN ATRIBUTOS_VALOR_POR_PIEZA AVPP ON PIE.PIEZA_ID=AVPP.PIEZA_ID  \n";
         }
         $sql.="WHERE PIE.HABILITADA=1   \n"; 
         if ($nombreOParte!=null){
         	$sql.="  AND UPPER(PIE.PIEZA_NOMBRE) LIKE '%" . mb_strtoupper($nombreOParte, 'utf-8')   . "%'  \n"; 
         }    
         if ($piezaFicha!=null){
         	$sql.="  AND PIE.PIEZA_FICHA=" . $piezaFicha  . "  \n"; 
         }
         if ($piezaGenericaId!=null){
         	$sql.="  AND PIE.PIEZA_GENERICA_ID='" . $piezaGenericaId  . "'  \n"; 
         }     
         if ($valoresAtributo!=null){
           $sql.="  AND AVPP.ATRIBUTO_VALOR_ID IN (" . $valoresAtributo .  ")  \n";
         }      
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
 
      
      public function selPorComienzoCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PIEZAS PIE "; 
         $sql.="  LEFT JOIN TIPOS_PATA TIP ON PIE.TIPO_PATA_ID=TIP.TIPO_PATA_ID  \n";
         $sql.="WHERE PIE.HABILITADA=1 "; 
         $sql.="  AND UPPER(PIEZA_NOMBRE) LIKE '" . mb_strtoupper($cadena, 'utf-8')   . "%'  \n"; 
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