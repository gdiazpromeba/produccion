<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/DatosRelojOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/EmpleadosOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/DatosRelojSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/reloj/IntervaloHoras.php';
//require_once('FirePHPCore/fb.php');

   class DatosRelojSvcImpl implements DatosRelojSvc {
      private $oad=null;
      private $oadEmp=null;

      function __construct(){
        $this->oad=new DatosRelojOadImpl();
        $this->oadEmp=new EmpleadosOadImpl();
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


      public function cargaHoras(){
        set_time_limit(0);
        //un array de los id de los empleados, con los números de tarjetas como claves. Se usa para no andar
        //repitiendo consultas a la BD.
        $mapaEmpleados=array();
	    $handle = fopen("../../archivoHoras.txt" , "r");
		  while (!feof($handle)){
		    $data = fgets($handle);
		    if (!$data) break;
		    $arr=explode(',', $data);
			$numTar=trim($arr[0], '"');
		    $numTar=substr($numTar, strlen($numTar)-4,  strlen($numTar));
		    echo "tarjeta " . $numTar . ": ";
		    $fecha=trim($arr[2], '"');
		    $hora=trim($arr[3], '"');
		    $dt=FechaUtils::cadenaDMAYHoraAObjeto($fecha, $hora);
		    $datoReloj=new DatoReloj();
		    if (empty($mapeEmpleados[$numTar])){
		    	$empleado=$this->oadEmp->obtienePorTarjeta($numTar);
		    	$mapaEmpleados[$numTar]=$empleado->getId();
		    }
		    $datoReloj->setEmpleadoId($mapaEmpleados[$numTar]);
		    $datoReloj->setLecturaFechaHora($dt);
		    $resultado=$this->oad->inserta($datoReloj);
		    if (!$resultado['success']){
		      echo $resultado['errors'] . "<br/>";
		    }else{
		      echo "insert&oacute; OK <br/>";
		    }
		 }
      }



      public function borra($id){
         return $this->oad->borra($id);
      }


      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta){
         $arr=$this->oad->selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta);
         return $arr;
      }


      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta){
         $cantidad=$this->oad->selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta);
         return $cantidad;
      }

      public function calculaQuincena($fechaDesde, $fechaHasta, $empleadoId){
		//creo un array asociativo de 2 dimensiones: la fecha del día (como string), y
		//un array de fecha-horas como dato
      	$lecturas=$this->oad->selTodos(0, 1000, $empleadoId, $fechaDesde, $fechaHasta);

      	//echo 'lecturas del reloj=' . count($lecturas) . "<br/>";


      	$res=array();
      	foreach($lecturas as $datoReloj){
      	  $dt=$datoReloj->getLecturaFechaHora();
      	  $fecha=$dt->format('Y-m-d');
      	  if (!isset($res[$fecha])){
      	  	$res[$fecha]=array();
      	  }
      	  array_push($res[$fecha], $datoReloj->getLecturaFechaHora());
      	}


      	//echo 'días datosReloj=' . count($res) . "<br/>";

      	//ahora obtengo los períodos del horario de ese empleado, convirtiéndolos en IntervaloHoras
      	$arrPeriodos=$this->oadEmp->selHorarioActual($empleadoId);
      	$arrIntervalos=array();
      	foreach($arrPeriodos as $periodo){
      	  $arrIntervalos[]=new IntervaloHoras($periodo['periodoComienzo'], $periodo['periodoFin']);
      	}

      	//echo 'intervalos=' . count($arrIntervalos) . "<br/>";

      	//tolerancia en minutos
      	$tolerancia=10;

      	//les hago un análisis a todas las fechas de esa tarjeta
      	//y guardo el resultado en un array
      	$analisis=array();
      	foreach($res as $dia=>$lecturas){
          $al= new AnalisisLecturasDiarias($dia, $lecturas, $arrIntervalos, $tolerancia);
          $analisis[]=$al;
      	}

      	//devuelvo el array de análisis
      	return $analisis;

      }


   }
?>