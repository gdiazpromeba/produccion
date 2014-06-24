<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/TiposPataOadImpl.php';
//require_once('FirePHPCore/fb.php');

   class TiposPataSvcImpl {

      function __construct(){
         $this->aod=new TiposPataOadImpl();
      }


      public function selTodos($desde, $cuantos){
      	return $this->aod->selTodos($desde, $cuantos);
      }

      public function selTodosCuenta(){
      	return $this->aod->selTodosCuenta();
      }
      
      public function reportePendientes(){
      	return $this->aod->reportePendientes();
      }


   }
?>