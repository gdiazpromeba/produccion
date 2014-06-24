<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PedidosDetalleOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PedidoDetalle.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PedidoPlano.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PedidoPendiente.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class PedidosDetalleOadImpl extends AOD implements PedidosDetalleOad {

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PED.PEDIDO_DETALLE_ID,     \n";
         $sql.="  PED.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PED.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  PED.PEDIDO_CANTIDAD,     \n";
         $sql.="  PED.PEDIDO_REMITIDOS,     \n";
         $sql.="  PED.SIN_PATAS,     \n";
         $sql.="  PED.PEDIDO_OBSERVACIONES,     \n";
         $sql.="  PED.PEDIDO_DETALLE_PRECIO,    \n";
         $sql.="  PED.TERMINACION_ID,    \n";
         $sql.="  TER.TERMINACION_NOMBRE    \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  PED.PEDIDO_DETALLE_ID='" . $id . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new PedidoDetalle();
         $id=null;
         $cabeceraId=null;
         $piezaId=null;
         $piezaNombre=null;
         $cantidad=null;
         $remitidos=null;
         $sinPatas=null;
         $observaciones=null;
         $precio=null;
         $terminacionId=null;
         $terminacionNombre=null;
         $stm->bind_result($id, $cabeceraId, $piezaId, $piezaNombre, $cantidad, $remitidos, $sinPatas, $observaciones, $precio, $terminacionId, $terminacionNombre);
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setCantidad($cantidad);
            $bean->setRemitidos($remitidos);
            $bean->setSinPatas($sinPatas);
            $bean->setObservaciones($observaciones);
            $bean->setTerminacionId($terminacionId);
            $bean->setTerminacionNombre($terminacionNombre);
            $bean->setPrecio($precio);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }


      public function inserta($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO PEDIDOS_DETALLE (   \n";
         $sql.="  PEDIDO_DETALLE_ID,     \n";
         $sql.="  PEDIDO_CABECERA_ID,     \n";
         $sql.="  PIEZA_ID,     \n";
         $sql.="  PEDIDO_CANTIDAD,     \n";
         $sql.="  SIN_PATAS,     \n";
         $sql.="  PEDIDO_OBSERVACIONES,     \n";
         $sql.="  PEDIDO_DETALLE_PRECIO,    \n";
         $sql.="  TERMINACION_ID)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?)    \n";
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("sssdisds",$bean->getId(), $bean->getCabeceraId(), $bean->getPiezaId(), $bean->getCantidad(), $bean->getSinPatas(), $bean->getObservaciones(), $bean->getPrecio(), $bean->getTerminacionId());
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }


      public function borra($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM PEDIDOS_DETALLE   \n";
         $sql.="WHERE PEDIDO_DETALLE_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function actualiza($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE PEDIDOS_DETALLE SET   \n";
         $sql.="  PEDIDO_CABECERA_ID=?,     \n";
         $sql.="  PIEZA_ID=?,     \n";
         $sql.="  PEDIDO_CANTIDAD=?,     \n";
         $sql.="  PEDIDO_REMITIDOS=?,     \n";
         $sql.="  SIN_PATAS=?,     \n";
         $sql.="  PEDIDO_OBSERVACIONES=?,     \n";
         $sql.="  PEDIDO_DETALLE_PRECIO=?,     \n";
         $sql.="  TERMINACION_ID=?     \n";
         $sql.="WHERE PEDIDO_DETALLE_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssddisdss", $bean->getCabeceraId(), $bean->getPiezaId(), $bean->getCantidad(), $bean->getRemitidos(), $bean->getSinPatas(), $bean->getObservaciones(), $bean->getPrecio(), $bean->getTerminacionId(),  $bean->getId() );
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function selTodos($desde, $cuantos, $pedidoCabeceraId){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PED.PEDIDO_DETALLE_ID,     \n";
         $sql.="  PED.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PEC.PEDIDO_NUMERO,     \n";
         $sql.="  PED.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  PED.PEDIDO_CANTIDAD,     \n";
         $sql.="  PED.PEDIDO_REMITIDOS,     \n";
         $sql.="  PED.SIN_PATAS,     \n";
         $sql.="  PED.PEDIDO_OBSERVACIONES,     \n";
         $sql.="  PED.PEDIDO_DETALLE_PRECIO,    \n";
         $sql.="  PED.TERMINACION_ID,    \n";
         $sql.="  TER.TERMINACION_NOMBRE    \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID  \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="  WHERE 1=1  \n";
         if (!empty($pedidoCabeceraId)){
         	$sql.="  AND PED.PEDIDO_CABECERA_ID='" .$pedidoCabeceraId . "' \n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $cabeceraId=null;
         $pedidoNumero=null;
         $piezaId=null;
         $piezaNombre=null;
         $cantidad=null;
         $remitidos=null;
         $sinPatas=null;
         $observaciones=null;
         $precio=null;
         $terminacionId=null;
         $terminacionNombre=null;
         $stm->bind_result($id, $cabeceraId, $pedidoNumero,  $piezaId, $piezaNombre, $cantidad, $remitidos, $sinPatas, $observaciones, $precio, $terminacionId, $terminacionNombre );
         $filas = array();
         while ($stm->fetch()) {
            $bean=new PedidoDetalle();
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setPedidoNumero($pedidoNumero);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setCantidad($cantidad);
            $bean->setRemitidos($remitidos);
            $bean->setSinPatas($sinPatas);
            $bean->setObservaciones($observaciones);
            $bean->setPrecio($precio);
            $bean->setTerminacionId($terminacionId);
            $bean->setTerminacionNombre($terminacionNombre);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }


      public function selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta,
                                    $precioTotalDesde, $precioPendienteDesde, $estadoLaqueado, $nombreOParte){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PED.PEDIDO_DETALLE_ID,     \n";
         $sql.="  PED.PEDIDO_CABECERA_ID,     \n";
         $sql.="  PEC.CLIENTE_ID,     \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  PEC.PEDIDO_ESTADO,     \n";
         $sql.="  PEC.PEDIDO_FECHA,     \n";
         $sql.="  PEC.PEDIDO_CONTACTO,     \n";
         $sql.="  PEC.PEDIDO_NUMERO,     \n";
         $sql.="  PED.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  PIE.PIEZA_FICHA,     \n";
         $sql.="  PED.PEDIDO_CANTIDAD,     \n";
         $sql.="  PED.PEDIDO_REMITIDOS,     \n";
         $sql.="  PED.PEDIDO_CANTIDAD - PED.PEDIDO_REMITIDOS AS PENDIENTES,     \n";
         $sql.="  PED.SIN_PATAS,     \n";
         $sql.="  PED.PEDIDO_DETALLE_PRECIO,    \n";
         $sql.="  PED.PEDIDO_DETALLE_PRECIO * PED.PEDIDO_CANTIDAD AS PRECIO_TOTAL,    \n";
         $sql.="  PED.PEDIDO_DETALLE_PRECIO * (PED.PEDIDO_CANTIDAD  - PED.PEDIDO_REMITIDOS) AS PRECIO_PENDIENTE,    \n";
         $sql.="  PED.PEDIDO_OBSERVACIONES,    \n";
         $sql.="  PED.TERMINACION_ID,    \n";
         $sql.="  TER.TERMINACION_NOMBRE,    \n";
         $sql.="  LAQ.LAQUEADOR_NOMBRE,    \n";
         $sql.="  RLC.FECHA_ENVIO,    \n";
         $sql.="  RLC.ESTADO AS ESTADO_LAQUEADO    \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID=PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=PEC.CLIENTE_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="  LEFT JOIN REMITOS_LAQUEADO_DETALLE RLD ON PED.PEDIDO_DETALLE_ID=RLD.PEDIDO_DETALLE_ID  \n";
         $sql.="  LEFT JOIN REMITOS_LAQUEADO_CABECERA RLC ON RLD.REMITO_LAQUEADO_CAB_ID = RLC.REMITO_LAQUEADO_CAB_ID  \n";
         $sql.="  LEFT JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID = LAQ.LAQUEADOR_ID \n";
         $sql.="WHERE     \n";
         $sql.="  PEC.HABILITADO=1          \n";
         if (!empty($clienteId)){
           $sql.="AND PEC.CLIENTE_ID='" . $clienteId . "'    \n";
         }
         if (!empty($piezaId)){
           $sql.="AND PED.PIEZA_ID='" . $piezaId . "'   \n";
         }
         if (!empty($estado)){
           $sql.="AND PEC.PEDIDO_ESTADO='" . $estado . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND PEC.PEDIDO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PEC.PEDIDO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }
         if (!empty($precioTotalDesde)){
         	$sql.="  AND PRECIO_TOTAL >=" .  $precioTotalDesde .   " \n";
         }
         if (!empty($precioPendienteDesde)){
         	$sql.="  AND PRECIO_PENDIENTE >=" .  $precioPendienteDesde .   " \n";
         }
         if (!empty($estadoLaqueado)){
         	$sql.="  AND RLC.ESTADO ='" .  $estadoLaqueado .   "' \n";
         }
         if (!empty($nombreOParte)){
         	$sql.="  AND UPPER(PIE.PIEZA_NOMBRE) LIKE '%" . mb_strtoupper($nombreOParte, 'utf-8')   . "%'  \n";
         }
         if (!empty($sort)){
           $sql.="ORDER BY  \n";
         }

         if ($sort=='fecha'){
           $sql.="  PEC.PEDIDO_FECHA  " . $dir . "  \n";
         }
         if ($sort=='pendientes'){
           $sql.="  PENDIENTES  " . $dir . "  \n";
         }
         if ($sort=='precioTotal'){
           $sql.="  PRECIO_TOTAL  " . $dir . "  \n";
         }
         if ($sort=='precioPendiente'){
           $sql.="  PRECIO_PENDIENTE  " . $dir . "  \n";
         }
         if ($sort=='ficha'){
           $sql.="  PIE.FICHA  " . $dir . "  \n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $pedidoDetalleId=null;
         $pedidoCabeceraId=null;
         $clienteId=null;
         $clienteNombre=null;
         $estado=null;
         $fecha=null;
         $contacto=null;
         $numero=null;
         $piezaId=null;
         $piezaNombre=null;
         $ficha=null;
         $cantidad=null;
         $remitidos=null;
         $pendientes=null;
         $sinPatas=null;
         $precioUnitario=null;
         $precioTotal=null;
         $precioPendiente=null;
         $observaciones=null;
         $terminacionId=null;
         $terminacionNombre=null;
         $laqueadorNombre=null;
         $fechaEnvio=null;
         $estadoLaqueado=null;
         $stm->bind_result($pedidoDetalleId, $pedidoCabeceraId, $clienteId,  $clienteNombre,
           $estado, $fecha, $contacto, $numero, $piezaId, $piezaNombre, $ficha,
           $cantidad, $remitidos, $pendientes, $sinPatas,
           $precioUnitario, $precioTotal, $precioPendiente, $observaciones, $terminacionId, $terminacionNombre,
           $laqueadorNombre, $fechaEnvio, $estadoLaqueado);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new PedidoPlano();
            $bean->setPedidoDetalleId($pedidoDetalleId);
	        $bean->setPedidoCabeceraId($pedidoCabeceraId);
	        $bean->setClienteId($clienteId);
	        $bean->setClienteNombre($clienteNombre);
	        $bean->setEstado($estado);
	        $bean->setFechaLarga($fecha);
	        $bean->setReferencia($contacto);
	        $bean->setNumero($numero);
	        $bean->setPiezaId($piezaId);
	        $bean->setPiezaNombre($piezaNombre);
	        $bean->setFicha($ficha);
            $bean->setCantidad($cantidad);
            $bean->setRemitidos($remitidos);
            $bean->setPendientes($pendientes);
            $bean->setSinPatas($sinPatas);
            $bean->setPrecioUnitario($precioUnitario);
            $bean->setPrecioTotal($precioTotal);
            $bean->setPrecioPendiente($precioPendiente);
            $bean->setObservaciones($observaciones);
            $bean->setTerminacionId($terminacionId);
            $bean->setTerminacionNombre($terminacionNombre);
            $bean->setLaqueadorNombre($laqueadorNombre);
            $bean->setFechaEnvioLarga($fechaEnvio);
            $bean->setEstadoLaqueado($estadoLaqueado);
            $filas[]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selReportePedido($pedidoCabeceraId){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  PEC.PEDIDO_FECHA,     \n";
         $sql.="  PEC.PEDIDO_NUMERO,     \n";
         $sql.="  PED.PEDIDO_CANTIDAD,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  PED.PEDIDO_OBSERVACIONES,    \n";
         $sql.="  TER.TERMINACION_NOMBRE    \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID=PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=PEC.CLIENTE_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="WHERE     \n";
         $sql.="  PEC.PEDIDO_CABECERA_ID='" . $pedidoCabeceraId . "'    \n";
         $sql.="ORDER BY     \n";
         $sql.="  PIE.PIEZA_FICHA     \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $clienteNombre=null;
         $pedidoFecha=null;
         $numero=null;
         $cantidad=null;
         $piezaNombre=null;
         $observaciones=null;
         $terminacionNombre=null;
         $stm->bind_result($clienteNombre, $pedidoFecha, $numero,  $cantidad,
         $piezaNombre, $observaciones, $terminacionNombre);
         $filas = array();
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['clienteNombre']=$clienteNombre;
         	$fila['pedidoFecha']= FechaUtils::cadenaLargaADMA($pedidoFecha);
         	$fila['numero']=$numero;
         	$fila['cantidad']=$cantidad;
         	$fila['piezaNombre']=$piezaNombre;
         	$fila['observaciones']=$observaciones;
         	$fila['terminacionNombre']=$terminacionNombre;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta,
                                    $precioTotalDesde, $precioPendienteDesde, $estadoLaqueado, $nombreOParte){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID=PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=PEC.CLIENTE_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="  LEFT JOIN REMITOS_LAQUEADO_DETALLE RLD ON PED.PEDIDO_DETALLE_ID=RLD.PEDIDO_DETALLE_ID  \n";
         $sql.="  LEFT JOIN REMITOS_LAQUEADO_CABECERA RLC ON RLD.REMITO_LAQUEADO_CAB_ID = RLC.REMITO_LAQUEADO_CAB_ID  \n";
         $sql.="  LEFT JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID = LAQ.LAQUEADOR_ID \n";
         $sql.="WHERE     \n";
         $sql.="  PEC.HABILITADO=1          \n";
         if (!empty($clienteId)){
           $sql.="AND PEC.CLIENTE_ID='" . $clienteId . "'    \n";
         }
         if (!empty($piezaId)){
           $sql.="AND PED.PIEZA_ID='" . $piezaId . "'   \n";
         }
         if (!empty($estado)){
           $sql.="AND PEC.PEDIDO_ESTADO='" . $estado . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND PEC.PEDIDO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PEC.PEDIDO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }
         if (!empty($precioTotalDesde)){
         	$sql.="  AND PRECIO_TOTAL >=" .  $precioTotalDesde .   " \n";
         }
         if (!empty($precioPendienteDesde)){
         	$sql.="  AND PRECIO_PENDIENTE >=" .  $precioPendienteDesde .   " \n";
         }
         if (!empty($estadoLaqueado)){
         	$sql.="  AND RLC.ESTADO ='" .  $estadoLaqueado .   "' \n";
         }
         if (!empty($nombreOParte)){
         	$sql.="  AND UPPER(PIE.PIEZA_NOMBRE) LIKE '%" . mb_strtoupper($nombreOParte, 'utf-8')   . "%'  \n";
         }
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }

      public function selUnidadesPendientesPlano($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta,
                                    $precioTotalDesde, $precioPendienteDesde, $estadoLaqueado, $nombreOParte){
         $conexion=$this->conectarse();
         $sql="SELECT SUM(PEDIDO_CANTIDAD-PEDIDO_REMITIDOS) \n";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID=PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=PEC.CLIENTE_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="  LEFT JOIN REMITOS_LAQUEADO_DETALLE RLD ON PED.PEDIDO_DETALLE_ID=RLD.PEDIDO_DETALLE_ID  \n";
         $sql.="  LEFT JOIN REMITOS_LAQUEADO_CABECERA RLC ON RLD.REMITO_LAQUEADO_CAB_ID = RLC.REMITO_LAQUEADO_CAB_ID  \n";
         $sql.="  LEFT JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID = LAQ.LAQUEADOR_ID \n";
         $sql.="WHERE    1=1 \n";
         if (!empty($clienteId)){
           $sql.="AND PEC.CLIENTE_ID='" . $clienteId . "'    \n";
         }
         if (!empty($piezaId)){
           $sql.="AND PED.PIEZA_ID='" . $piezaId . "'   \n";
         }
         if (!empty($estado)){
           $sql.="AND PEC.PEDIDO_ESTADO='" . $estado . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND PEC.PEDIDO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PEC.PEDIDO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }
         if (!empty($precioTotalDesde)){
         	$sql.="  AND PRECIO_TOTAL >=" .  $precioTotalDesde .   " \n";
         }
         if (!empty($precioPendienteDesde)){
         	$sql.="  AND PRECIO_PENDIENTE >=" .  $precioPendienteDesde .   " \n";
         }
         if (!empty($estadoLaqueado)){
         	$sql.="  AND RLC.ESTADO ='" .  $estadoLaqueado .   "' \n";
         }
         if (!empty($nombreOParte)){
         	$sql.="  AND UPPER(PIE.PIEZA_NOMBRE) LIKE '%" . mb_strtoupper($nombreOParte, 'utf-8')   . "%'  \n";
         }
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $total=null;
         $stm->bind_result($total);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $total;
      }


      public function selTodosCuenta($pedidoCabeceraId){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*)   ";
         $sql.="FROM  \n";
         $sql.="  PEDIDOS_DETALLE  PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID  \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="WHERE 1=1   \n";
         if (!empty($pedidoCabeceraId)){
         	$sql.="  AND PED.PEDIDO_CABECERA_ID='" .$pedidoCabeceraId . "' \n";
         }
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }


      public function selItemsPendientes($desde, $cuantos, $sort, $dir, $clienteId){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  PED.PEDIDO_DETALLE_ID,  \n";
         $sql.="  PEC.PEDIDO_FECHA,   \n";
         $sql.="  PED.PEDIDO_CANTIDAD,   \n";
         $sql.="  PED.PEDIDO_REMITIDOS,   \n";
         $sql.="  PED.PIEZA_ID,   \n";
         $sql.="  PIE.PIEZA_NOMBRE,   \n";
         $sql.="  PEC.PEDIDO_NUMERO,   \n";
         $sql.="  PED.TERMINACION_ID,   \n";
         $sql.="  TER.TERMINACION_NOMBRE   \n";
         $sql.="FROM   \n";
         $sql.="  PEDIDOS_DETALLE PED   \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID   \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID   \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="WHERE    \n";
         $sql.="  PEC.HABILITADO=1   \n";
         $sql.="  AND PEC.PEDIDO_ESTADO='Pendiente'   \n";
         $sql.="  AND PEC.CLIENTE_ID='" . $clienteId  .  "'   \n";
         $sql.="ORDER BY   \n";
         if ($sort=="pedidoFecha"){
           $sql.="  PEC.PEDIDO_FECHA  " . $dir . "  \n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $pedidoDetalleId=null;
         $pedidoFecha=null;
         $cantidad=null;
         $remitidos=null;
         $piezaId=null;
         $piezaNombre=null;
         $pedidoNumero=null;
         $terminacionId=null;
         $terminacionNombre=null;
         $stm->bind_result($pedidoDetalleId, $pedidoFecha, $cantidad, $remitidos, $piezaId, $piezaNombre, $pedidoNumero, $terminacionId, $terminacionNombre);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new PedidoPendiente();
            $bean->setDetalleId($pedidoDetalleId);
            $bean->setPedidoFechaLarga($pedidoFecha);
            $bean->setCantidad($cantidad);
            $bean->setRemitidos($remitidos);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPedidoNumero($pedidoNumero);
            $bean->setTerminacionId($terminacionId);
            $bean->setTerminacionNombre($terminacionNombre);
            $filas[]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selItemsPendientesCuenta($clienteId){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) \n";
         $sql.="FROM   \n";
         $sql.="  PEDIDOS_DETALLE PED   \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID   \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID   \n";
         $sql.="  LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID  \n";
         $sql.="WHERE    \n";
         $sql.="  PEC.HABILITADO=1   \n";
         $sql.="  AND PEC.PEDIDO_ESTADO='Pendiente'   \n";
         $sql.="  AND PEC.CLIENTE_ID='" . $clienteId  .  "'   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }


      public function unidadesPendientesPorFicha($cuantas){
         $conexion=$this->conectarse();
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD - PED.PEDIDO_REMITIDOS) AS UNIDADES_PENDIENTES,  \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED   \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID  \n";
         $sql.="WHERE \n";
         $sql.="  PEC.HABILITADO=1   \n";
         $sql.="  AND PEC.PEDIDO_ESTADO='Pendiente'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  UNIDADES_PENDIENTES DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  . "         \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $ficha=null;
         $unidadesPendientes=null;
         $stm->bind_result($unidadesPendientes, $ficha);
         $filas = array();
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["ficha"]=$ficha;
         	$fila["unidadesPendientes"]=$unidadesPendientes;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function montosPendientePorFicha($cuantas){
         $conexion=$this->conectarse();
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD - PED.PEDIDO_REMITIDOS) * PED.PEDIDO_DETALLE_PRECIO AS MONTO_PENDIENTE,  \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED   \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID  \n";
         $sql.="WHERE \n";
         $sql.="  PEC.HABILITADO=1   \n";
         $sql.="  AND PEC.PEDIDO_ESTADO='Pendiente'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  UNIDADES_PENDIENTES DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  . "         \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $ficha=null;
         $unidadesPendientes=null;
         $stm->bind_result($unidadesPendientes, $ficha);
         $filas = array();
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["ficha"]=$ficha;
         	$fila["montoPendiente"]=$unidadesPendientes;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function maximoPrecio($clienteId, $piezaId){
         $conexion=$this->conectarse();
         $sql="SELECT   \n";
         $sql.="  MAX(PED.PEDIDO_DETALLE_PRECIO) AS PRECIO_MAXIMO  \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED   \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON  PEC.PEDIDO_CABECERA_ID=PED.PEDIDO_CABECERA_ID   \n";
         $sql.="WHERE \n";
         $sql.="  PEC.HABILITADO=1   \n";
         $sql.="  AND PED.PIEZA_ID='" . $piezaId . "'   \n";
         $sql.="  AND PEC.CLIENTE_ID='" . $clienteId . "'   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $max=null;
         $stm->bind_result($max);
         $res=0;
         if ($stm->fetch()) {
         	$res=$max;
         }
         $this->cierra($conexion, $stm);
         return $res;
      }


      /**
       * selecciona todos los artículos alguna vez pedidos por ese cliente
       * (u, opcionalmente, desde una fecha determinada). Esta función es útil para
       * confeccionar listas de precios desde cero para un cliente
       */
      public function selTodosArticulos($clienteId, $fechaDesde){
         $conexion=$this->conectarse();
         $sql="SELECT DISTINCT \n";
         $sql.="  PED.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE     \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED   \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID  \n";
         $sql.="WHERE \n";
         $sql.="  PEC.HABILITADO=1   \n";
         $sql.="  AND PEC.CLIENTE_ID='" . $clienteId . "'   \n";
         if (!empty($fechaDesde)){
         	$sql.="  AND PEC.PEDIDO_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $piezaId=null;
         $piezaNombre=null;
         $stm->bind_result($piezaId, $piezaNombre);
         $filas = array();
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["piezaId"]=$piezaId;
         	$fila["piezaNombre"]=$piezaNombre;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      /**
       * reporte agregado de las unidades pendientes por línea, al día de la fecha
       */
      public function reportePendientesPorLinea(){
        $conexion=$this->conectarse();
        $sql="SELECT  \n";
        $sql.="  LINEA_ID, \n";
        $sql.="  LINEA_DESCRIPCION, \n";
        $sql.="  SUM(CANTIDAD) AS 'CANTIDAD PENDIENTE' \n";
        $sql.="FROM   \n";
        $sql.="  VW_PENDIENTES_CHAPA_TERM \n";
        $sql.="GROUP BY  \n";
        $sql.="  LINEA_ID,  \n";
        $sql.="  LINEA_DESCRIPCION  \n";
        $sql.="ORDER BY \n";
        $sql.="  SUM(CANTIDAD) DESC  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $lineaId=null;
         $lineaDescripcion=null;
         $cantidadPendiente=null;
         $stm->bind_result($lineaId, $lineaDescripcion, $cantidadPendiente);
         $filas = array();
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["lineaId"]=$lineaId;
         	$fila["lineaDescripcion"]=$lineaDescripcion;
         	$fila["cantidadPendiente"]=$cantidadPendiente;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function reporteTerminacionesPendientes(){
        $conexion=$this->conectarse();
        $sql="SELECT  \n";
        $sql.="  SUM(CANTIDAD * CANTIDAD_CHAPAS) AS CANTIDAD, \n";
        $sql.="  TERMINACION, \n";
        $sql.="  MEDIDA_CHAPAS \n";
        $sql.="FROM   \n";
        $sql.="  VW_PENDIENTES_CHAPA_TERM \n";
        $sql.="GROUP BY  \n";
        $sql.="  TERMINACION,  \n";
        $sql.="  MEDIDA_CHAPAS  \n";
        $sql.="ORDER BY  \n";
        $sql.="  MEDIDA_CHAPAS  \n";
        $stm=$this->preparar($conexion, $sql);
        $stm->execute();
        $cantidad=null;
        $terminacion=null;
        $medidas=null;
        $stm->bind_result($cantidad, $terminacion, $medidas);
        $filas = array();
        while ($stm->fetch()) {
         	$fila=array();
         	$fila["cantidad"]=$cantidad;
         	$fila["terminacion"]=$terminacion;
         	$fila["medidas"]=$medidas;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      /**
       * igual que el reporteTerminacionesPendientes, pero agregando la orientación
       */
      public function reporteDetalladoTerminacionesPendientes(){
        $conexion=$this->conectarse();
        $sql="SELECT  \n";
        $sql.="  SUM(CANTIDAD * CANTIDAD_CHAPAS) AS CANTIDAD, \n";
        $sql.="  TERMINACION, \n";
        $sql.="  MEDIDA_CHAPAS, \n";
        $sql.="  ORIENTACION_CHAPAS \n";
        $sql.="FROM   \n";
        $sql.="  VW_PENDIENTES_CHAPA_TERM \n";
        $sql.="GROUP BY  \n";
        $sql.="  TERMINACION,  \n";
        $sql.="  MEDIDA_CHAPAS,  \n";
        $sql.="  ORIENTACION_CHAPAS  \n";
        $sql.="ORDER BY  \n";
        $sql.="  MEDIDA_CHAPAS,  \n";
        $sql.="  ORIENTACION_CHAPAS  \n";
        $stm=$this->preparar($conexion, $sql);
        $stm->execute();
        $cantidad=null;
        $terminacion=null;
        $medidas=null;
        $orientacion=null;
        $stm->bind_result($cantidad, $terminacion, $medidas, $orientacion);
        $filas = array();
        while ($stm->fetch()) {
         	$fila=array();
         	$fila["cantidad"]=$cantidad;
         	$fila["terminacion"]=$terminacion;
         	$fila["medidas"]=$medidas;
         	$fila["orientacion"]=$orientacion;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      /**
       * devuelve un array asociativo con el nombre de la terminación como clave y la cantidad
       * de unidades pendientes de cada uno, en los pedidos (sin estar discriminada por chaoa).
       * Con parámetro, toma (obligatoriamente) la línea de productos
       */
      public function terminacionesTotalesPorLinea($lineaId){
        $conexion=$this->conectarse();

        $sql="SELECT  \n";
        $sql.="   LINEA_ID,    \n";
        $sql.="   LINEA_DESCRIPCION,    \n";
        $sql.="   TERMINACION,  \n";
        $sql.="   SUM(CANTIDAD) AS UNIDADES    \n";
        $sql.="FROM       \n";
        $sql.="  VW_PENDIENTES_CHAPA_TERM     \n";
        $sql.="WHERE       \n";
        $sql.="  LINEA_ID='" . $lineaId  .  "'      \n";
        $sql.="GROUP BY                 \n";
        $sql.="   LINEA_ID,             \n";
        $sql.="   LINEA_DESCRIPCION,    \n";
        $sql.="   TERMINACION           \n";
        $stm=$this->preparar($conexion, $sql);
        $stm->execute();
        $lineaId=null;
        $lineaDescripcion=null;
        $terminacion=null;
        $chapa=null;
        $unidades=null;
        $stm->bind_result($lineaId, $lineaDescripcion, $terminacion, $unidades);
        $filas = array();
        while ($stm->fetch()) {
       	  $fila=array();
       	  $fila["lineaId"]=$lineaId;
       	  $fila["lineaDescripcion"]=$lineaDescripcion;
       	  $fila["terminacion"]=$terminacion;
       	  $fila["unidades"]=$unidades;
          $filas[]=$fila;
        }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      /**
       * devuelve un array asociativo con el nombre de la terminación como clave, y la chapa usada y la cantidad
       * de unidades pendientes de cada uno, en los pedidos,
       * Con parámetro, devuelve sólo los valores de una línea de productos
       */
      public function terminacionesPorLinea($lineaId){
        $conexion=$this->conectarse();

        $sql="SELECT  \n";
        $sql.="   LINEA_ID,    \n";
        $sql.="   LINEA_DESCRIPCION,    \n";
        $sql.="   TERMINACION,  \n";
        $sql.="   CANTIDAD_CHAPAS,  \n";
        $sql.="   MEDIDA_CHAPAS,  \n";
        $sql.="   ORIENTACION_CHAPAS,  \n";
        $sql.="   CANTIDAD     \n";
        $sql.="FROM       \n";
        $sql.="  VW_PENDIENTES_CHAPA_TERM     \n";
        $sql.="WHERE       \n";
        $sql.="  1=1     \n";
        if (!empty($lineaId)){
          $sql.="  AND LINEA_ID='" . $lineaId  .  "'      \n";
        }
        $stm=$this->preparar($conexion, $sql);
        $stm->execute();
        $lineaId=null;
        $lineaDescripcion=null;
        $terminacion=null;
        $cantidadChapas=null;
        $medidaChapas=null;
        $orientacionChapas=null;
        $unidades=null;
        $stm->bind_result($lineaId, $lineaDescripcion, $terminacion, $cantidadChapas, $medidaChapas, $orientacionChapas, $unidades);
        $filas = array();
        while ($stm->fetch()) {
       	  $fila=array();
       	  $fila["lineaId"]=$lineaId;
       	  $fila["lineaDescripcion"]=$lineaDescripcion;
       	  $fila["terminacion"]=$terminacion;
       	  $fila["cantidadChapas"]=$cantidadChapas;
       	  $fila["medidaChapas"]=$medidaChapas;
       	  $fila["orientacionChapas"]=$orientacionChapas;
          $filas[]=$fila;
        }
         $this->cierra($conexion, $stm);
         return $filas;
      }


   }
?>