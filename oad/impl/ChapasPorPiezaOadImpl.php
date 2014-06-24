<?php

require_once '../../config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ChapasPorPiezaOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ChapaPorPieza.php';

   class ChapasPorPiezaOadImpl extends AOD implements ChapasPorPiezaOad {

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  CHP.CHXP_ID,     \n";
         $sql.="  CHP.PIEZA_ID,     \n";
         $sql.="  CHP.TERMINACION,     \n";
         $sql.="  CHP.CANTIDAD,     \n";
         $sql.="  CHP.ANCHO,     \n";
         $sql.="  CHP.LARGO,     \n";
         $sql.="  CHP.CRUZADA    \n";
         $sql.="FROM  \n";
         $sql.="  CHAPAS_POR_PIEZA CHP \n";
         $sql.="WHERE  \n";
         $sql.="  CHP.CHXP_ID='" . $id . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new ChapaPorPieza();
         $id=null;
         $piezaId=null;
         $terminacion=null;
         $cantidad=null;
         $ancho=null;
         $largo=null;
         $cruzada=null;
         $stm->bind_result($id, $piezaId, $terminacion, $cantidad, $ancho, $largo, $cruzada);
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setTerminacion($terminacion);
            $bean->setCantidad($cantidad);
            $bean->setAncho($ancho);
            $bean->setLargo($largo);
            $bean->setCruzada($cruzada);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }


      public function inserta($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO CHAPAS_POR_PIEZA (   \n";
         $sql.="  CHXP_ID,     \n";
         $sql.="  PIEZA_ID,     \n";
         $sql.="  TERMINACION,     \n";
         $sql.="  CANTIDAD,     \n";
         $sql.="  ANCHO,     \n";
         $sql.="  LARGO,     \n";
         $sql.="  CRUZADA)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?)    \n";
         $nuevoId=$this->idUnico();
         $bean->setId($nuevoId);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("sssdiii",$bean->getId(), $bean->getPiezaId(), $bean->getTerminacion(), $bean->getCantidad(), $bean->getAncho(), $bean->getLargo(), $bean->getCruzada());
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId);
      }


      public function borra($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM CHAPAS_POR_PIEZA   \n";
         $sql.="WHERE CHXP_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function actualiza($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE CHAPAS_POR_PIEZA SET   \n";
         $sql.="  PIEZA_ID=?,     \n";
         $sql.="  TERMINACION=?,     \n";
         $sql.="  CANTIDAD=?,     \n";
         $sql.="  ANCHO=?,     \n";
         $sql.="  LARGO=?,     \n";
         $sql.="  CRUZADA=?     \n";
         $sql.="WHERE CHXP_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssdiiis", $bean->getPiezaId(), $bean->getTerminacion(), $bean->getCantidad(), $bean->getAncho(), $bean->getLargo(), $bean->getCruzada(), $bean->getId() );
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function selTodos($desde, $cuantos, $piezaId){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  CHP.CHXP_ID,     \n";
         $sql.="  CHP.PIEZA_ID,     \n";
         $sql.="  CHP.TERMINACION,     \n";
         $sql.="  CHP.CANTIDAD,     \n";
         $sql.="  CHP.ANCHO,     \n";
         $sql.="  CHP.LARGO,     \n";
         $sql.="  CHP.CRUZADA    \n";
         $sql.="FROM  \n";
         $sql.="  CHAPAS_POR_PIEZA CHP \n";
         $sql.="WHERE  \n";
         $sql.="  CHP.PIEZA_ID='". $piezaId .  "' \n";
         $sql.="ORDER BY  \n";
         $sql.="  CHP.TERMINACION  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $piezaId=null;
         $terminacion=null;
         $cantidad=null;
         $ancho=null;
         $largo=null;
         $cruzada=null;
         $stm->bind_result($id, $piezaId, $terminacion, $cantidad, $ancho, $largo, $cruzada);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new ChapaPorPieza();
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setTerminacion($terminacion);
            $bean->setCantidad($cantidad);
            $bean->setAncho($ancho);
            $bean->setLargo($largo);
            $bean->setCruzada($cruzada);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }


      public function selTodosCuenta($piezaId){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) FROM CHAPAS_POR_PIEZA CHP \n";
         $sql.="WHERE  \n";
         $sql.="  CHP.PIEZA_ID='". $piezaId .  "' \n";
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