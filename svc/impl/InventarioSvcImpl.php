<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/MovimientosOadImpl.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/InventarioOadImpl.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/InventarioAnual.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/InventarioMensual.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php'; 

  class InventarioSvcImpl { 
   	
   	  private $movOad=null;
   	  private $ianOad=null;
   	  private $imeOad=null;
   	  private $invOad=null;
   	  
   	  public function __construct(){
   	    $this->movOad=new MovimientosOadImpl();
   	    $this->ianOad=new InventarioAnualOadImpl();
   	    $this->imeOad=new InventarioMensualOadImpl();
   	    $this->invOad=new InventarioOadImpl();
   	  }
   	
      /**
       * genera un array de inventario por depósito/cliente/pieza, a partir de la tabla de movimientos,
       * empezando de una fecha determinada.
       * Esta función no debería usarse, más que para reconstruir la tabla de inventario en una emergencia
       */
      public function inventarioDesdeJornal($añoDesde, $mesDesde, $diaDesde){
		$fechaEnCadena=FechaUtils::cadena($añoDesde, $mesDesde, $diaDesde);
        $resultado=array(); //un array de arrays de depósitos-clientes-pieza-cantidades

		$arr=$this->movOad->selecciona($fechaEnCadena);

		foreach ($arr as $movBean){
			$depositoId=$movBean->getDepositoId();
			$clienteId=$movBean->getClienteId();
			$piezaId=$movBean->getPiezaId();
			$cantidad=$movBean->getCantidad();
			$resultado[$depositoId][$clienteId][$piezaId]+=$cantidad;
		}
		return $resultado;
      }
      
 
      
      /**
       * genera un array de inventario por depósito/cliente/pieza/año/mes, a partir de la tabla de movimientos,
       * empezando de un año y mes determinados.
       * Esta función no debería usarse, más que para regenerar la tabla de inventario mensual en una emergencia
       */      
      public function inventarioMensualdesdeJornal($añoDesde, $mesDesde){
        $fechaEnCadena=FechaUtils::cadena($añoDesde, $mesDesde);
        $resultado=array(); //un array de arrays de depósitos-clientes-pieza-año-mes-totalMensual
		$arr=$this->movOad->selecciona($fechaEnCadena);      	
      	
      	foreach ($arr as $mov){
      		$momento=$mov->getMomento();
      		$dtMov=FechaUtils::creaDeCadena($momento);
      		$año=FechaUtils::año($dtMov);
      		$mes=FechaUtils::mes($dtMov);
      		$depositoId=$mov->getDepositoId();
      		$clienteId=$mov->getClienteId();
      		$piezaId=$mov->getPiezaId();
      		$cantidad=$mov->getCantidad();
      		$resultado[$depositoId][$clienteId][$piezaId][$año][$mes]+=$cantidad;
      	}
		return $resultado;
      }      	
      
      /**
       * genera un array de inventario total depósito/cliente/pieza/año, a partir de la tabla de movimientos,
       * empezando de un año determinado
       * Esta función no debería usarse, más que para reconstruir la tabla de inventario anual en una emergencia
       */      
      public function inventarioAnualDesdeJornal($añoDesde){
        $fechaEnCadena=FechaUtils::cadena($añoDesde, 1);
        $resultado=array(); //un array de arrays de depósitos-clientes-pieza-año-mes-totalMensual
		$arr=$this->movOad->selecciona($fechaEnCadena);      	
      	
      	foreach ($arr as $mov){
      		$momento=$mov->getMomento();
      		$dtMov=FechaUtils::creaDeCadena($momento);
      		$año=FechaUtils::año($dtMov);
      		$depositoId=$mov->getDepositoId();
      		$clienteId=$mov->getClienteId();
      		$piezaId=$mov->getPiezaId();
      		$cantidad=$mov->getCantidad();
      		$resultado[$depositoId][$clienteId][$piezaId][$año]+=$cantidad;
      	}
		return $resultado;
      }
      
      
      
	  /**
      * regenera la tabla de inventario anual, a partir la tabla de movimientos, 
      * desde un año determinado inclusive
      */
     public function regeneraAnual($añoDesde){
     	$this->ianOad->borraDesde($añoDesde, 1);
     	$inv=$this->inventarioAnual($añoDesde);
     	
     	$depositos=array_keys($inv);
     	foreach ($depositos as $depositoId){
     		$clientes=array_keys($inv[$depositoId]);
     		foreach($clientes as $clienteId){
     	      $piezas=array_keys($inv[$depositoId][$clienteId]);
     	      foreach($piezas as $piezaId){
     	      	$años=array_keys($inv[$depositoId][$clienteId][$piezaId]);
     	      	foreach($años as $año){
				  $cantidad=$inv[$depositoId][$clienteId][$piezaId][$año];
				  $ian=new InventarioAnual();
				  $ian->setDepositoId($depositoId);
				  $ian->setClienteId($clienteId);
				  $ian->setPiezaId($piezaId);
				  $ian->setAño($año);
				  $ian->setCantidad($cantidad);
				  $this->ianOad->inserta($ian);
     	        }
     		  }
     	    }
     	  }
     }
     
	  /**
      * regenera la tabla de inventario, a partir la tabla de movimientos
      */
     public function regenera(){
     	$this->invOad->borraTodo();
     	$inv=$this->inventario(0, 0, 0);
     	$depositos=array_keys($inv);
     	foreach ($depositos as $depositoId){
     		$clientes=array_keys($inv[$depositoId]);
     		foreach($clientes as $clienteId){
     	      $piezas=array_keys($inv[$depositoId][$clienteId]);
     	      foreach($piezas as $piezaId){
				  $cantidad=$inv[$depositoId][$clienteId][$piezaId];
				  $inv=new Inventario();
				  $inv->setDepositoId($depositoId);
				  $inv->setClienteId($clienteId);
				  $inv->setPiezaId($piezaId);
				  $inv->setCantidad($cantidad);
				  $this->invOad->inserta($inv);
     	        }
     	    }
     	  }
     }	     	
     
     
	  /**
      * regenera la tabla de inventario mensual, a partir de 
      * un año y mes determinados, inclusive
      */
     public function regeneraMensual($añoDesde, $mesDesde){
     	$this->imeOad->borraDesde($añoDesde, $mesDesde);
     	$inv=$this->inventarioMensual($añoDesde, $mesDesde);
     	
     	$depositos=array_keys($inv);
     	foreach ($depositos as $depositoId){
     		$clientes=array_keys($inv[$depositoId]);
     		foreach($clientes as $clienteId){
     	      $piezas=array_keys($inv[$depositoId][$clienteId]);
     	      foreach($piezas as $piezaId){
     	      	$años=array_keys($inv[$depositoId][$clienteId][$piezaId]);
     	      	foreach($años as $año){
     	      	  $meses=array_keys($inv[$depositoId][$clienteId][$piezaId][$año]);
     	      	  foreach($meses as $mes){
					  $cantidad=$inv[$depositoId][$clienteId][$piezaId][$año][$mes];
					  $ian=new InventarioMensual();
					  $ian->setDepositoId($depositoId);
					  $ian->setClienteId($clienteId);
					  $ian->setPiezaId($piezaId);
					  $ian->setAño($año);
					  $ian->setMes($mes);
					  $ian->setCantidad($cantidad);
					  $this->imeOad->inserta($ian);
     	      	  }
     	        }
     		  }
     	    }
     	  }
     }  
     
     
     /**
      * asienta un movimiento, modificando las cantidades de pieza en los inventarios normal, mensual y anual
      */
     public function asientaMovimiento($mov){
       $piezaId=$mov->getPiezaId(); 
       $clienteId=$mov->getClienteId();
       $depositoId=$mov->getDepositoId();
       $cantidad=$mov->getCantidad(); 
       $momento=$mov->getMomento();
       
       $dt=FechaUtils::creaDeCadena($momento);
       $año=FechaUtils::año($dt);
       $mes=FechaUtils::mes($dt);
       $dia=FechaUtils::dia($dt);
       
       //esto debería ir rodeado por una transacción, pero 
       //no tengo forma práctica de hacerlo.
       $this->movOad->inserta($mov);
       $this->invOad->insertaOActualiza($depositoId, $clienteId, $piezaId, $cantidad);
       $this->ianOad->insertaOActualiza($depositoId, $clienteId, $piezaId, $año, $cantidad);
       $this->imeOad->insertaOActualiza($depositoId, $clienteId, $piezaId, $año, $mes, $cantidad);
     }    






  }	
      	
      
?>
