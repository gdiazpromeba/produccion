<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php'; 
//require_once('FirePHPCore/fb.php');



  class AnalisisLecturasDiarias {
    private $dia=null;
    private $valido=null;
    private $razonInvalido=null;
    private $lecturas=null;
    private $lecturasCorregidas=array();
    private $llegoTarde=false;
    private $salioTemprano=false;

    /*
     * Un array ordenado de objetos "IntervaloHoras", que definen el horario
     * esperado de la persona en cuestión
     */
    private $horasPermitidas=array();
    private $tolerancia;
    private $alarmas=array();
    private $minutosReales=null;
    private $minutosSegunHorario=null;
    
    /**
     * el día es una representación string del día en formato 'Y-m-d'
     * la tolerancia es en minutos (un int), 
     * las horas permitidas es un array de objetos string con la representación horaria
     */
    function __construct($dia, $arrLecturas, $intervalos, $tolerancia){
//      $this->firephp = FirePHP::getInstance(true);
      $this->dia=$dia;
      $this->lecturas=$arrLecturas;
//      echo 'intervalos ' . print_r($intervalos) . '<br>';
      /**
       * creo los intervalos de horario en formato DateTime
       */
       foreach($intervalos as $intervalo){
         $intervalo->convierteADateTime($dia);
         array_push($this->horasPermitidas, $intervalo);
       }
      $this->tolerancia=$tolerancia;
      
      $this->tolerancia=$tolerancia;

//      $this->revisaTolerancia();

      $this->cadenaLecturas='';
      foreach($arrLecturas as $lectura){
        $this->cadenaLecturas.=$lectura->format('H:i') . ' ';
      }
      
      if(count($arrLecturas)==0){
        $valido=false;
        $this->razonInvalido='No hay lecturas';
        return;
      }       
      
      
      if(count($arrLecturas)%2!=0){
        $valido=false;
        $this->razonInvalido='N&uacute;mero impar de lecturas: ' . count($arrLecturas);
        return;
      }      
      

      $this->corrigeHoras();
      $this->minutosReales=$this->minutosTrabajados($this->lecturas);
      $this->minutosSegunHorario=$this->minutosTrabajados($this->lecturasCorregidas);
      $this->revisaTolerancia();
      $this->valido=true;  
    }
    
    
    /**
     * calcula el período total del tiempo trabajado según las unas lecturas horarias dadas.
     * Debe haber un número par de lecturas
     * Devuelve un objeto DateInterval con horas y minutos
     */
    private function minutosTrabajados($lecturas){
      $acumulador=0;
      for ($i=0; $i < count($lecturas);  $i+=2 ){
        $comienzo=$lecturas[$i];
    	$fin=$lecturas[$i+1];
    	$enMinutos= FechaUtils::diferenciaEnMinutos($fin, $comienzo);
    	$acumulador+=$enMinutos;
      }
      return $acumulador;
    }
    
    private function intervaloAMinutos($intervalo){
      $cadenaHora=$intervalo->format("%H:%I");
      $segmentos=explode(":", $cadenaHora);
      $horas=intval($segmentos[0]);
      $minutos= intval($segmentos[1]);
      $total= $minutos  +  $horas * 60;
      return $total;
    }
    
    /**
     * devuelve un array de lecturas "corregidas" según el horario de la persona
     * al llegar a esta función, se supone que los períodos ya han sido convertidos en DateTime, con el día en cuestión
     */
    private function corrigeHoras(){
    	//hago una copia del array original
    	foreach($this->lecturas as $lectura){
    	  $this->lecturasCorregidas[]=$lectura;
    	}
   	
    	//comienzo a modificar el array
    	//regla nro 1: si la primera lectura es menor que la hora de comienzo de su horario, se toma la hora de comienzo del horario
    	$primeraLectura=$this->lecturasCorregidas[0];
//    	$this->firephp->dump('hora inicial antes de asignar', $this->horasPermitidas[0].horaInicial);
//    	echo 'antes de asignar, la hora Inicial es ' . $this->horasPermitidas[0].horaInicial->format('Y-m-d H:i');
    	$var1=$this->horasPermitidas[0];
    	$primeraEsperada=$var1->obtieneHoraInicial();
    	if ($primeraLectura<$primeraEsperada){
    	  $this->lecturasCorregidas[0]=$primeraEsperada;
    	}
    	
    	//regla nro 2: si la última lectura es mayor que la hora de finalización de su horario, se toma la hora de finalización del horario
    	$ultimaLectura=$this->lecturasCorregidas[count($this->lecturasCorregidas)-1];
    	$ultimoPeriodo=$this->horasPermitidas[count($this->horasPermitidas)-1];
    	$ultimaEsperada=$ultimoPeriodo->obtieneHoraFinal();
    	if ($ultimaLectura>$ultimaEsperada){
    	  $this->lecturasCorregidas[count($this->lecturasCorregidas)-1]=$ultimaEsperada;
    	}
    	
    }
    
    
    /**
     * revisa el array de lecturas, y verifica si alguna de ellas está fuera de un rango de 
     * todas las horas permitidas (considerando los minutos de tolerancia).
     * Si alguna lo está, agrega un mensaje a 'alarmas'
     */
    private function revisaTolerancia(){
      foreach($this->lecturas as $lectura){
        $dentroDeAlgunRango=false;
        foreach($this->horasPermitidas as $hito){
          $minutos=FechaUtils::diferenciaEnMinutos($hito->obtieneHoraInicial(), $lectura);
          if ($minutos<=$this->tolerancia){
            $dentroDeAlgunRango=true;
            break;
          }
          $minutos=FechaUtils::diferenciaEnMinutos($hito->obtieneHoraFinal(), $lectura);
          if ($minutos<=$this->tolerancia){
            $dentroDeAlgunRango=true;
            break;
          }
          
        }
        if (!$dentroDeAlgunRango){
          array_push($this->alarmas, 'La lectura ' . $lectura->format('H:i') . ' no est&aacute; dentro de un rango permmitido');    
        }
      }
    } 
    
    public function esValido(){
      return $this->valido;
    }
    
    public function obtieneRazonInvalido(){
      return $this->razonInvalido;
    }    
    
    public function tieneAlarmas(){
      return count($this->alarmas)>0;
    }

    public function obtieneAlarmas(){
      return $this->alarmas;
    }
    
    public function horasReales(){
      //no sé por qué mierda hay que hacer esto (devolver una cadena para el valor).
      //si no lo hago, el valor aparece corrupto, por ejemplo, un '=' en lugar de la parte entera 
      $horas=$this->minutosReales / 60.0;
      $entero=intval($horas);
      $decimal=round($horas, 2)-$entero;
      $decimal=substr($decimal, 2);
      return $entero . '.' . $decimal;
    }
    
    public function horasSegunHorario(){
            //no sé por qué mierda hay que hacer esto (devolver una cadena para el valor).
      //si no lo hago, el valor aparece corrupto, por ejemplo, un '=' en lugar de la parte entera 
      $horas=$this->minutosSegunHorario / 60.0;
      $entero=intval($horas);
      $decimal=round($horas, 2)-$entero;
      $decimal=substr($decimal, 2);
      return $entero . '.' . $decimal;
    }
    
    public function obtieneDia(){
      return $this->dia;
    }
    
    public function obtieneCadenaLecturas(){
      return $this->cadenaLecturas;
    }
    
    
    
    
    
  }

?>
