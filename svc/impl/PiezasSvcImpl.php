<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PiezasOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/AtributosOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/AtributosValorPorPiezaOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/AtributoValorPorPieza.php';
//require_once('FirePHPCore/fb.php');

   class PiezasSvcImpl { 

      function __construct(){ 
         $this->aod=new PiezasOadImpl();   
         $this->atributosOad=new AtributosOadImpl();
         $this->avpp=new AtributosValorPorPiezaOadImpl();
      }

      public function obtiene($id){ 
         $bean=$this->aod->obtiene($id); 
         $atris=$this->atributosOad->selValorAtributosPieza($bean->getId());
         $bean->setAtributos($atris);         
         return $bean; 
      } 


      public function inserta($bean){ 
         $exitoFinal=array();
         $exito = $this->aod->inserta($bean);
	     if ($exito['success']==false){
	     	$exitoFinal['success']=false;
	     	$exitoFinal['errors']=$exito['errors'];
	     	return $exitoFinal;
	     }         
         $this->avpp->borra($bean->getId());
         if ($bean->getAtributos()!=null){
           $arrAtris=explode("|", $bean->getAtributos());
           foreach ($arrAtris as $atri){
           	 $items=explode("~", $atri);
           	 $avpp=new AtributoValorPorPieza();
           	 $avpp->setAtributoValorId($items[2]);
           	 $avpp->setPiezaId($bean->getId());
           	 $exito=$this->avpp->inserta($avpp);
             if ($exito['success']==false){
	     	   $exitoFinal['success']=false;
	     	   $exitoFinal['errors']=$exito['errors'];
	     	   return $exitoFinal;
	         }         
           }
         }
         $exitoFinal['success']=true;
         return $exitoFinal;
      } 


      public function actualiza($bean){ 
         $exitoFinal=array();
         $exito = $this->aod->actualiza($bean);
	     if ($exito['success']==false){
	     	$exitoFinal['success']=false;
	     	$exitoFinal['errors']=$exito['errors'];
	     	return $exitoFinal;
	     }         
         $this->avpp->borra($bean->getId());
         if ($bean->getAtributos()!=null){
           $arrAtris=explode("|", $bean->getAtributos());
           foreach ($arrAtris as $atri){
           	 $items=explode("~", $atri);
           	 $avpp=new AtributoValorPorPieza();
           	 $avpp->setAtributoValorId($items[2]);
           	 $avpp->setPiezaId($bean->getId());
           	 $exito=$this->avpp->inserta($avpp);
             if ($exito['success']==false){
	     	   $exitoFinal['success']=false;
	     	   $exitoFinal['errors']=$exito['errors'];
	     	   return $exitoFinal;
	         }         
           }
         }
         $exitoFinal['success']=true;
         return $exitoFinal;      	
      } 


      public function borra($id){
         $exitoFinal=array();
         $exito=$this->avpp->borra($id);
         if ($exito['success']==false){
           $exitoFinal['success']=false;
     	   $exitoFinal['errors']=$exito['errors'];
     	   return $exitoFinal;
	     }         
         $exito = $this->aod->borra($id);
	     if ($exito['success']==false){
	     	$exitoFinal['success']=false;
	     	$exitoFinal['errors']=$exito['errors'];
	     	return $exitoFinal;
	     }         
         $exitoFinal['success']=true;
         return $exitoFinal;         
      } 
      
      public function inhabilita($id){ 
         return $this->aod->inhabilita($id); 
      }      


     /**
      *si el parámetro $valoresAtributo existe, lo proceso y envío una cadena con los id de valores de atributo, 
      *ya entrecomillados y separados por comas
      */
     private function procesoValoresAtributo($valoresAtributo){
      	 $sc='';
      	 if ($valoresAtributo!=null){
      	 	$filas=explode('|', $valoresAtributo);
      	 	foreach($filas as $fila){
      	 		$items=explode('~', $fila);
      	 		$sc.=", '" . $items[2] . "' ";
      	 	}
      	 	return substr($sc, 1);
      	 }else{
      	   return null;
      	 }
            	
     }


      public function selTodos($desde, $cuantos, $piezaFicha, $codigoOParte, $piezaGenericaId, $valoresAtributo){ 
      	 $valoresAtributo=$this->procesoValoresAtributo($valoresAtributo);
         $arr=$this->aod->selTodos($desde, $cuantos, $piezaFicha, $codigoOParte, $piezaGenericaId, $valoresAtributo);
         foreach ($arr as &$bean){
         	$atris=$this->atributosOad->selValorAtributosPieza($bean->getId());
         	$bean->setAtributos($atris);
         };
         return $arr; 
      } 


      public function selTodosCuenta($nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo){ 
         $valoresAtributo=$this->procesoValoresAtributo($valoresAtributo);
         $cantidad=$this->aod->selTodosCuenta($nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo); 
         return $cantidad; 
      } 
      
      public function selPorComienzo($desde, $cuantos, $cadena){
      	return $this->aod->selPorComienzo($desde, $cuantos, $cadena);
      } 
      
      public function selPorComienzoCuenta($cadena){
      	return $this->aod->selPorComienzoCuenta($cadena);
      }       
      
      public function obtieneUltimoPrecio($piezaId, $clienteId){
      	
      }
      
      public function selAtributosValor($piezaId){
        $arr=$this->atributosOad->selValorAtributosPieza(0, 10000, $piezaId);
        return $arr;
     }   
     
      public function agregaValoresAtributo($piezaId, $arrIdsValores){
        foreach($arrIdsValores as $idValor){
          $bean = new AtributoValorPorPieza();
          $bean->setAtributoValorId($idValor);
          $bean->setPiezaId($piezaId);
          $this->avpp->inserta($bean);  
        }           
      }
      
   
     
   }
?>