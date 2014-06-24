<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/RemitosLaqueadoOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/RemitosLaqueadoSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/RemitoLaqueadoCabecera.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/RemitoLaqueadoDetalle.php';
//require_once('FirePHPCore/fb.php');

   class RemitosLaqueadoSvcImpl implements RemitosLaqueadoSvc {
      private $oad=null;

      function __construct(){
         $this->oad=new RemitosLaqueadoOadImpl();
      }

      public function selPedidosNoAsignados($desde, $cuantos){
         $arr=$this->oad->selPedidosNoAsignados($desde, $cuantos);
         return $arr;
      }


      public function selPedidosNoAsignadosCuenta(){
         $cantidad=$this->oad->selPedidosNoAsignadosCuenta();
         return $cantidad;
      }

      public function genera($data){
      	$cab=new RemitoLaqueadoCabecera();
	$cab->setLaqueadorId($data->laqueador->id);
	$cab->setFechaEnvioLarga(FechaUtils::ahoraLarga());
	$exitoInsercionCabecera = $this->oad->insertaCabecera($cab);
	$dets = $data->items;
	$i=0;
	foreach ($dets as $item){
	      $det=new RemitoLaqueadoDetalle();
	      $det->setCabeceraId($exitoInsercionCabecera['nuevoId']);
	      $det->setPedidoDetalleId($item->pedidoDetalleId);
	      $det->setItem(++$i);
	      $det->setCantidad($item->cantidad);
	      $exitoDetalle = $this->oad->insertaDetalle($det);
	}
	return $exitoInsercionCabecera;
      }

      public function selCabecera($desde, $cuantos,  $laqueadorId, $envioDesde, $envioHasta, $estado ){
         $arr=$this->oad->selCabecera($desde, $cuantos,  $laqueadorId, $envioDesde, $envioHasta,  $estado);
         return $arr;
      }

      public function selCabeceraCuenta($laqueadorId, $envioDesde, $envioHasta,  $estado ){
         $cantidad=$this->oad->selCabeceraCuenta($laqueadorId, $envioDesde, $envioHasta, $estado);
         return $cantidad;
      }
      
      public function selDetalles($desde, $cuantos,  $cabeceraId){
       $arr=$this->oad->selDetalles($desde, $cuantos,  $cabeceraId);
       return $arr;
      }
      
      public function selDetallesCuenta($cabeceraId){
         $cantidad=$this->oad->selDetallesCuenta($cabeceraId);
         return $cantidad;
      }
      

      public function borraRemCab($id){
        $ret=$this->oad->borraCabecera($id);
        return $ret;
      }

      public function remiteRemCab($id){
        $bean=$this->oad->obtiene($id);
        $bean->setEstado('En Laqueador');
        $bean->setFechaEnvioLarga(FechaUtils::ahoraLarga());
        $ret=$this->oad->modificaCabecera($bean);
        return $ret;
      }
      
      public function completaRemCab($id){
        $bean=$this->oad->obtiene($id);
        $bean->setEstado('Laqueado');
        $ret=$this->oad->modificaCabecera($bean);
        return $ret;
      }      

      public function imprimeRemLaq($id){
        $cabecera=$this->oad->obtiene($id);
        $detalles=$this->oad->selDetalles(0, 100, $id);
        $rep=array();
        $rep['laqueadorNombre']=$cabecera->getLaqueadorNombre();
        $rep['numero']=$cabecera->getNumero();
        $rep['fechaEnvio']=$cabecera->getFechaEnvioCorta();
        $items=array();
        foreach($detalles as $det){
          $it=array();
          $it['item']=$det->getItem();
          $it['cantidad']=$det->getCantidad();
          $it['clienteNombre']=$det->getClienteNombre();
          $it['piezaNombre']=$det->getPiezaNombre();
          $it['terminacionNombre']=$det->getTerminacionNombre();
          $items[]=$it;
        }
        $rep['detalles']=$items;
        return $rep;
      }



   }
   
   
   
   
?>