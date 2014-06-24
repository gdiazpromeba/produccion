<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/RemitosLaqueadoOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PnaLaqueador.php';
//require_once('FirePHPCore/fb.php');

   class RemitosLaqueadoOadImpl extends AOD implements RemitosLaqueadoOad {

    public function selPedidosNoAsignados($desde, $cuantos){
     $conexion=$this->conectarse();
	 $sql="SELECT                     \n";
	 $sql.="  CLI.CLIENTE_ID,     \n";
	 $sql.="  CLI.CLIENTE_NOMBRE,     \n";
	 $sql.="  PEC.PEDIDO_CABECERA_ID,     \n";
	 $sql.="  PEC.PEDIDO_NUMERO,     \n";
	 $sql.="  PEC.PEDIDO_FECHA,     \n";
	 $sql.="  PEC.FECHA_PROMETIDA,     \n";
	 $sql.="  PIE.PIEZA_ID,     \n";
	 $sql.="  PIE.PIEZA_NOMBRE,     \n";
	 $sql.="  TER.TERMINACION_ID,     \n";
	 $sql.="  TER.TERMINACION_NOMBRE,     \n";
	 $sql.="  PED.PEDIDO_DETALLE_ID,     \n";
	 $sql.="  PED.PEDIDO_CANTIDAD     \n";
	 $sql.="FROM      \n";
	 $sql.="  PEDIDOS_DETALLE PED     \n";
	 $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID      \n";
	 $sql.="  INNER JOIN PIEZAS PIE ON PIE.PIEZA_ID=PED.PIEZA_ID      \n";
	 $sql.="  INNER JOIN TERMINACIONES TER ON TER.TERMINACION_ID=PED.TERMINACION_ID     \n";
	 $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID      \n";
	 $sql.="  LEFT JOIN REMITOS_LAQUEADO_DETALLE RLD ON PED.PEDIDO_DETALLE_ID=RLD.PEDIDO_DETALLE_ID      \n";
	 $sql.="WHERE       \n";
	 $sql.="  PEC.HABILITADO=1                                                                                \n";
	 $sql.="  and PEC.PEDIDO_ESTADO='Pendiente'      \n";
	 $sql.="  AND RLD.PEDIDO_DETALLE_ID IS NULL      \n";
	 $sql.="ORDER BY     \n";
	 $sql.="  PEC.FECHA_PROMETIDA              \n";
	 $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
	 $stm=$this->preparar($conexion, $sql);
	 $stm->execute();
	 $clienteId=null;
	 $clienteNombre=null;
	 $pedidoCabeceraId=null;
	 $pedidoNumero=null;
	 $pedidoFecha=null;
	 $fechaPrometida=null;
	 $piezaId=null;
	 $piezaNombre=null;
	 $terminacionId=null;
	 $terminacionNombre=null;
	 $pedidoDetalleId=null;
	 $cantidad=null;


         $stm->bind_result($clienteId, $clienteNombre, $pedidoCabeceraId, $pedidoNumero, $pedidoFecha, $fechaPrometida, $piezaId, $piezaNombre,
                           $terminacionId, $terminacionNombre, $pedidoDetalleId, $cantidad);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new PnaLaqueador();
            $bean->setClienteId($clienteId);
            $bean->setClienteNombre($clienteNombre);
            $bean->setPedidoCabeceraId($pedidoCabeceraId);
            $bean->setPedidoNumero($pedidoNumero);
            $bean->setFechaPrometidaLarga($pedidoFecha);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setTerminacionId($terminacionId);
            $bean->setTerminacionNombre($terminacionNombre);
            $bean->setPedidoDetalleId($pedidoDetalleId);
            $bean->setCantidad($cantidad);
            $filas[$pedidoDetalleId]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selPedidosNoAsignadosCuenta(){
         $conexion=$this->conectarse();
	 $sql="SELECT                     \n";
	 $sql.="  COUNT(*)               \n";
	 $sql.="FROM      \n";
	 $sql.="  PEDIDOS_DETALLE PED     \n";
	 $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID      \n";
	 $sql.="  INNER JOIN PIEZAS PIE ON PIE.PIEZA_ID=PED.PIEZA_ID      \n";
	 $sql.="  INNER JOIN TERMINACIONES TER ON TER.TERMINACION_ID=PED.TERMINACION_ID     \n";
	 $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID      \n";
	 $sql.="WHERE       \n";
	 $sql.="  PEC.PEDIDO_ESTADO='Pendiente'      \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }

      public function insertaCabecera($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO REMITOS_LAQUEADO_CABECERA (   \n";
         $sql.="  REMITO_LAQUEADO_CAB_ID,     \n";
         $sql.="  LAQUEADOR_ID,     \n";
         $sql.="  FECHA_ENVIO,     \n";
         $sql.="  ESTADO)     \n";
         $sql.="VALUES (?, ?, ?, 'En Taller')    \n";
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("sss", $bean->getId(), $bean->getLaqueadorId(), $bean->getFechaEnvioLarga());
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }

      public function modificaCabecera($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE REMITOS_LAQUEADO_CABECERA SET   \n";
         $sql.="  LAQUEADOR_ID = ?,     \n";
         $sql.="  FECHA_ENVIO = ?,     \n";
         $sql.="  ESTADO = ?     \n";
         $sql.="WHERE     \n";
         $sql.="  REMITO_LAQUEADO_CAB_ID = ?     \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssss", $bean->getLaqueadorId(), $bean->getFechaEnvioLarga(), $bean->getEstado(), $bean->getId());
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }


      public function borraCabecera($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM REMITOS_LAQUEADO_CABECERA    \n";
         $sql.="WHERE     \n";
         $sql.="  REMITO_LAQUEADO_CAB_ID ='" .  $id . "'    \n";
         $stm=$this->preparar($conexion, $sql);
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }



      public function insertaDetalle($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO REMITOS_LAQUEADO_DETALLE (   \n";
         $sql.="  REMITO_LAQUEADO_DET_ID,     \n";
         $sql.="  REMITO_LAQUEADO_CAB_ID,     \n";
         $sql.="  ITEM,     \n";
         $sql.="  PEDIDO_DETALLE_ID,     \n";
         $sql.="  CANTIDAD     \n";
         $sql.=")VALUES (?, ?, ?, ?, ?)    \n";
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssdsd", $bean->getId(), $bean->getCabeceraId(), $bean->getItem(), $bean->getPedidoDetalleId(), $bean->getCantidad());
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }

      public function selCabecera($desde, $cuantos,  $laqueadorId, $envioDesde, $envioHasta,  $estado ){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  RLC.REMITO_LAQUEADO_CAB_ID,     \n";
         $sql.="  RLC.LAQUEADOR_ID,     \n";
         $sql.="  LAQ.LAQUEADOR_NOMBRE,     \n";
         $sql.="  RLC.FECHA_ENVIO,     \n";
         $sql.="  RLC.REMITO_LAQUEADO_NUMERO,     \n";
         $sql.="  RLC.ESTADO     \n";
         $sql.="FROM  \n";
         $sql.="  REMITOS_LAQUEADO_CABECERA RLC \n";
         $sql.="  INNER JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID=LAQ.LAQUEADOR_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  1=1 \n";
         if ($laqueadorId!=null){
         	$sql.="  AND LAQ.LAQUEADOR_ID='" .$laqueadorId . "' \n";
         }
         if ($estado!=null){
         	$sql.="  AND RLC.ESTADO='" .$estado . "' \n";
         }
         if (!empty($envioDesde)){
         	$sql.="  AND RLC.FECHA_ENVIO >= '" . FechaUtils::dateTimeACadena($envioDesde) . "' \n";
         }
         if (!empty($envioHasta)){
         	$sql.="  AND RLC.FECHA_ENVIO <= '" . FechaUtils::dateTimeACadena($envioHasta) . "' \n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();

         $id=null;
         $laqueadorId=null;
         $laqueadorNombre=null;
         $fechaEnvio=null;
         $numero=null;
         $estado=null;
         $stm->bind_result($id, $laqueadorId, $laqueadorNombre, $fechaEnvio, $numero, $estado);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new RemitoLaqueadoCabecera();
            $bean->setId($id);
            $bean->setLaqueadorId($laqueadorId);
            $bean->setLaqueadorNombre($laqueadorNombre);
            $bean->setFechaEnvioLarga($fechaEnvio);
            $bean->setNumero($numero);
            $bean->setEstado($estado);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selCabeceraCuenta($laqueadorId, $envioDesde, $envioHasta,  $estado ){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*)  ";
         $sql.="FROM  \n";
         $sql.="  REMITOS_LAQUEADO_CABECERA RLC \n";
         $sql.="  INNER JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID=LAQ.LAQUEADOR_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  1=1 \n";
         if ($laqueadorId!=null){
         	$sql.="  AND LAQ.LAQUEADOR_ID='" .$laqueadorId . "' \n";
         }
         if ($estado!=null){
         	$sql.="  AND RLC.ESTADO='" .$estado . "' \n";
         }
         if (!empty($envioDesde)){
         	$sql.="  AND RLC.FECHA_ENVIO >= '" . FechaUtils::dateTimeACadena($envioDesde) . "' \n";
         }
         if (!empty($envioHasta)){
         	$sql.="  AND RLC.FECHA_ENVIO <= '" . FechaUtils::dateTimeACadena($envioHasta) . "' \n";
         }
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }
      
      public function selDetalles($desde, $cuantos,  $cabeceraId ){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  RLD.REMITO_LAQUEADO_DET_ID,     \n";
         $sql.="  RLD.ITEM,     \n";
         $sql.="  RLD.PEDIDO_DETALLE_ID,     \n";
         $sql.="  RLD.CANTIDAD,     \n";
         $sql.="  PEC.CLIENTE_ID,     \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  PED.TERMINACION_ID,     \n";
         $sql.="  TER.TERMINACION_NOMBRE,     \n";
         $sql.="  PIE.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE     \n";
         $sql.="FROM  \n";
         $sql.="  REMITOS_LAQUEADO_DETALLE RLD  \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RLD.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="  INNER JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID \n";
	 $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID \n";         
	 $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID \n";
	 $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID \n";
         $sql.="WHERE  \n";
         $sql.="  RLD.REMITO_LAQUEADO_CAB_ID='" . $cabeceraId . "'     \n";
         $sql.="ORDER BY  \n";
         $sql.="  RLD.ITEM     \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $item=null;
         $detalleId=null;
         $cantidad=null;
         $clienteId=null;
         $clienteNombre=null;
         $terminacionId=null;
         $terminacionNombre=null;
         $piezaId=null;
         $piezaNombre=null;
         $stm->bind_result($id, $item, $detalleId, $cantidad, $clienteId, $clienteNombre, $terminacionId, $terminacionNombre, $piezaId, $piezaNombre );
         $filas = array();
         while ($stm->fetch()) {
            $bean=new RemitoLaqueadoDetalle();
            $bean->setId($id);
            $bean->setItem($item);
            $bean->setPedidoDetalleId($id);
            $bean->setCantidad($cantidad);
            $bean->setClienteNombre($clienteNombre);
            $bean->setTerminacionNombre($terminacionNombre);
            $bean->setPiezaNombre($piezaNombre);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }      
      
      public function selDetallesCuenta($cabeceraId ){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*)  ";
         $sql.="FROM  \n";
         $sql.="  REMITOS_LAQUEADO_DETALLE RLD  \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RLD.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="  INNER JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }      

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  RLC.LAQUEADOR_ID,     \n";
         $sql.="  LAQ.LAQUEADOR_NOMBRE,     \n";
         $sql.="  RLC.FECHA_ENVIO,     \n";
         $sql.="  RLC.REMITO_LAQUEADO_NUMERO,     \n";
         $sql.="  RLC.ESTADO     \n";
         $sql.="FROM  \n";
         $sql.="  REMITOS_LAQUEADO_CABECERA RLC \n";
         $sql.="  INNER JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID=LAQ.LAQUEADOR_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  RLC.REMITO_LAQUEADO_CAB_ID='" . $id . "'     \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new RemitoLaqueadoCabecera();
         $laqueadorId=null;
         $laqueadorNombre=null;
         $fechaEnvio=null;
         $numero=null;
         $estado=null;
         $stm->bind_result($laqueadorId, $laqueadorNombre, $fechaEnvio, $numero, $estado);
         $bean=new RemitoLaqueadoCabecera();
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setLaqueadorId($laqueadorId);
            $bean->setLaqueadorNombre($laqueadorNombre);
            $bean->setFechaEnvioLarga($fechaEnvio);
            $bean->setNumero($numero);
            $bean->setEstado($estado);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }
   }
?>