<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/RemitosCabeceraOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/RemitosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosCabeceraOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/RemitosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/RemitosCabeceraSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FacturasCabeceraOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FacturasDetalleOadImpl.php';
//require_once('FirePHPCore/fb.php');

   class RemitosCabeceraSvcImpl implements RemitosCabeceraSvc {
      private $oad=null;
      private $oadDet=null;
      private $oadPed=null;
      private $oadPedDet=null;
      private $oadFac=null;
      private $oadFacDet=null;
      private $oadRemDet=null;



      function __construct(){
         $this->oad=new RemitosCabeceraOadImpl();
         $this->oadDet=new RemitosDetalleOadImpl();
         $this->oadPed=new PedidosCabeceraOadImpl();
         $this->oadPedDet=new PedidosDetalleOadImpl();
         $this->oadFac=new FacturasCabeceraOadImpl();
         $this->oadFacDet=new FacturasDetalleOadImpl();
         $this->oadRemDet=new RemitosDetalleOadImpl();
      }

      public function obtiene($id){
         $bean=$this->oad->obtiene($id);
         return $bean;
      }


      public function inserta($bean){
         return $this->oad->inserta($bean);
      }


      public function actualiza($bean){
         return $this->oad->actualiza($bean);
      }


      public function borra($id){
         return $this->oad->borra($id);
      }


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta, $numero){
         $arr=$this->oad->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
         return $arr;
      }


      public function selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta, $numero){
         $cantidad=$this->oad->selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
         return $cantidad;
      }

      public function selReporteRemito($remitoCabeceraId){
         $arr=$this->oad->selReporteRemito($remitoCabeceraId);
         return $arr;
      }


      /**
       * Genera automáticamente una factura, basándose en un remito
      */
      public function generaFactura($remitoCabeceraId){
      	//obtengo la cabecera de remito correspondiente
      	$beanRemCab=$this->oad->obtiene($remitoCabeceraId);

      	//comienzo a poblar la cabecera de la factura
      	$beanFacCab = new FacturaCabecera();
      	$beanFacCab->setClienteId($beanRemCab->getClienteId());
      	$beanFacCab->setRemitoNUmero($beanRemCab->getNumero());
      	$numero=$this->oadFac->getMaxNumero() + 1;
      	$beanFacCab->setNumero($numero);
      	$beanFacCab->setFecha(new DateTime("now"));
      	$beanFacCab->setSubtotal(0);
      	$beanFacCab->setTotal(0);
      	$beanFacCab->setTipo("A");
      	$beanFacCab->setEstado("Válida");
      	$exito=$this->oadFac->inserta($beanFacCab);
      	if (!empty($exito['errors'])){
      		echo "problema al insertar factura=" . $exito['errors'] . "\n";
      		return;
      	}


      	//pueblo el detalle de la factura
      	$arrItems=$this->oadRemDet->selParaFacturas($remitoCabeceraId);
      	$total=0;
      	foreach($arrItems as $item){
      	  $beanFacDet=new FacturaDetalle();
      	  $beanFacDet->setFacturaCabeceraId($beanFacCab->getId());
      	  $beanFacDet->setPiezaId($item['piezaId']);
      	  $beanFacDet->setPiezaNombre($item['piezaNombre']);
      	  $beanFacDet->setCantidad($item['cantidad']);
      	  $beanFacDet->setPrecioUnitario($item['precio']);
      	  $importe=$item['cantidad'] * $item['precio'];
      	  $beanFacDet->setImporte($importe);
      	  $beanFacDet->setReferenciaPedido($item['referenciaPedido']);
      	  
      	  $exito=$this->oadFacDet->inserta($beanFacDet);
      	  if (!empty($exito['errors'])){
      	    echo "problema al insertar detalles de la factura generada=" . $exito['errors'] . "\n";
      		return;
      	  }
      	  $total+=$importe;
      	}
      	$beanFacCab->setSubtotal($total);
      	$exito=$this->oadFac->actualiza($beanFacCab);
      	if (!empty($exito['errors'])){
      	    echo "problema en la actualización final de la factura=" . $exito['errors'] . "\n";
      		return;
      	}
      	return $exito;
      }

      /**
       * Anula un remito ya escrito, con las consecuencias adecuadas en los pedidos.
      */
      public function anulaRemito($remitoCabeceraId){
      	//primero, modifica la cabecera del remito, marcándolo como "anulado"
      	$remito=$this->oad->obtiene($remitoCabeceraId);
      	$remito->setEstado('Anulado');
      	$exito=$this->oad->actualiza($remito);
      	if (!$exito['success']){
      	  return $exito;
      }

      	//obtiene todos los hijos. A cada pedido relacionado, le decremento la cantidad remitida, y a la
      	//cabecera de pedido correspondiente la marco como "Pendiente"
      	$detalles=$this->oadDet->selTodos(0, 1000, $remitoCabeceraId);
      	foreach($detalles as $detRemito){
      	  $pedidoDetalleId=$detRemito->getPedidoDetalleId();
      	  $pedidoDetalle=$this->oadPedDet->obtiene($pedidoDetalleId);
      	  $pedidoDetalle->setRemitidos($pedidoDetalle->getRemitidos() - $detRemito->getCantidad());
      	  $exito=$this->oadPedDet->actualiza($pedidoDetalle);
      	  if (!$exito['success']){
      	    return $exito;
      	  }
      	  $pedidoCabecera=$this->oadPed->obtiene($pedidoDetalle->getCabeceraId());
      	  $pedidoCabecera->setEstado('Pendiente');
      	  $exito=$this->oadPed->actualiza($pedidoCabecera);
      	  if (!$exito['success']){
      	    return $exito;
      	  }
      	}

      	$exito=array();
      	$exito['success']=true;
      	return $exito;

      }

   }
?>