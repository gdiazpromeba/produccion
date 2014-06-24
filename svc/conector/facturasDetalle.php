<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/FacturasDetalleSvcImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FacturaDetalle.php';  
header("Content-Type: text/plain; charset=utf-8");  

   $url=$_SERVER['PHP_SELF']; 
   $arr=explode("/", $url);
   $ultimo=array_pop($arr);   
   $svc=new FacturasDetalleSvcImpl();   


  if ($ultimo=='selecciona'){   
  	//parametros de paginación   
  	$desde=$_REQUEST['start']; 
 	$cuantos=$_REQUEST['limit']; 
 	$sort=$_REQUEST['sort'];  
 	$dir=$_REQUEST['dir'];  
 	$facturaCabId=$_REQUEST['valorIdPadre'];
 	$beans=$svc->selTodos($desde, $cuantos, $facturaCabId); 
 	$cuenta=$svc->selTodosCuenta($facturaCabId);  
 	$datos=array();  
 	foreach ($beans as $bean){   
         $arrBean=array();  
         $arrBean['facturaDetalleId']=$bean->getId();  
         $arrBean['facturaCabId']=$bean->getFacturaCabeceraId();  
         $arrBean['cantidad']=$bean->getCantidad();  
         $arrBean['piezaId']=$bean->getPiezaId();  
         $arrBean['piezaNombre']=$bean->getPiezaNombre();  
         $arrBean['observacionesDet']=$bean->getObservacionesDet();  
         $arrBean['precioUnitario']=$bean->getPrecioUnitario();  
         $arrBean['importe']=$bean->getImporte();
		 $arrBean['referenciaPedido']=$bean->getReferenciaPedido();          
         $datos[]=$arrBean; 
 	}  
	$resultado=array();   
	$resultado['total']=$cuenta;   
	$resultado['data']=$datos;   
    echo json_encode($resultado) ;	   


   }else if ($ultimo=='obtiene'){  
     $id=$_REQUEST['id'];  
     $bean=$svc->obtiene($id);  
     $arrBean['facturaDetalleId']=$bean->getId();  
     $arrBean['facturaCabId']=$bean->getFacturaCabeceraId();  
     $arrBean['cantidad']=$bean->getCantidad();  
     $arrBean['piezaId']=$bean->getPiezaId();  
     $arrBean['piezaNombre']=$bean->getPiezaNombre();  
     $arrBean['observacionesDet']=$bean->getObservacionesDet();  
     $arrBean['precioUnitario']=$bean->getPrecioUnitario();  
     $arrBean['importe']=$bean->getImporte();  
     $arrBean['referenciaPedido']=$bean->getReferenciaPedido();
     echo json_encode($resultado) ;	   


   }else if ($ultimo=='actualiza'){  
     $bean= new FacturaDetalle();  
     $bean->setId($_REQUEST['facturaDetalleId']);
     $bean->setFacturaCabeceraId($_REQUEST['valorIdPadre']);  
     $bean->setCantidad($_REQUEST['cantidadFacDet']);  
     $bean->setPiezaId($_REQUEST['piezaIdFacDet']);  
     $bean->setObservacionesDet($_REQUEST['observacionesDet']);  
     $bean->setPrecioUnitario($_REQUEST['precioUnitario']);  
     $bean->setImporte($_REQUEST['importeFacDet']);
     $bean->setReferenciaPedido($_REQUEST['referenciaPedido']);
 	 $exito=$svc->actualiza($bean); 
	 echo json_encode($exito) ;	


   }else if ($ultimo=='inserta'){  
     $bean= new FacturaDetalle();  
     $bean->setFacturaCabeceraId($_REQUEST['formFacturasDetvalorIdPadre']);  
     $bean->setCantidad($_REQUEST['cantidadFacDet']);  
     $bean->setPiezaId($_REQUEST['piezaIdFacDet']);  
     $bean->setPiezaNombre($_REQUEST['piezaNombre']);  
     $bean->setObservacionesDet($_REQUEST['observacionesDet']);  
     $bean->setPrecioUnitario($_REQUEST['precioUnitario']);  
     $bean->setImporte($_REQUEST['importeFacDet']);  
     $bean->setReferenciaPedido($_REQUEST['referenciaPedido']);
 	 $exito=$svc->inserta($bean); 
	 echo json_encode($exito) ;	


 	} else if ($ultimo=='borra'){  
 	  $exito=$svc->borra($_REQUEST['id']); 
 	  echo json_encode($exito) ;	


 	} else if ($ultimo=='inhabilita'){  
 	  $exito=$svc->borra($_REQUEST['id']); 
 	  echo json_encode($exito) ;	
 	} 
