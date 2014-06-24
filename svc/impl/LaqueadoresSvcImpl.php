<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/LaqueadoresOadImpl.php';
//require_once('FirePHPCore/fb.php');

   class LaqueadoresSvcImpl {

      function __construct(){
         $this->aod=new LaqueadoresOadImpl();
      }


      public function selTodos($desde, $cuantos){
      	return $this->aod->selTodos($desde, $cuantos);
      }

      public function selTodosCuenta(){
      	return $this->aod->selTodosCuenta();
      }


   }
?>