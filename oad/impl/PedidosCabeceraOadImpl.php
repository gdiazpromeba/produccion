<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PedidosCabeceraOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pedido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class PedidosCabeceraOadImpl extends AOD implements PedidosCabeceraOad {

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PEC.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PEC.PEDIDO_NUMERO,     \n";
         $sql.="  PEC.CLIENTE_ID,     \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  PEC.PEDIDO_FECHA,     \n";
         $sql.="  PEC.FECHA_PROMETIDA,     \n";
         $sql.="  PEC.PEDIDO_CONTACTO,     \n";
         $sql.="  PEC.PEDIDO_ESTADO,     \n";
         $sql.="  PEC.HABILITADO    \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_CABECERA  PEC \n";
         $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  PEC.PEDIDO_CABECERA_ID='" . $id . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new Pedido();
         $id=null;
         $pedidoNumero=null;
         $clienteId=null;
         $clienteNombre=null;
         $fecha=null;
         $fechaPrometida=null;
         $contacto=null;
         $estado=null;
         $habilitado=null;
         $stm->bind_result($id, $pedidoNumero,  $clienteId, $clienteNombre, $fecha, $fechaPrometida, $contacto, $estado, $habilitado);
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setNumero($pedidoNumero);
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setFechaLarga($fecha);
            $bean->setFechaPrometidaLarga($fechaPrometida);
            $bean->setReferencia($contacto);
            $bean->setEstado($estado);
            $bean->setHabilitado($habilitado);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }


      public function inserta($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO PEDIDOS_CABECERA (   \n";
         $sql.="  PEDIDO_CABECERA_ID,     \n";
         $sql.="  CLIENTE_ID,     \n";
         $sql.="  PEDIDO_FECHA,     \n";
         $sql.="  FECHA_PROMETIDA,     \n";
         $sql.="  PEDIDO_CONTACTO,     \n";
         $sql.="  PEDIDO_ESTADO,     \n";
         $sql.="  HABILITADO)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, 1)    \n";
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssssss",$bean->getId(), $bean->getClienteId(), $bean->getFechaLarga(), $bean->getFechaPrometidaLarga(),  $bean->getReferencia(),  $bean->getEstado());
         $res = $this->ejecutaYCierra($conexion, $stm, $idUnico);
         $bean = $this->obtiene($idUnico);
         $res['numero']=$bean->getNumero();
         return $res;
      }


      public function borra($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM PEDIDOS_CABECERA   \n";
         $sql.="WHERE PEDIDO_CABECERA_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         return $this->ejecutaYCierra($conexion, $stm);
      }

      public function inhabilita($id){
         $conexion=$this->conectarse();
         $sql="UPDATE PEDIDOS_CABECERA   \n";
         $sql.="SET HABILITADO=0   \n";
         $sql.="WHERE PEDIDO_CABECERA_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function actualiza($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE PEDIDOS_CABECERA SET   \n";
         $sql.="  CLIENTE_ID=?,     \n";
         $sql.="  PEDIDO_FECHA=?,     \n";
         $sql.="  FECHA_PROMETIDA=?,     \n";
         $sql.="  PEDIDO_CONTACTO=?,     \n";
         $sql.="  PEDIDO_ESTADO=?     \n";
         $sql.="WHERE PEDIDO_CABECERA_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssssss", $bean->getClienteId(), $bean->getFechaLarga(), $bean->getFechaPrometidaLarga(), $bean->getReferencia(), $bean->getEstado(), $bean->getId() );
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function selTodos($desde, $cuantos,  $sort, $dir, $clienteId, $pedidoEstado, $fechaDesde, $fechaHasta){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PEC.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PEC.PEDIDO_NUMERO,     \n";
         $sql.="  PEC.CLIENTE_ID,     \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  PEC.PEDIDO_FECHA,     \n";
         $sql.="  PEC.FECHA_PROMETIDA,     \n";
         $sql.="  PEC.PEDIDO_CONTACTO,     \n";
         $sql.="  PEC.PEDIDO_ESTADO,     \n";
         $sql.="  PEC.HABILITADO    \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_CABECERA  PEC \n";
         $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  PEC.HABILITADO=1 \n";
         if ($clienteId!=null){
         	$sql.="  AND PEC.CLIENTE_ID='" .$clienteId . "' \n";
         }
         if ($pedidoEstado!=null){
         	$sql.="  AND PEC.PEDIDO_ESTADO='" .$pedidoEstado . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND PEC.PEDIDO_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PEC.PEDIDO_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }
         if (!empty($sort)){
           $sql.="ORDER BY  \n";
           if ($sort=='pedidoFecha'){
             $sql.="  PEC.PEDIDO_FECHA " . $dir . " \n";
           }
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $clienteId=null;
         $pedidoNumero=null;
         $clienteNombre=null;
         $fecha=null;
         $fechaPrometida=null;
         $referencia=null;
         $estado=null;
         $habilitado=null;
         $stm->bind_result($id, $pedidoNumero, $clienteId, $clienteNombre, $fecha, $fechaPrometida, $referencia, $estado, $habilitado);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new Pedido();
            $bean->setId($id);
            $bean->setNumero($pedidoNumero);
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setFechaLarga($fecha);
            $bean->setFechaPrometidaLarga($fechaPrometida);
            $bean->setReferencia($referencia);
            $bean->setEstado($estado);
            $bean->setHabilitado($habilitado);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }




      public function selTodosCuenta($clienteId, $pedidoEstado, $fechaDesde, $fechaHasta){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*)  ";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_CABECERA  PEC \n";
         $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  PEC.HABILITADO=1 \n";
         if ($clienteId!=null){
         	$sql.="  AND PEC.CLIENTE_ID='" .$clienteId . "' \n";
         }
         if ($pedidoEstado!=null){
         	$sql.="  AND PEC.PEDIDO_ESTADO='" .$pedidoEstado . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND PEC.PEDIDO_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PEC.PEDIDO_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
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