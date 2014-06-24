<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosDetalleOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PedidosDetalleSvc.php';  
//require_once('FirePHPCore/fb.php');

   class PedidosDetalleSvcImpl implements PedidosDetalleSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PedidosDetalleOadImpl();   
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


      public function borra($id){ 
         return $this->oad->borra($id); 
      } 


      public function selTodos($desde, $cuantos, $pedidoCabeceraId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $pedidoCabeceraId); 
         return $arr; 
      } 


      public function selTodosCuenta($pedidoCabeceraId){ 
         $cantidad=$this->oad->selTodosCuenta($pedidoCabeceraId); 
         return $cantidad; 
      } 
      
      public function selItemsPendientes($desde, $cuantos, $sort, $dir, $clienteId){
        return $this->oad->selItemsPendientes($desde, $cuantos, $sort, $dir, $clienteId);      	
      }
      
      public function selItemsPendientesCuenta($clienteId){
      	return $this->oad->selItemsPendientesCuenta($clienteId);
      }      
      
      public function selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte){
         $arr=$this->oad->selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte); 
         return $arr; 

      }
      
      public function selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte){
         $cantidad=$this->oad->selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte); 
		return $cantidad;   
                                                              
      } 
      
      public function selUnidadesPendientesPlano($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte){
        $unidades=$this->oad->selUnidadesPendientesPlano($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte);
        return $unidades;                                    
      }      
      
      public function unidadesPendientesPorFicha($cuantas){
        $arr=$this->oad->unidadesPendientesPorFicha($cuantas);
        return $arr; 
      }
      
      public function montosPendientePorFicha($cuantas){
        $arr=$this->oad->montosPendientePorFicha($cuantas);
        return $arr; 
      }        


      public function selReportePedido($pedidoCabeceraId){
        $arr=$this->oad->selReportePedido($pedidoCabeceraId);
        return $arr; 
      }   
      
      public function sugierePedido(){
        $max=$this->oad->maximoPedido()+1;
        return $max;                                       
      }    
      
      public function reporteDetalladoTerminacionesPendientes(){
        $arr=$this->oad->reporteDetalladoTerminacionesPendientes();
        return $arr;
      } 
      
      public function reportePendientesPorTerminacion(){
        $arr=$this->oad->reporteTerminacionesPendientes();
        $res=array();
        //obtengo un arraybidimensional, con las terminaciones no-paraíso-ni-guatambú
        //agrupadas en "Otros"
        foreach($arr as &$fila){
          $cantidad=$fila['cantidad'];
          $terminacion=$fila['terminacion'];
          $medidas=$fila['medidas'];
//          fb('cantidad=' . $cantidad . ' terminación=' . $terminacion . ' medidas=' . $medidas);
          if ($terminacion=='Guatambú' || $terminacion=='Paraíso'){
            $res[$medidas][$terminacion]+=$cantidad;
          }else{
            $res[$medidas]['otros']+=$cantidad;
          }
        }
        
        //ahora creo un array como los que se necesita para el store del gráfico
        //de barras apiladas
        $res2=array();
        $medidasClave=array_keys($res);
        foreach($medidasClave as $medidaClave){
          $fila= array();
          $guatambu=$res[$medidaClave]['Guatambú'];
          $paraiso=$res[$medidaClave]['Paraíso'];
          $otros=$res[$medidaClave]['otros'];
          
          $fila['medidas']=$medidaClave;
          $fila['guatambu']=!empty($guatambu)?$guatambu:0;
          $fila['paraiso']=!empty($paraiso)?$paraiso:0;
          $fila['otros']=!empty($otros)?$otros:0;
          $res2[]=$fila;
        }
        return $res2; 
      } 


      public function reportePendientesPorLinea(){
        $arr=$this->oad->reportePendientesPorLinea();
        foreach($arr as &$fila){
          $lineaId=$fila['lineaId'];
          $lineaDescripcion=$fila['lineaDescripcion'];
          $arrTerminaciones=$this->oad->terminacionesTotalesPorLinea($lineaId);
          $cadenaTerms='';
          foreach($arrTerminaciones as $filaTerm){
            $cadenaTerms.= $filaTerm['unidades'] . ' ' .  $filaTerm['terminacion'] . ', ';
          }
          $fila['terminaciones']=substr($cadenaTerms, 0, count($cadenaTerms)- 2);
        }
        return $arr; 
      }       
      
      public function reporteTerminacionesPorLinea(){
      	$arr=$this->oad->terminacionesPorLinea(null);
    	return $arr;
      }          
      
      
   }
?>