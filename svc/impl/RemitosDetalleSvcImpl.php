<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/RemitosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosCabeceraOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/RemitosDetalleSvc.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PedidosCabeceraSvcImpl.php';
//require_once('FirePHPCore/fb.php');

   class RemitosDetalleSvcImpl implements RemitosDetalleSvc { 
      private $oad=null; 
      private $oadPedidosDet=null;
      private $svcPedidosCab=null;

      function __construct(){ 
         $this->oad=new RemitosDetalleOadImpl();   
         $this->oadPedidosDet=new PedidosDetalleOadImpl();
         $this->svcPedidosCab=new PedidosCabeceraSvcImpl();
         
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene($id); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $exito = $this->oad->inserta($bean);
         if ($exito['success']){
         	//actualizo también la columna de 'remitidos' del pedido
         	$beanPedidoDet=$this->oadPedidosDet->obtiene($bean->getPedidoDetalleId());
         	$beanPedidoDet->setRemitidos($beanPedidoDet->getRemitidos() + $bean->getCantidad());
         	$exito = $this->oadPedidosDet->actualiza($beanPedidoDet);
         	$this->svcPedidosCab->verificaEstado($beanPedidoDet->getCabeceraId());
         } 
         return $exito;
      } 


      public function actualiza($bean){ 
        $beanAnterior = $this->oad->obtiene($bean->getId());
        $diferencia=$bean->getCantidad() - $beanAnterior->getCantidad();
      	$beanPedidoDet=$this->oadPedidosDet->obtiene($bean->getPedidoDetalleId());
      	$beanPedidoDet->setRemitidos($beanPedidoDet->getRemitidos() + $diferencia);
      	$exito = $this->oadPedidosDet->actualiza($beanPedidoDet);
      	$this->svcPedidosCab->verificaEstado($beanPedidoDet->getCabeceraId());
        if ($exito['success']){
          return $this->oad->actualiza($bean);
        }
      } 
      


      public function borra($id){ 
      	 $bean = $this->oad->obtiene($id);
      	 $beanPedidoDet=$this->oadPedidosDet->obtiene($bean->getPedidoDetalleId());
         $beanPedidoDet->setRemitidos($beanPedidoDet->getRemitidos() - $bean->getCantidad());
         $exito = $this->oadPedidosDet->actualiza($beanPedidoDet);
         $this->svcPedidosCab->verificaEstado($beanPedidoDet->getCabeceraId());
         if ($exito['success']){
           return $this->oad->borra($id);
         } 
      } 


      public function selTodos($desde, $cuantos, $remitoCabeceraId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $remitoCabeceraId); 
         return $arr; 
      } 


      public function selTodosCuenta($remitoCabeceraId){ 
         $cantidad=$this->oad->selTodosCuenta($remitoCabeceraId); 
         return $cantidad; 
      } 
      
      public function selRemitosRelacionados($pedidoDetalleId){
         $cantidad=$this->oad->selRemitosRelacionados($pedidoDetalleId); 
         return $cantidad; 
      }
      

   }
?>