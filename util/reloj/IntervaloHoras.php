<?php
//  require_once('FirePHPCore/fb.php');
  class IntervaloHoras {

    public $cadenaInicial;
    public $cadenaFinal;
    private $horaInicial=null;
    private $horaFinal=null;
    
    
    function __construct($cadenaInicial, $cadenaFinal){
      $this->cadenaInicial=$cadenaInicial;
      $this->cadenaFinal=$cadenaFinal;
    }
    
    
    /**
     * convierte ambos miembros en dateTime, dada una cadena de día
     */
    function convierteADateTime($cadenaDia){
      $this->horaInicial=FechaUtils::cadenaAObjeto($cadenaDia . ' ' . $this->cadenaInicial);
      $this->horaFinal=FechaUtils::cadenaAObjeto($cadenaDia . ' ' . $this->cadenaFinal);
//      echo "ahora la hora inicial es  " . $this->horaInicial->format("Y-m-d H:i"); 
    }
    
    
    public function obtieneHoraInicial(){
      return $this->horaInicial;
    }
    
    public function obtieneHoraFinal(){
      return $this->horaFinal;
    }    
    
    public function aCadena(){
    	$cadena='Inicial=' . $this->obtieneHoraInicial() . ' final=' . $this->obtieneHoraFinal() . " \n"; 
    	return $cadena;
    }
      
    
  }
  
?>
