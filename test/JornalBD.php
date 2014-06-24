<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Cliente.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pieza.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Deposito.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Movimiento.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ClientesOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PiezasOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/UsuariosOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/DepositosOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/MovimientosOadImpl.php';

   //Oads
   $piOad=new PiezasOadImpl();
   $cliOad=new ClientesOadImpl();
   $depOad=new DepositosOadImpl();
   $usuOad=new UsuariosOadImpl();
   $movOad=new MovimientosOadImpl();
   
   
   //un bean de cada cosa accesoria
   $piBean=array_pop($piOad->selTodos(0,1));
   $cliBean=array_pop($cliOad->selTodos(0,1));
   $depBean=array_pop($depOad->selTodos(0,1));
   $usuBean=array_pop($usuOad->selTodos(0,1));
   
   //insercion
   for ($año=1990; $año<2000; $año++){ 
   	 for ($mes=1; $mes<=12; $mes++) { 
		 $movBean=new Movimiento();
		 $movBean->setPiezaId($piBean->getId());
		 $movBean->setClienteId($cliBean->getId());
		 $movBean->setDepositoId($depBean->getId());
		 $movBean->setCantidad(1);
		 $movBean->setUsuarioId($usuBean->getId());
		 $dt=new DateTime();
		 $dt->setDate($año, $mes, 1);
		 $movBean->setMomento($dt->format('Y-m-d H:i:s'));
		 $movOad->inserta($movBean);
   	 }
   }
   
   
   echo "fin del test";
   
      

?>
