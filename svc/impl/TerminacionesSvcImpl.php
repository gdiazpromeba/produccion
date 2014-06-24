<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/TerminacionesOadImpl.php';
//require_once('FirePHPCore/fb.php');

   class TerminacionesSvcImpl {

      function __construct(){
         $this->aod=new TerminacionesOadImpl();
      }


      public function selPorComienzo($desde, $cuantos, $cadena){
      	return $this->aod->selPorComienzo($desde, $cuantos, $cadena);
      }

      public function selPorComienzoCuenta($cadena){
      	return $this->aod->selPorComienzoCuenta($cadena);
      }
      
      public function obtiene($terminacionId){
      	return $this->aod->obtiene($terminacionId);
      }      
      
      public function inserta($bean){
      	return $this->aod->inserta($bean);
      }      
      


   }
?>