<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/EstadisticasOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');
 

   class EstadisticasOadImpl extends AOD implements EstadisticasOad { 
   	
      public function setFormato($conexion){
         $sql="SET lc_time_names = 'es_AR'; \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
      }       	
      
      
      public function precios($piezaId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse();
         $this->setFormato($conexion); 
         $sql="SELECT  \n";
         $sql.="  YEAR(LIP.EFECTIVO_DESDE) AS AÑO, \n";
         $sql.="  MONTH(LIP.EFECTIVO_DESDE) AS MES, \n";
         $sql.="  MAX(LIP.PRECIO) AS PRECIO     \n";
         $sql.="FROM  \n";
		 $sql.="  LISTA_PRECIOS LIP  \n";
         $sql.="WHERE   \n";
         $sql.="  DATE(LIP.EFECTIVO_DESDE) BETWEEN DATE('" . FechaUtils::dateTimeACadena($fechaDesde) . "') AND DATE('" . FechaUtils::dateTimeACadena($fechaHasta) . "')  \n";
         $sql.="  AND PIEZA_ID='" . $piezaId . "'  \n";
         $sql.="GROUP BY      \n";
         $sql.="  YEAR(LIP.EFECTIVO_DESDE), \n";
         $sql.="  MONTH(LIP.EFECTIVO_DESDE) \n";
         $sql.="ORDER BY      \n";
         $sql.="  YEAR(LIP.EFECTIVO_DESDE), \n";
         $sql.="  MONTH(LIP.EFECTIVO_DESDE) \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $mes=null;  
         $totalFacturado=null;  
         $stm->bind_result($año, $mes, $precio); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["año"]=$año;
         	$fila["mes"]=$mes;
         	$fila["precio"]=$precio;
            $filas[]=$fila; 
         }
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       
    
      public function montosFacturacion($fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse();
         $this->setFormato($conexion); 
         $sql="SELECT  \n";
         $sql.="  YEAR(FAC.FACTURA_FECHA) AS AÑO, \n";
         $sql.="  MONTH(FAC.FACTURA_FECHA) AS MES, \n";
         $sql.="  SUM(FAC.FACTURA_SUBTOTAL) AS TOTAL_FACTURADO     \n";
         $sql.="FROM  \n";
		 $sql.="  FACTURAS_CABECERA FAC   \n";
         $sql.="WHERE   \n";
         $sql.="  DATE(FAC.FACTURA_FECHA) BETWEEN DATE('" . FechaUtils::dateTimeACadena($fechaDesde) . "') AND DATE('" . FechaUtils::dateTimeACadena($fechaHasta) . "')  \n";
         $sql.="  AND FACTURA_ESTADO='Válida'  \n";
         $sql.="  AND NOTA_CREDITO=0  \n";
         $sql.="GROUP BY      \n";
         $sql.="  YEAR(FAC.FACTURA_FECHA), \n";
         $sql.="  MONTH(FAC.FACTURA_FECHA) \n";
         $sql.="ORDER BY      \n";
         $sql.="  YEAR(FAC.FACTURA_FECHA), \n";
         $sql.="  MONTH(FAC.FACTURA_FECHA) \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $mes=null;  
         $totalFacturado=null;  
         $stm->bind_result($año, $mes, $totalFacturado); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["año"]=$año;
         	$fila["mes"]=$mes;
         	$fila["monto"]=$totalFacturado;
            $filas[]=$fila; 
         }
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 

      
      public function montosNC($fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse();
         $this->setFormato($conexion); 
         $sql="SELECT  \n";
         $sql.="  YEAR(FAC.FACTURA_FECHA) AS AÑO, \n";
         $sql.="  MONTH(FAC.FACTURA_FECHA) AS MES, \n";
         $sql.="  SUM(FAC.FACTURA_SUBTOTAL) AS TOTAL_FACTURADO     \n";
         $sql.="FROM  \n";
		 $sql.="  FACTURAS_CABECERA FAC   \n";
         $sql.="WHERE   \n";
         $sql.="  DATE(FAC.FACTURA_FECHA) BETWEEN DATE('" . FechaUtils::dateTimeACadena($fechaDesde) . "') AND DATE('" . FechaUtils::dateTimeACadena($fechaHasta) . "')  \n";
         $sql.="  AND FACTURA_ESTADO='Válida'  \n";
         $sql.="  AND NOTA_CREDITO=1  \n";
         $sql.="GROUP BY      \n";
         $sql.="  AÑO, \n";
         $sql.="  MES \n";
         $sql.="ORDER BY      \n";
         $sql.="  AÑO, \n";
         $sql.="  MES \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $mes=null;  
         $totalFacturado=null;  
         $stm->bind_result($año, $mes, $totalFacturado); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["año"]=$año;
         	$fila["mes"]=$mes;
         	$fila["monto"]=$totalFacturado;
            $filas[]=$fila; 
         }
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      

      public function indicesInflacion($fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse();
         $this->setFormato($conexion);
         $mesDesde= FechaUtils::mes($fechaDesde);
         $añoDesde= FechaUtils::año($fechaDesde);
         $mesHasta= FechaUtils::mes($fechaHasta);
         $añoHasta= FechaUtils::año($fechaHasta);
         $sql="SELECT  \n";
         $sql.="  AÑO, \n";
         $sql.="  MES, \n";
         $sql.="  CANASTA_BASICA_PRIVADA \n";
         $sql.="FROM  \n";
		 $sql.="  INFLACION   \n";
         $sql.="WHERE   \n";
         $sql.="  (AÑO > " . $añoDesde . " \n";
         $sql.="   OR (AÑO = " . $añoDesde      .  " AND MES >=   " . $mesDesde  . "))  \n";
         $sql.="  AND \n";
         $sql.="  (AÑO < " . $añoHasta . " \n";
         $sql.="   OR (AÑO = " . $añoHasta      .  " AND MES <=   " . $mesHasta  . "))  \n";
         $sql.="ORDER BY      \n";
         $sql.="  AÑO, \n";
         $sql.="  MES \n";
         
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $mes=null;  
         $totalFacturado=null;  
         $stm->bind_result($año, $mes, $variacion); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["año"]=$año;
         	$fila["mes"]=$mes;
         	$fila["variacion"]=$variacion;
            $filas[]=$fila; 
         }
         $this->cierra($conexion, $stm); 
         return $filas; 
      }        
      
      public function montosPedidos($fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse();
         $this->setFormato($conexion); 
         $sql="SELECT  \n";
         $sql.="  CONCAT(YEAR(PEC.PEDIDO_FECHA), ' ', LPAD(MONTH(PEC.PEDIDO_FECHA),2, '0')) AS MES, \n";
         $sql.="  SUM(PED.pedido_cantidad * PED.PEDIDO_DETALLE_PRECIO) AS TOTAL_PEDIDO     \n";
         $sql.="FROM  \n";
		 $sql.="  PEDIDOS_DETALLE PED   \n";
		 $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID  \n";
         $sql.="WHERE   \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'  \n";
         $sql.="GROUP BY      \n";
         $sql.="  MES \n";
         $sql.="ORDER BY      \n";
         $sql.="  MES \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $mes=null;  
         $totalPedido=null;  
         $stm->bind_result($mes, $totalPedido); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["mes"]=$mes;
         	$fila["montoPedido"]=$totalPedido;
            $filas[]=$fila; 
         }
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
  
      public function montosRemitidos($fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  YEAR(REC.REMITO_FECHA) AS AÑO,  \n";
         $sql.="  MONTH(REC.REMITO_FECHA) AS MES,  \n";
         $sql.="  SUM(RED.REMITO_ITEM_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO) AS TOTAL_REMITIDO \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID=RED.REMITO_CABECERA_ID \n";
         $sql.="WHERE \n";
         $sql.="  DATE(REC.REMITO_FECHA) BETWEEN DATE('" . FechaUtils::dateTimeACadena($fechaDesde) . "') AND DATE('" . FechaUtils::dateTimeACadena($fechaHasta) . "')   \n";
         $sql.="GROUP BY      \n";
         $sql.="  YEAR(REC.REMITO_FECHA), \n";
         $sql.="  MONTH(REC.REMITO_FECHA) \n";
         $sql.="ORDER BY      \n";
         $sql.="  YEAR(REC.REMITO_FECHA), \n";
         $sql.="  MONTH(REC.REMITO_FECHA) \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();
         $año=null;  
         $mes=null;  
         $monto=null;  
         $stm->bind_result($año, $mes, $monto); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["año"]=$año;
         	$fila["mes"]=$mes;
         	$fila["monto"]=$monto;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      
      
    
      public function unidadesFichasPedidasEnPeriodo($fechaDesde, $fechaHasta, $fichas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD ) AS UNIDADES_PEDIDAS, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="WHERE \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="  AND PIE.PIEZA_FICHA IN (" . $fichas . ")  \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  UNIDADES_PEDIDAS DESC         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $unidadesPedidas=null;  
         $stm->bind_result($unidadesPedidas, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["ficha"]=$ficha;
         	$fila["unidadesPedidas"]=$unidadesPedidas;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }   
      
      public function unidadesFichasRemitidasEnPeriodo($fechaDesde, $fechaHasta, $fichas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( RED.REMITO_ITEM_CANTIDAD ) AS UNIDADES_REMITIDAS, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID = RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="WHERE \n";
         $sql.="  REC.REMITO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="  AND PIE.PIEZA_FICHA IN (" . $fichas . ")   \n";         
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  UNIDADES_REMITIDAS DESC         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $unidadesRemitidas=null;  
         $stm->bind_result($unidadesRemitidas, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["ficha"]=$ficha;
         	$fila["unidadesRemitidas"]=$unidadesRemitidas;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function mejoresFichasRemitidasEnUnidades($fechaDesde, $fechaHasta, $cuantas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( RED.REMITO_ITEM_CANTIDAD ) AS UNIDADES_REMITIDAS, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID = RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="WHERE \n";
         $sql.="  REC.REMITO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  UNIDADES_REMITIDAS DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  .  "         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $unidadesRemitidas=null;  
         $stm->bind_result($unidadesRemitidas, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
            $filas[]=$ficha; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }     
      
      public function mejoresFichasPedidasEnUnidades($fechaDesde, $fechaHasta, $cuantas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD ) AS UNIDADES_PEDIDAS, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="WHERE \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  UNIDADES_PEDIDAS DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  .  "         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $unidadesPedidas=null;  
         $stm->bind_result($unidadesPedidas, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
            $filas[]=$ficha; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }  
      
      public function mejoresFichasRemitidasEnMonto($fechaDesde, $fechaHasta, $cuantas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( RED.REMITO_ITEM_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO ) AS MONTO_REMITIDO, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID = RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="WHERE \n";
         $sql.="  REC.REMITO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_REMITIDO DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  .  "         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $montoRemitido =null;  
         $stm->bind_result($montoRemitido, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
            $filas[]=$ficha; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }     
      
      public function mejoresFichasPedidasEnMonto($fechaDesde, $fechaHasta, $cuantas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO) AS MONTO_PEDIDO, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID    \n";
         $sql.="WHERE \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_PEDIDO DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  .  "         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $montoPedido=null;  
         $stm->bind_result($montoPedido, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
            $filas[]=$ficha; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      
      
      public function montoFichasPedidasEnPeriodo($fechaDesde, $fechaHasta, $fichas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO) AS MONTO_PEDIDO, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="WHERE \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="  AND PIE.PIEZA_FICHA IN (" . $fichas . ")  \n";
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_PEDIDO DESC         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $montoPedido=null;  
         $stm->bind_result($montoPedido, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["ficha"]=$ficha;
         	$fila["montoPedido"]= $montoPedido;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }   
      
      public function montoFichasRemitidasEnPeriodo($fechaDesde, $fechaHasta, $fichas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( RED.REMITO_ITEM_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO ) AS MONTO_REMITIDO, \n";
         $sql.="  PIE.PIEZA_FICHA \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID = RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID = PIE.PIEZA_ID \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="WHERE \n";
         $sql.="  REC.REMITO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="  AND PIE.PIEZA_FICHA IN (" . $fichas . ")   \n";         
         $sql.="GROUP BY  \n";
         $sql.="  PIE.PIEZA_FICHA         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_REMITIDO DESC         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $ficha=null;  
         $montoRemitido=null;  
         $stm->bind_result($montoRemitido, $ficha); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["ficha"]=$ficha;
         	$fila["montoRemitido"]=$montoRemitido;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }    
      
      public function mejoresClientesRemitidosEnMonto($fechaDesde, $fechaHasta, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( RED.REMITO_ITEM_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO ) AS MONTO_REMITIDO, \n";
         $sql.="  CLI.CLIENTE_NOMBRE \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID = RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN CLIENTES CLI ON REC.CLIENTE_ID = CLI.CLIENTE_ID \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="WHERE \n";
         $sql.="  REC.REMITO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  CLI.CLIENTE_NOMBRE         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_REMITIDO DESC         \n";
         $sql.="LIMIT 0, " . $cuantos  .  "         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteNombre=null;  
         $montoRemitido =null;  
         $stm->bind_result($montoRemitido, $clienteNombre); 
         $filas = array(); 
         while ($stm->fetch()) {
            $filas[]=$clienteNombre; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }    
      
      public function mejoresClientesPedidosEnMonto($fechaDesde, $fechaHasta, $cuantas){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO) AS MONTO_PEDIDO, \n";
         $sql.="  CLI.CLIENTE_NOMBRE \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID = CLI.CLIENTE_ID    \n";
         $sql.="WHERE \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="GROUP BY  \n";
         $sql.="  CLI.CLIENTE_NOMBRE         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_PEDIDO DESC         \n";
         $sql.="LIMIT 0, " . $cuantas  .  "         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteNombre=null;  
         $montoPedido=null;  
         $stm->bind_result($montoPedido, $clienteNombre); 
         $filas = array(); 
         while ($stm->fetch()) {
            $filas[]=$clienteNombre; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }            
      
      public function montoClientesPedidosEnPeriodo($fechaDesde, $fechaHasta, $clientes){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( PED.PEDIDO_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO) AS MONTO_PEDIDO, \n";
         $sql.="  CLI.CLIENTE_NOMBRE \n";
         $sql.="FROM \n";
         $sql.="  PEDIDOS_DETALLE PED \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PEC.PEDIDO_CABECERA_ID = PED.PEDIDO_CABECERA_ID \n";
         $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID = CLI.CLIENTE_ID \n";
         $sql.="WHERE \n";
         $sql.="  PEC.PEDIDO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="  AND CLI.CLIENTE_NOMBRE IN (" . $clientes . ")  \n";
         $sql.="GROUP BY  \n";
         $sql.="  CLI.CLIENTE_NOMBRE         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_PEDIDO DESC         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteNombre=null;  
         $montoPedido=null;  
         $stm->bind_result($montoPedido, $clienteNombre); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["clienteNombre"]=$clienteNombre;
         	$fila["montoPedido"]= $montoPedido;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       
      
      public function montoClientesRemitidosEnPeriodo($fechaDesde, $fechaHasta, $clientes){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT   \n";
         $sql.="  SUM( RED.REMITO_ITEM_CANTIDAD * PED.PEDIDO_DETALLE_PRECIO ) AS MONTO_REMITIDO, \n";
         $sql.="  CLI.CLIENTE_NOMBRE \n";
         $sql.="FROM \n";
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID = RED.REMITO_CABECERA_ID \n";
         $sql.="  INNER JOIN CLIENTES CLI ON REC.CLIENTE_ID = CLI.CLIENTE_ID \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID \n";
         $sql.="WHERE \n";
         $sql.="  REC.REMITO_FECHA BETWEEN '" . FechaUtils::dateTimeACadena($fechaDesde) . "' AND '" . FechaUtils::dateTimeACadena($fechaHasta) . "'   \n";
         $sql.="  AND CLI.CLIENTE_NOMBRE IN (" . $clientes . ")   \n";         
         $sql.="GROUP BY  \n";
         $sql.="  CLI.CLIENTE_NOMBRE         \n";
         $sql.="ORDER BY  \n";
         $sql.="  MONTO_REMITIDO DESC         \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $clienteNombre=null;  
         $montoRemitido=null;  
         $stm->bind_result($montoRemitido, $clienteNombre); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila["clienteNombre"]=$clienteNombre;
         	$fila["montoRemitido"]=$montoRemitido;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }
      
                                       
  
   }   
   
    
?>