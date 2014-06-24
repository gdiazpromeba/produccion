<?php 

require_once $raiz  . 'oad/impl/AlertasMailOadImpl.php'; 
require_once $raiz  . 'svc/AlertasMailSvc.php'; 


   class AlertasMailSvcImpl implements AlertasMailSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new AlertasMailOadImpl();   
      } 

      public function selLaqueadosNoAsignados(){ 
         $arr=$this->oad->selLaqueadosNoAsignados(); 
         return $arr;
      } 
      
      public function selPaquetesNoEnviados(){
          $arr=$this->oad->selPaquetesNoEnviados(); 
          return $arr;
      } 
      
      public function selPaquetesNoLaqueados(){
          $arr=$this->oad->selPaquetesNoLaqueados(); 
          return $arr;
      } 
      
      public function selPendientesPasadosPrometida(){
          $arr=$this->oad->selPendientesPasadosPrometida(); 
          return $arr;
      } 
      
      


   }
?>