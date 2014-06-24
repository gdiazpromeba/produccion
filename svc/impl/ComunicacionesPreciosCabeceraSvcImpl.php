<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ComunicacionesPreciosCabeceraOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/ComunicacionesPreciosCabeceraSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ComunicacionesPreciosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PedidosDetalleOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/ComunicacionesPreciosDetalleSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PreciosEfectivosActualesSvcImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ComunicacionPreciosDetalle.php';
//require_once('FirePHPCore/fb.php');

   class ComunicacionesPreciosCabeceraSvcImpl implements ComunicacionesPreciosCabeceraSvc {
      private $oad=null;
      private $oadDet=null;

      function __construct(){
         $this->oad=new ComunicacionesPreciosCabeceraOadImpl();
         $this->oadDet=new ComunicacionesPreciosDetalleOadImpl();
         $this->oadPed=new PedidosDetalleOadImpl();
         $this->peaSvc=new PreciosEfectivosActualesSvcImpl();
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


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta){
         $arr=$this->oad->selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta);
         return $arr;
      }


      public function selTodosCuenta($clienteId, $fechaDesde, $fechaHasta){
         $cantidad=$this->oad->selTodosCuenta($clienteId, $fechaDesde, $fechaHasta);
         return $cantidad;
      }

      /**
       * Duplica una comunicación con sus detalles, con la fecha cambiada y los precios variados, e
       * inserta todo en la BD.
       * La fecha es un objeto DateTime.
       * La variación es un porcentaje (que puede ser positivo o negativo)
       */
      public function duplica($comPrecCabId, $nuevaFecha, $variacion){
        $cab=$this->oad->obtiene($comPrecCabId);
        $dets=$this->oadDet->selTodos(0, 10000, $comPrecCabId);
        $res=array();
        $cab->setFecha($nuevaFecha);
        $resCab=$this->oad->inserta($cab);
        if ($resCab['success']){
          foreach ($dets as $det){
          	$precio=$det->getPrecio() * (100 + $variacion) / 100;
          	$idCab=$cab->getId();
          	$det->setPrecio($precio);
          	$det->setComPrecCabId($idCab);
            $resDet=$this->oadDet->inserta($det);
            if (!$resDet['success']){
              $res['success']=false;
              $res['errors']='Error insertando un detalle';
              break;
            }
          }
          if (!isset($res['success'])){
            $res['success']=true;
          }
        }else{
          $res['success']=false;
          $res['errors']='Error insertando la cabecera';
        }
        return $res;
      }

      /**
       * crea una lista de precios a partir de los pedidos de un determinado cliente, y la inserta
       * en la base de datos, con la variación ya calculada respecto de dichos precios.
       */
      public function creaDePedidos($clienteId, $comPrecCabId, $fechaDesde){
		$arr=$this->oadPed->selTodosArticulos($clienteId, $fechaDesde);
		//modifica el array, agregándole más campos
		$res=array();
		//modifica el array, agregándole más campos
		$res=array();
		foreach ($arr as $fila){
		  $piezaId=$fila['piezaId'];
		  $piezaNombre=$fila['piezaNombre'];
		  $precio=$this->peaSvc->obtienePrecio($clienteId, $piezaId);
		  if (empty($precio)){
		  	$precio=$this->oadPed->maximoPrecio($clienteId, $piezaId);
		  }
		  //e inserta como detalle de comunicaciones
		  $bean=new ComunicacionPreciosDetalle();
		  $bean->setComPrecCabId($comPrecCabId);
		  $bean->setPiezaId($fila['piezaId']);
		  $bean->setComPrecCabId($comPrecCabId);
		  $bean->setPrecio($precio);
		  $bean->setUsaGeneral(false);
		  $resDet=$this->oadDet->inserta($bean);
		  if (!$resDet['success']){
            $res['success']=false;
            $res['errors']='Error insertando un detalle: ' . $resDet['errors'];
            break;
          }
		}
        if (!isset($res['success'])){
          $res['success']=true;
        }
		return $res;
      }

   }
?>