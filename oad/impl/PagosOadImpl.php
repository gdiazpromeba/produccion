<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PagosOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
// require_once('FirePHPCore/fb.php4');

   class PagosOadImpl extends AOD implements PagosOad {

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PAG.PAGO_ID,     \n";
         $sql.="  PAG.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PAG.MONTO,     \n";
         $sql.="  PAG.FECHA,     \n";
         $sql.="  PAG.TIPO,     \n";
         $sql.="  PAG.OBSERVACIONES     \n";
         $sql.="FROM  \n";
         $sql.="  PAGOS  PAG \n";
         $sql.="WHERE  \n";
         $sql.="  PAG.PAGO_ID='" . $id . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new Pago();
         $stm->bind_result($id, $cabeceraId, $efectivoMonto, $fecha, $tipo, $observaciones);
         if ($stm->fetch()) {
         	$bean=new Pago();
            $bean->setId($id);
            $bean->setPedidoId($cabeceraId);
            $bean->setMonto($efectivoMonto);
            $bean->setFechaLarga($fecha);
            $bean->setTipo($tipo);
            $bean->setObservaciones($observaciones);
            
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }


      public function inserta($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO PAGOS (   \n";
         $sql.="  PAGO_ID,     \n";
         $sql.="  PEDIDO_CABECERA_ID,     \n";
         $sql.="  MONTO,     \n";
         $sql.="  FECHA,     \n";
         $sql.="  TIPO,     \n";
         $sql.="  OBSERVACIONES     \n";
         $sql.=") VALUES (?, ?, ?, ?, ?, ?)    \n";
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssdsss", 
           $bean->getId(), $bean->getPedidoId(), $bean->getMonto(),  $bean->getFechaLarga(), 
           $bean->getTipo(), $bean->getObservaciones());
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }


      public function borra($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM PAGOS   \n";
         $sql.="WHERE PAGO_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function actualiza($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE PAGOS SET    \n";
         $sql.="  PEDIDO_CABECERA_ID=?,     \n";
         $sql.="  MONTO=?,     \n";
         $sql.="  FECHA=?,     \n";
         $sql.="  TIPO=?,     \n";
         $sql.="  OBSERVACIONES=?     \n";
         $sql.="WHERE PAGO_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
                  $stm->bind_param("sdssss", 
           $bean->getPedidoId(), $bean->getMonto(),  $bean->getFechaLarga(), 
           $bean->getTipo(), $bean->getObservaciones(), $bean->getId());
         
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function selTodos($desde, $cuantos, $pedidoCabeceraId){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PAG.PAGO_ID,     \n";
         $sql.="  PAG.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PAG.MONTO,     \n";
         $sql.="  PAG.FECHA,     \n";
         $sql.="  PAG.TIPO,     \n";
         $sql.="  PAG.OBSERVACIONES     \n";
         $sql.="FROM  \n";
         $sql.="  PAGOS  PAG \n";
         $sql.="WHERE  1=1 \n";
         if (!empty($pedidoCabeceraId)){
         	$sql.="  AND PAG.PEDIDO_CABECERA_ID='" .$pedidoCabeceraId . "' \n";
         }
         $sql.="ORDER BY  \n";
         $sql.="  PAG.FECHA  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cheque=new Cheque();
         $stm->bind_result($id, $cabeceraId, $efectivoMonto, $fecha, $tipo, $observaciones);
         $filas = array();
         while ($stm->fetch()) {
         	$bean=new Pago();
            $bean->setId($id);
            $bean->setPedidoId($cabeceraId);
            $bean->setMonto($efectivoMonto);
            $bean->setFechaLarga($fecha);
            $bean->setTipo($tipo);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }



      public function selTodosCuenta($pedidoCabeceraId){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*)   ";
         $sql.="FROM  \n";
         $sql.="  PAGOS  PAG \n";
         $sql.="WHERE  1=1 \n";
         if ($pedidoCabeceraId!=null){
         	$sql.="  AND PAG.PEDIDO_CABECERA_ID='" .$pedidoCabeceraId . "' \n";
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