<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ItemsCostoOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ItemCosto.php';  
//require_once('FirePHPCore/fb.php');

   class ItemsCostoOadImpl extends AOD implements ItemsCostoOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  COSTO_ITEM_ID,     \n"; 
         $sql.="  ORDEN,     \n"; 
         $sql.="  TEXTO_NODO,     \n"; 
         $sql.="  ITEM_PADRE,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  TIEMPO,     \n"; 
         $sql.="  DOTACION_SUGERIDA,     \n"; 
         $sql.="  CANTIDAD_MATERIAL,     \n"; 
         $sql.="  PORCENTAJE_AJUSTE,     \n"; 
         $sql.="  TIPO,    \n"; 
         $sql.="  REFERENTE_ID    \n";
         $sql.="FROM  \n"; 
         $sql.="  COSTOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  COSTO_ITEM_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new ItemCosto();  
         $id=null;  
         $orden=null;  
         $texto=null;  
         $padreId=null;  
         $piezaId=null;  
         $horasHombre=null;  
         $dotacionSugerida=null;  
         $cantidadMaterial=null;  
         $porcentajeAjuste=null;  
         $tipo=null;  
         $referenteId=null;
         $stm->bind_result($id, $orden, $texto, $padreId, $piezaId, $horasHombre, $dotacionSugerida, $cantidadMaterial, $porcentajeAjuste, $tipo, $referenteId); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setOrden($orden);
            $bean->setTexto($texto);
            $bean->setPadreId($padreId);
            $bean->setPiezaId($piezaId);
            $bean->setTiempo($horasHombre);
            $bean->setDotacionSugerida($dotacionSugerida);
            $bean->setCantidadMaterial($cantidadMaterial);
            $bean->setPorcentajeAjuste($porcentajeAjuste);
            $bean->setTipo($tipo);
            $bean->setReferenteId($referenteId);
         }
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO COSTOS (   \n"; 
         $sql.="  COSTO_ITEM_ID,     \n"; 
         $sql.="  ORDEN,     \n"; 
         $sql.="  TEXTO_NODO,     \n"; 
         $sql.="  ITEM_PADRE,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  TIEMPO,     \n"; 
         $sql.="  DOTACION_SUGERIDA,     \n"; 
         $sql.="  CANTIDAD_MATERIAL,     \n"; 
         $sql.="  PORCENTAJE_AJUSTE,     \n"; 
         $sql.="  TIPO,     \n"; 
         $sql.="  REFERENTE_ID     \n";
         $sql.=" ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sissssiddss",$bean->getId(), $bean->getOrden(), $bean->getTexto(), $bean->getPadreId(), $bean->getPiezaId(), $bean->getTiempo(), $bean->getDotacionSugerida(), $bean->getCantidadMaterial(), $bean->getPorcentajeAjuste(), $bean->getTipo(), $bean->getReferenteId()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM COSTOS   \n"; 
         $sql.="WHERE COSTO_ITEM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 

      
      public function actualizaEtapa($costoItemId, $etapaId, $etapaNombre){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE COSTOS SET   \n"; 
         $sql.="  REFERENTE_ID=?,     \n";
         $sql.="  TEXTO_NODO=?     \n"; 
         $sql.="WHERE COSTO_ITEM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sss", $etapaId, $etapaNombre, $costoItemId); 
         return $this->ejecutaYCierra($conexion, $stm); 
      }       
      
      
      public function actualizaProceso($costoItemId, $procesoId, $procesoNombre, $tiempo, $dotacionSugerida, $ajuste){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE COSTOS SET   \n"; 
         $sql.="  REFERENTE_ID=?,     \n";
         $sql.="  TEXTO_NODO=?,     \n"; 
         $sql.="  TIEMPO=?,     \n"; 
         $sql.="  DOTACION_SUGERIDA=?,     \n";
         $sql.="  PORCENTAJE_AJUSTE=?     \n";
         $sql.="WHERE COSTO_ITEM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssids", $procesoId, $procesoNombre, $tiempo, $dotacionSugerida, $ajuste, $costoItemId); 
         return $this->ejecutaYCierra($conexion, $stm); 
      }       
      
      public function modificaMaterial($costoItemId, $materialId, $materialNombre, $cantidad){
         $conexion=$this->conectarse(); 
         $sql="UPDATE COSTOS SET   \n"; 
         $sql.="  REFERENTE_ID=?,     \n";
         $sql.="  TEXTO_NODO=?,     \n"; 
         $sql.="  CANTIDAD_MATERIAL=?     \n"; 
         $sql.="WHERE COSTO_ITEM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssds", $materialId, $materialNombre, $cantidad, $costoItemId); 
         return $this->ejecutaYCierra($conexion, $stm); 
      }      

      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE COSTOS SET   \n"; 
         $sql.="  ORDEN=?,     \n"; 
         $sql.="  TEXTO_NODO=?,     \n"; 
         $sql.="  ITEM_PADRE=?,     \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  TIEMPO=?,     \n"; 
         $sql.="  DOTACION_SUGERIDA=?,     \n"; 
         $sql.="  CANTIDAD_MATERIAL=?,     \n"; 
         $sql.="  PORCENTAJE_AJUSTE=?,     \n"; 
         $sql.="  TIPO=?,     \n"; 
         $sql.="  REFERENTE_ID=?     \n";
         $sql.="WHERE COSTO_ITEM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("issssiddsss", $bean->getOrden(), $bean->getTexto(), $bean->getPadreId(), $bean->getPiezaId(), $bean->getTiempo(), $bean->getDotacionSugerida(), $bean->getCantidadMaterial(), $bean->getPorcentajeAjuste(), $bean->getTipo(), $bean->getId(), $bean->getReferenteId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function actualizaIndice($id, $nuevoOrden){
         $conexion=$this->conectarse(); 
         $sql="UPDATE COSTOS SET   \n"; 
         $sql.="  ORDEN=?     \n"; 
         $sql.="WHERE COSTO_ITEM_ID=?   \n";       	
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("is", $nuevoOrden, $id);
         return $this->ejecutaYCierra($conexion, $stm); 
      }


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  COSTO_ITEM_ID,     \n"; 
         $sql.="  ORDEN,     \n"; 
         $sql.="  TEXTO_NODO,     \n"; 
         $sql.="  ITEM_PADRE,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  TIEMPO,     \n"; 
         $sql.="  DOTACION_SUGERIDA,     \n"; 
         $sql.="  CANTIDAD_MATERIAL,     \n"; 
         $sql.="  PORCENTAJE_AJUSTE,     \n"; 
         $sql.="  TIPO,     \n"; 
         $sql.="  REFERENTE_ID     \n";
         $sql.="FROM  \n"; 
         $sql.="  COSTOS  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  TEXTO_NODO  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $orden=null;  
         $texto=null;  
         $padreId=null;  
         $piezaId=null;  
         $horasHombre=null;  
         $dotacionSugerida=null;  
         $cantidadMaterial=null;  
         $porcentajeAjuste=null;  
         $tipo=null;
         $referenteId=null;
         $stm->bind_result($id, $orden, $texto, $padreId, $piezaId, $horasHombre, $dotacionSugerida, $cantidadMaterial, $porcentajeAjuste, $tipo, $referenteId); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new ItemCosto();  
            $bean->setId($id);
            $bean->setOrden($orden);
            $bean->setTexto($texto);
            $bean->setPadreId($padreId);
            $bean->setPiezaId($piezaId);
            $bean->setTiempo($horasHombre);
            $bean->setDotacionSugerida($dotacionSugerida);
            $bean->setCantidadMaterial($cantidadMaterial);
            $bean->setPorcentajeAjuste($porcentajeAjuste);
            $bean->setTipo($tipo);
            $bean->setReferenteId($referenteId);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selPorPieza($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  COSTO_ITEM_ID,     \n"; 
         $sql.="  ORDEN,     \n"; 
         $sql.="  TEXTO_NODO,     \n"; 
         $sql.="  ITEM_PADRE,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  TIEMPO,     \n"; 
         $sql.="  DOTACION_SUGERIDA,     \n"; 
         $sql.="  CANTIDAD_MATERIAL,     \n"; 
         $sql.="  PORCENTAJE_AJUSTE,     \n"; 
         $sql.="  TIPO,    \n"; 
         $sql.="  REFERENTE_ID    \n";
         $sql.="FROM  \n"; 
         $sql.="  COSTOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  PIEZA_ID='" . $piezaId . "'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  TEXTO_NODO  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $orden=null;  
         $texto=null;  
         $padreId=null;  
         $piezaId=null;  
         $horasHombre=null;  
         $dotacionSugerida=null;  
         $cantidadMaterial=null;  
         $porcentajeAjuste=null;  
         $tipo=null;  
         $referenteId=null;
         $stm->bind_result($id, $orden, $texto, $padreId, $piezaId, $horasHombre, $dotacionSugerida, $cantidadMaterial, $porcentajeAjuste, $tipo, $referenteId); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new ItemCosto();  
            $bean->setId($id);
            $bean->setOrden($orden);
            $bean->setTexto($texto);
            $bean->setPadreId($padreId);
            $bean->setPiezaId($piezaId);
            $bean->setTiempo($horasHombre);
            $bean->setDotacionSugerida($dotacionSugerida);
            $bean->setCantidadMaterial($cantidadMaterial);
            $bean->setPorcentajeAjuste($porcentajeAjuste);
            $bean->setTipo($tipo);
            $bean->setReferenteId($referenteId);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM COSTOS "; 
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