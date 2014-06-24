<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FacturasCabeceraOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FacturasDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/FacturasCabeceraSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FacturaCabecera.php';

   class FacturasCabeceraSvcImpl implements FacturasCabeceraSvc {
      private $oad=null;
      private $oadDet=null;

      function __construct(){
         $this->oad=new FacturasCabeceraOadImpl();
         $this->oadDet=new FacturasDetalleOadImpl();
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


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito){
         $arr=$this->oad->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito);
         return $arr;
      }


      public function selTodosCuenta($clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito){
         $cantidad=$this->oad->selTodosCuenta($clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito);
         return $cantidad;
      }
      
      public function selSubtotalGeneral($clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito){
      	$total=$this->oad->selSubtotalGeneral($clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito);
      	return $total;
      }

      public function selReporteFactura($facturaCabeceraId){
         $arr=$this->oad->selReporteFactura($facturaCabeceraId);
         return $arr;
      }

      public function calculaTotal($factutaCabeceraId, $descuento){
		$bean=new FacturaCabecera();
		$subtotal=$this->oadDet->subtotal($factutaCabeceraId);
		$ivaInscripto= $subtotal * 0.21;
//		fb('$subtotal + $ivaInscripto', $subtotal + $ivaInscripto);
//		fb('(1 - ($descuento / 100))', 1 - ($descuento / 100));
		$fraccionDescuento= 1.0 - ($descuento / 100.0);
		$totalFactura= ($subtotal + $ivaInscripto) * $fraccionDescuento;
		$bean->setSubtotal( $subtotal);
		$bean->setIvaInscripto($ivaInscripto);
		$bean->setTotal($totalFactura);
		return $bean;
      }
      
      /**
       * Anula una factura
      */
      public function anulaFactura($facturaCabeceraId){
      	$fac=$this->oad->obtiene($facturaCabeceraId);
      	$fac->setEstado('Inválida');
      	$exito=$this->oad->actualiza($fac);
      	if (!$exito['success']){
      	  return $exito;
        }
      }

   }
?>