<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/EstadisticasSvc.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/EstadisticasOadImpl.php';
//require_once('FirePHPCore/fb.php');

   class EstadisticasSvcImpl implements EstadisticasSvc { 
      private $oad=null; 

      function __construct(){
      	$this->oad=new EstadisticasOadImpl(); 
      } 

      public function montosPedidosYRemitidos($fechaDesde, $fechaHasta){ 
         $pedidos=$this->oad->montosPedidos($fechaDesde, $fechaHasta);
         $remitidos=$this->oad->montosRemitidos($fechaDesde, $fechaHasta);
         $res=array();
         foreach($pedidos as $key=>$value){
           $fila=array();
           $mes=$pedidos[$key]["mes"];
           //convierto la expresión año-mes en un mes con letras
           //por ejemplo, convierte el "2009 12" que viene de la BD 
           //en "dic 2009"
           $arrMes=explode(" ", $mes);
           $nombreMes=date("F", mktime(0, 0, 0, $arrMes[1], 10));
           $claveMes=substr($nombreMes, 0, 3) . " " . $arrMes[0];
           $fila["mes"]=$claveMes;
           $fila["montoPedido"]=$pedidos[$key]["montoPedido"];
           $fila["montoRemitido"]=$remitidos[$key]["montoRemitido"];
           $res[]=$fila;
         }
         return $res; 
      } 
      
      private function corrigePorInflacion(&$montos, $variaciones, $campoOrigen, $campoDestino){
      	//se asume que los montos y los períodos ya vienen ordenados cronológicamente
      	ksort($montos);
      	ksort($variaciones); 
        $acuVar=1;
      	for($i=0; $i<count($variaciones); $i++){
      		$acuVar*=(1-$variaciones[$i]['variacion'] /100);
      		$montos[$i][$campoDestino]=$montos[$i][$campoOrigen] * $acuVar;
      	}
      }
      
      /**
       * dado un array, si éste no tiene valores definidos en ciertas filas para un campo determinado, repite el valor de la fila anterior.
       * Para hacer esto, es necesario que la primera fila del array sí tenga valor definido para el campo en cuestión. 
       * @param unknown_type $montos
       * @param unknown_type $campo
       */
      private function rellenaValorAnterior(&$arr, $campo){
      	//se asume que los montos y los períodos ya vienen ordenados cronológicamente
      	for($i=1; $i<count($arr); $i++){
      		if (!isset($arr[$i][$campo])){
      		  $arr[$i][$campo]=$arr[$i-1][$campo];	
      		}
      	}
      }
      
      
      
      /**
       * crea un array bidimensional de filas, todas las cuales tienen una columna 'mes'  con el formato
       * Dicha columna es una "clave" de meses que recorre todo el rango de fechas dado, y que tiene la forma '2010 12'
       * @param $arr
       * @param $fechaDesde
       * @param $fechaHasta
       * @param $camposAdicionales
       */
      private function creaArrayAñoMes($fechaDesde, $fechaHasta){
      	$añoDesde=FechaUtils::año($fechaDesde);
      	$mesDesde=FechaUtils::mes($fechaDesde);
      	$añoHasta=FechaUtils::año($fechaHasta);
      	$mesHasta=FechaUtils::mes($fechaHasta);
      	
      	$res=array();
      	$fechaInicial=FechaUtils::objetoDeAM($añoDesde, $mesDesde);
      	$fechaFinal=FechaUtils::objetoDeAM($añoHasta, $mesHasta);
      	$fecha=$fechaInicial;
      	
      	while($fecha <= $fechaFinal){
      		$periodo=FechaUtils::año($fecha) .  ' ' . FechaUtils::mes($fecha);
			$fila=array();
			$fila['mes']=$periodo;
			$res[]=$fila;
			$fecha=FechaUtils::agregaMesesADate($fecha, 1);
      	}
      	return $res;
      }
      
      /**
       * dado un array que tiene como claves 'año', 'mes' y otras, lo convierte en una array bidimensional en el cual
       * una columna se llama 'mes' y funciona a modo de clave, con formato . Si el campo no se encuentra en el array original,
       * se agrega como nulo
       * @param unknown_type $arr
       * @param unknown_type $fechaDesde
       * @param unknown_type $fechaHasta
       * @param unknown_type $camposAPasar
       */
      private function transformaEnAM($arr, $fechaDesde, $fechaHasta, $campos){
      	$arrAm = $this->creaArrayAñoMes($fechaDesde, $fechaHasta);
      	foreach($arr as $fila){
      		$año=$fila['año'];
      		$mes=$fila['mes'];
      		$periodo=$año . ' ' . $mes;
      		foreach($arrAm as &$filaAm){
      		  if ($filaAm['mes']==$periodo){
      		  	foreach($campos as $campo){
      		  	  if (isset($fila[$campo])){
      		  	    $filaAm[$campo]=$fila[$campo];	
      		  	  }else{
      		  	  	$filaAm[$campo]=0;
      		  	  }
      		  	}
      		    break;
      		  }
      		}
      	}
      	return $arrAm;  	
      }
      
     
      public function facturacion($fechaDesde, $fechaHasta){ 
      	 $facturaciones=$this->oad->montosFacturacion($fechaDesde, $fechaHasta);
         $campos=array('monto', 'montoMenosNc', 'montoMenosInflacion');
         $facs=$this->transformaEnAM($facturaciones, $fechaDesde, $fechaHasta, $campos);
         $notasCredito=$this->oad->montosNC($fechaDesde, $fechaHasta);
         $campos=array('monto');
         $ncs=$this->transformaEnAM($notasCredito, $fechaDesde, $fechaHasta, $campos);
         $indicesInflacion=$this->oad->indicesInflacion($fechaDesde, $fechaHasta, $campos);
         $campos=array('variacion');
         $infs=$this->transformaEnAM($indicesInflacion, $fechaDesde, $fechaHasta, $campos);
         
         //ahora tengo 3 arrays bidimensionales con un juego de 'claves' año-mes completo en la columna 'mes' (tengan o no valores para
         //ese mes en particular).
         //les resto las notas de crédito a la facturación
         
         //le resto al monto de facturacíón el monto de las notas de crédito que existan para ese período 
         for ($i=0; $i<count($facs);$i++){
         	$facs[$i]['montoMenosNc']=$facs[$i]['monto'] - $ncs[$i]['monto'];
         }
		 $this->corrigePorInflacion($facs, $infs, 'montoMenosNc', 'montoMenosInflacion');
         return $facs; 
      }  
      
      public function precios($piezaId, $fechaDesde, $fechaHasta){ 
      	 $precios=$this->oad->precios($piezaId, $fechaDesde, $fechaHasta);
         $campos=array('precio', 'precioMenosInflacion');
         $precs=$this->transformaEnAM($precios, $fechaDesde, $fechaHasta, $campos);
         $indicesInflacion=$this->oad->indicesInflacion($fechaDesde, $fechaHasta, $campos);
         $campos=array('variacion');
         $infs=$this->transformaEnAM($indicesInflacion, $fechaDesde, $fechaHasta, $campos);
         $this->rellenaValorAnterior($precs, "precio");
         $this->corrigePorInflacion($precs, $infs, 'precio', 'precioMenosInflacion');
         return $precs; 
      }       

      public function remitido($fechaDesde, $fechaHasta){ 
      	 $remitidos=$this->oad->montosRemitidos($fechaDesde, $fechaHasta);
         $campos=array('monto', 'montoMenosInflacion');
         $rems=$this->transformaEnAM($remitidos, $fechaDesde, $fechaHasta, $campos);
         $indicesInflacion=$this->oad->indicesInflacion($fechaDesde, $fechaHasta, $campos);
         $campos=array('variacion');
         $infs=$this->transformaEnAM($indicesInflacion, $fechaDesde, $fechaHasta, $campos);
		 $this->corrigePorInflacion($rems, $infs, 'monto', 'montoMenosInflacion');
         return $rems; 
      }          
      
      public function mejoresFichasEnUnidades($fechaDesde, $fechaHasta, $cuantas){
      	 //no hay garantía de que las mejores "cuántas" fichas pedidas coincidan exactamente con las mejores "cuántas" ofrecidas
      	 $mejoresPedidas=$this->oad->mejoresFichasPedidasEnUnidades($fechaDesde, $fechaHasta, $cuantas);
      	 $mejoresRemitidas=$this->oad->mejoresFichasRemitidasEnUnidades($fechaDesde, $fechaHasta, $cuantas);
      	 $mejores=array_merge($mejoresPedidas, $mejoresRemitidas);
      	 $cadenaIn='';
      	 foreach($mejores as $ficha){
      	   $cadenaIn.=$ficha . ", ";
      	 }
      	 $cadenaIn=substr($cadenaIn, 0, strlen($cadenaIn)-2);
         $pedidas=$this->oad->unidadesFichasPedidasEnPeriodo($fechaDesde, $fechaHasta, $cadenaIn);
         $remitidas=$this->oad->unidadesFichasRemitidasEnPeriodo($fechaDesde, $fechaHasta, $cadenaIn);
         $res=array();
         foreach($pedidas as $key=>$value){
           $res[$value["ficha"]]["unidadesPedidas"]=$pedidas[$key]["unidadesPedidas"];
         }
         foreach($remitidas as $key=>$value){
		   $res[$value["ficha"]]["unidadesRemitidas"]=$remitidas[$key]["unidadesRemitidas"];
		 }
		 //ahora aplano ese resultado jerárquico
		 $plano=array();
		 foreach ($res as $key=>$value){
		   $fila=array();
		   $fila["ficha"]=$key;
		   if (isset($res[$key]["unidadesPedidas"])){
		     $fila["unidadesPedidas"]=$res[$key]["unidadesPedidas"];
		   }
		   if (isset($res[$key]["unidadesRemitidas"])){
		     $fila["unidadesRemitidas"]=$res[$key]["unidadesRemitidas"];
		   }
		   $plano[]=$fila;
		 }
         return $plano; 
      }
      
      public function mejoresFichasEnMonto($fechaDesde, $fechaHasta, $cuantas){
      	 //no hay garantía de que las mejores "cuántas" fichas pedidas coincidan exactamente con las mejores "cuántas" ofrecidas
      	 $mejoresPedidas=$this->oad->mejoresFichasPedidasEnMonto($fechaDesde, $fechaHasta, $cuantas);
      	 $mejoresRemitidas=$this->oad->mejoresFichasRemitidasEnMonto($fechaDesde, $fechaHasta, $cuantas);
      	 $mejores=array_merge($mejoresPedidas, $mejoresRemitidas);
      	 $cadenaIn='';
      	 foreach($mejores as $ficha){
      	   $cadenaIn.=$ficha . ", ";
      	 }
      	 $cadenaIn=substr($cadenaIn, 0, strlen($cadenaIn)-2);
         $pedidas=$this->oad->montoFichasPedidasEnPeriodo($fechaDesde, $fechaHasta, $cadenaIn);
         $remitidas=$this->oad->montoFichasRemitidasEnPeriodo($fechaDesde, $fechaHasta, $cadenaIn);
         $res=array();
         foreach($pedidas as $key=>$value){
           $res[$value["ficha"]]["montoPedido"]=$pedidas[$key]["montoPedido"];
         }
         foreach($remitidas as $key=>$value){
		   $res[$value["ficha"]]["montoRemitido"]=$remitidas[$key]["montoRemitido"];
		 }
		 //ahora aplano ese resultado jerárquico
		 $plano=array();
		 foreach ($res as $key=>$value){
		   $fila=array();
		   $fila["ficha"]=$key;
		   if (isset($res[$key]["montoPedido"])){
		     $fila["montoPedido"]=$res[$key]["montoPedido"];
		   }
		   if (isset($res[$key]["montoRemitido"])){
		     $fila["montoRemitido"]=$res[$key]["montoRemitido"];
		   }
		   $plano[]=$fila;
		 }
         return $plano; 
      }    
      
      public function mejoresClientesEnMonto($fechaDesde, $fechaHasta, $cuantos){
      	 //no hay garantía de que las mejores "cuántas" fichas pedidas coincidan exactamente con las mejores "cuántas" ofrecidas
      	 $mejoresPedidos=$this->oad->mejoresClientesPedidosEnMonto($fechaDesde, $fechaHasta, $cuantos);
      	 $mejoresRemitidos=$this->oad->mejoresClientesRemitidosEnMonto($fechaDesde, $fechaHasta, $cuantos);
      	 $mejores=array_merge($mejoresPedidos, $mejoresRemitidos);
      	 $cadenaIn='';
      	 foreach($mejores as $cliente){
      	   $cadenaIn.= "'" .  $cliente . "', ";
      	 }
      	 $cadenaIn=substr($cadenaIn, 0, strlen($cadenaIn)-2);
         $pedidas=$this->oad->montoClientesPedidosEnPeriodo($fechaDesde, $fechaHasta, $cadenaIn);
         $remitidas=$this->oad->montoClientesRemitidosEnPeriodo($fechaDesde, $fechaHasta, $cadenaIn);
         $res=array();
         foreach($pedidas as $key=>$value){
           $res[$value["clienteNombre"]]["montoPedido"]=$pedidas[$key]["montoPedido"];
         }
         foreach($remitidas as $key=>$value){
		   $res[$value["clienteNombre"]]["montoRemitido"]=$remitidas[$key]["montoRemitido"];
		 }
		 //ahora aplano ese resultado jerárquico
		 $plano=array();
		 foreach ($res as $key=>$value){
		   $fila=array();
		   $fila["clienteNombre"]=$key;
		   if (isset($res[$key]["montoPedido"])){
		     $fila["montoPedido"]=$res[$key]["montoPedido"];
		   }
		   if (isset($res[$key]["montoRemitido"])){
		     $fila["montoRemitido"]=$res[$key]["montoRemitido"];
		   }
		   $plano[]=$fila;
		 }
         return $plano; 
      }          
              
      
   }
?>