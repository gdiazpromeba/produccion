<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosCabeceraOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PedidosCabeceraSvc.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/ClientesSvcImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PagosSvcImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/TerminacionesSvcImpl.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Cliente.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pedido.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pago.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PedidoDetalle.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Terminacion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');


   class PedidosCabeceraSvcImpl implements PedidosCabeceraSvc { 
      private $oad=null; 
      private $oadDetalle=null;
      private $svcClientes=null;
      private $svcTerminaciones=null;
      private $svcPagos=null;

      function __construct(){ 
         $this->oad=new PedidosCabeceraOadImpl();
         $this->oadDetalle=new PedidosDetalleOadImpl();   
         $this->svcClientes=new ClientesSvcImpl();   
         $this->svcTerminaciones=new TerminacionesSvcImpl();   
         $this->svcPagos =new PagosSvcImpl();
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
      
      public function inhabilita($id){ 
         return $this->oad->inhabilita($id); 
      }       


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta); 
         return $arr; 
      } 


      public function selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta){ 
         $cantidad=$this->oad->selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta); 
         return $cantidad; 
      } 
      
      public function verificaEstado($id){
      	$beanCabecera=$this->obtiene($id);
      	if ($beanCabecera->getEstado()=='Cancelado'){
      		return;
      	}
      	$arrDet=$this->oadDetalle->selTodos(0, 1000, $id);
      	$todosCumplidos=true;
      	foreach ($arrDet as $beanDet){
      	  if ($beanDet->getCantidad()>$beanDet->getRemitidos()){
      	  	$todosCumplidos=false;
      	  	break;
      	  }
      	}
      	if ($todosCumplidos){
      	  $beanCabecera->setEstado('Completo');
        }else{
          $beanCabecera->setEstado('Pendiente');
        }
        $this->oad->actualiza($beanCabecera);
      }
      
      public function sugierePedido(){
        $max=$this->oad->maximoPedido()+1;
        return $max;                                       
      }   
      
      public function selReporteSeñas(){
      	$ret=$this->oad->selReporteSeñas();
      	return $ret;
      	 
      }
      
      public function pedidoRapido($clienteId, $clienteNombre, $email, $telefono, $piezaId, $terminacionId, $terminacionNombre, $cantidad,
        $precioUnitario, $seña, $tipoPago ){
      	
        $retFinal=array();
        $retFinal['success']=true;
        
        //cliente (ingresa u obtiene)
        $clienteBean=null;
        if (empty($clienteId)){
          $clienteBean=new Cliente();
          $clienteBean->setNombre($clienteNombre);
          $clienteBean->setTelefono($telefono);
          $clienteBean->setContactoCompras($email);
          $ret=$this->svcClientes->inserta($clienteBean);
          if (!$ret['success']){
            $retFinal['success']=false;
            $retFinal['error']='Error al crear un cliente ' .  $ret['errors'];
            return $retFinal;
          }
          $clienteId=$ret['nuevoId'];
        }else{
          $clienteBean=$this->svcClientes->obtiene($clienteId);
        }
        
        //terminacion (ingresa u obtiene)
        $terminacionBean=null;
        if (empty($terminacionId)){
          $terminacionBean=new Terminacion();
          $terminacionBean->setNombre($terminacionNombre);
          $ret=$this->svcTerminaciones->inserta($terminacionBean);
          if (!$ret['success']){
            $retFinal['success']=false;
            $retFinal['error']='error al crear una terminación ' .  $ret['errors'];
            return $retFinal;
          }
          $terminacionId=$ret['nuevoId'];
        }else{
          $terminacionBean=$this->svcTerminaciones->obtiene($terminacionId);
        }
        
        //pedido cabecera
        $cab=new Pedido();
        $cab->setClienteId($clienteId);
        $ahora= new DateTime();
        $prometida= new DateTime();
        $prometida->add(new DateInterval('P15D'));
        $cab->setFechaLarga(FechaUtils::dateTimeACadena($ahora));
        $cab->setFechaPrometidaLarga(FechaUtils::dateTimeACadena($prometida));
        $cab->setEstado('Pendiente');
        $ret=$this->oad->inserta($cab);
        if (!$ret['success']){
            $retFinal['success']=false;
            $retFinal['error']='error al crear la cabecera del pedido ' .  $ret['errors'];
            return $retFinal;
        }
        
        $cabeceraId=$ret['nuevoId'];
        
        //pedido detalle
        $det=new PedidoDetalle();
        $det->setCabeceraId($cabeceraId);
        $det->setPiezaId($piezaId);
        $det->setCantidad($cantidad);
        $det->setPrecio($precioUnitario);
        $det->setTerminacionId($terminacionId);
        $ret=$this->oadDetalle->inserta($det);
        if (!$ret['success']){
            $retFinal['success']=false;
            $retFinal['error']='error al crear el detalle del pedido ' .  $ret['errors'];
            return $retFinal;
        }
        
        //pago
        $pago = new Pago();
        $pago->setFechaLarga(FechaUtils::dateTimeACadena($ahora));
        $pago->setMonto($seña);
        $pago->setObservaciones("seña");
        $pago->setTipo($tipoPago);
        $pago->setPedidoId($cabeceraId);
        $ret=$this->svcPagos->inserta($pago);
        if (!$ret['success']){
        	$retFinal['success']=false;
        	$retFinal['error']='error al crear el pago del pedido ' .  $ret['errors'];
        	return $retFinal;
        }        
        
        return $retFinal;
        
      }
      
      
      
   }
?>