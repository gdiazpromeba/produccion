<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanProdPulidoDetOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdPulidoDet.php';  

   class PlanProdPulidoDetOadImpl extends AOD implements PlanProdPulidoDetOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PLPR_PULIDO_DET_ID,     \n"; 
         $sql.="  PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PIEZA_FICHA,     \n"; 
         $sql.="  TERMINACION,     \n"; 
         $sql.="  REPARADA,     \n"; 
         $sql.="  TAPIZAR_MINI,     \n"; 
         $sql.="  ROTA,     \n"; 
         $sql.="  PULIDO,     \n"; 
         $sql.="  TUPI,     \n"; 
         $sql.="  CANTOS,     \n"; 
         $sql.="  LIJADO_PELOTA,     \n"; 
         $sql.="  ROTOCORT,     \n"; 
         $sql.="  TACOS,     \n"; 
         $sql.="  ESCUADRA_GARLOPA,     \n"; 
         $sql.="  OTRA,     \n"; 
         $sql.="  OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_DET  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  PLPR_PULIDO_DET_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PlanProdPulidoDet();  
         $id=null;  
         $planProdPulidoCabId=null;  
         $piezaFicha=null;  
         $terminacion=null;  
         $cantidad=null;
         $reparada=null;  
         $tapizarMini=null;  
         $rota=null;  
         $pulido=null;  
         $tupi=null;  
         $cantos=null;  
         $lijadoPelota=null;  
         $rotocort=null;  
         $tacos=null;  
         $escuadraGarlopa=null;  
         $otra=null;  
         $observaciones=null;  
         $stm->bind_result($id, $planProdPulidoCabId, $piezaFicha, $terminacion, $cantidad, 
           $reparada, $tapizarMini, $rota, $pulido, $tupi, $cantos, $lijadoPelota, $rotocort, 
           $tacos, $escuadraGarlopa, $otra, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPlanProdPulidoCabId($planProdPulidoCabId);
            $bean->setPiezaFicha($piezaFicha);
            $bean->setTerminacion($terminacion);
            $bean->setCantidad($cantidad);
            $bean->setReparada($reparada);
            $bean->setTapizarMini($tapizarMini);
            $bean->setRota($rota);
            $bean->setPulido($pulido);
            $bean->setTupi($tupi);
            $bean->setCantos($cantos);
            $bean->setLijadoPelota($lijadoPelota);
            $bean->setRotocort($rotocort);
            $bean->setTacos($tacos);
            $bean->setEscuadraGarlopa($escuadraGarlopa);
            $bean->setOtra($otra);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PLPR_PULIDO_DET (   \n"; 
         $sql.="  PLPR_PULIDO_DET_ID,     \n"; 
         $sql.="  PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PIEZA_FICHA,     \n"; 
         $sql.="  TERMINACION,     \n"; 
         $sql.="  CANTIDAD,     \n";
         $sql.="  REPARADA,     \n"; 
         $sql.="  TAPIZAR_MINI,     \n"; 
         $sql.="  ROTA,     \n"; 
         $sql.="  PULIDO,     \n"; 
         $sql.="  TUPI,     \n"; 
         $sql.="  CANTOS,     \n"; 
         $sql.="  LIJADO_PELOTA,     \n"; 
         $sql.="  ROTOCORT,     \n"; 
         $sql.="  TACOS,     \n"; 
         $sql.="  ESCUADRA_GARLOPA,     \n"; 
         $sql.="  OTRA,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssiiiiiiiiiiiis",$bean->getId(), $bean->getPlanProdPulidoCabId(), $bean->getPiezaFicha(), 
         $bean->getTerminacion(), $bean->getCantidad(), $bean->isReparada(), $bean->isTapizarMini(), $bean->isRota(), 
         $bean->isPulido(), $bean->isTupi(), $bean->isCantos(), $bean->isLijadoPelota(), $bean->isRotocort(), $bean->isTacos(), 
         $bean->isEscuadraGarlopa(), $bean->isOtra(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PLPR_PULIDO_DET   \n"; 
         $sql.="WHERE PLPR_PULIDO_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PLPR_PULIDO_DET SET   \n"; 
         $sql.="  PLPR_PULIDO_CAB_ID=?,     \n"; 
         $sql.="  PIEZA_FICHA=?,     \n"; 
         $sql.="  TERMINACION=?,     \n"; 
         $sql.="  CANTIDAD=?,     \n";
         $sql.="  REPARADA=?,     \n"; 
         $sql.="  TAPIZAR_MINI=?,     \n"; 
         $sql.="  ROTA=?,     \n"; 
         $sql.="  PULIDO=?,     \n"; 
         $sql.="  TUPI=?,     \n"; 
         $sql.="  CANTOS=?,     \n"; 
         $sql.="  LIJADO_PELOTA=?,     \n"; 
         $sql.="  ROTOCORT=?,     \n"; 
         $sql.="  TACOS=?,     \n"; 
         $sql.="  ESCUADRA_GARLOPA=?,     \n"; 
         $sql.="  OTRA=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE PLPR_PULIDO_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssiiiiiiiiiiiiss", $bean->getPlanProdPulidoCabId(), $bean->getPiezaFicha(), $bean->getTerminacion(), $bean->getCantidad(), 
                                              $bean->isReparada(), $bean->isTapizarMini(), $bean->isRota(), $bean->isPulido(), $bean->isTupi(), 
                                              $bean->isCantos(), $bean->isLijadoPelota(), $bean->isRotocort(), $bean->isTacos(), $bean->isEscuadraGarlopa(), 
                                              $bean->isOtra(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $pppCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPD.PLPR_PULIDO_DET_ID,     \n"; 
         $sql.="  PPD.PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PPD.PIEZA_FICHA,     \n"; 
         $sql.="  PPD.TERMINACION,     \n"; 
         $sql.="  PPD.CANTIDAD,     \n";
         $sql.="  PPD.REPARADA,     \n"; 
         $sql.="  PPD.TAPIZAR_MINI,     \n"; 
         $sql.="  PPD.ROTA,     \n"; 
         $sql.="  PPD.PULIDO,     \n"; 
         $sql.="  PPD.TUPI,     \n"; 
         $sql.="  PPD.CANTOS,     \n"; 
         $sql.="  PPD.LIJADO_PELOTA,     \n"; 
         $sql.="  PPD.ROTOCORT,     \n"; 
         $sql.="  PPD.TACOS,     \n"; 
         $sql.="  PPD.ESCUADRA_GARLOPA,     \n"; 
         $sql.="  PPD.OTRA,     \n"; 
         $sql.="  PPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_DET  PPD \n";
         $sql.="  INNER JOIN PLPR_PULIDO_CAB PPC  ON PPD.PLPR_PULIDO_CAB_ID=PPC.PLPR_PULIDO_CAB_ID   \n";
         $sql.="WHERE   \n";
         $sql.="  PPD.PLPR_PULIDO_CAB_ID='" . $pppCabId . "'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  PLPR_PULIDO_DET_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $planProdPulidoCabId=null;  
         $piezaFicha=null;  
         $terminacion=null;  
         $cantidad=null;
         $reparada=null;  
         $tapizarMini=null;  
         $rota=null;  
         $pulido=null;  
         $tupi=null;  
         $cantos=null;  
         $lijadoPelota=null;  
         $rotocort=null;  
         $tacos=null;  
         $escuadraGarlopa=null;  
         $otra=null;  
         $observaciones=null;  
         $stm->bind_result($id, $planProdPulidoCabId, $piezaFicha, $terminacion, $cantidad, $reparada, $tapizarMini, $rota, $pulido, $tupi, $cantos, $lijadoPelota, $rotocort, $tacos, $escuadraGarlopa, $otra, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanProdPulidoDet();  
            $bean->setId($id);
            $bean->setPlanProdPulidoCabId($planProdPulidoCabId);
            $bean->setPiezaFicha($piezaFicha);
            $bean->setTerminacion($terminacion);
            $bean->setCantidad($cantidad);
            $bean->setReparada($reparada);
            $bean->setTapizarMini($tapizarMini);
            $bean->setRota($rota);
            $bean->setPulido($pulido);
            $bean->setTupi($tupi);
            $bean->setCantos($cantos);
            $bean->setLijadoPelota($lijadoPelota);
            $bean->setRotocort($rotocort);
            $bean->setTacos($tacos);
            $bean->setEscuadraGarlopa($escuadraGarlopa);
            $bean->setOtra($otra);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($pppCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  COUNT(*) \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_DET PPD  \n";         
         $sql.="  INNER JOIN PLPR_PULIDO_CAB PPC  ON PPD.PLPR_PULIDO_CAB_ID=PPC.PLPR_PULIDO_CAB_ID   \n";
         $sql.="WHERE   \n";
         $sql.="  PPD.PLPR_PULIDO_CAB_ID='" . $pppCabId . "'  \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selTodosPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $piezaFicha){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPC.EMPLEADO_ID,     \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n";
         $sql.="  PPC.PLPR_PULIDO_FECHA,     \n";
         $sql.="  PPD.PLPR_PULIDO_DET_ID,     \n"; 
         $sql.="  PPD.PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PPD.PIEZA_FICHA,     \n"; 
         $sql.="  PPD.CANTIDAD,     \n";
         $sql.="  PPD.TERMINACION,     \n";
         $sql.="  PPD.CANTIDAD,     \n";
         $sql.="  PPD.REPARADA,     \n";
         $sql.="  PPD.TAPIZAR_MINI,     \n";
         $sql.="  PPD.ROTA,     \n";
         $sql.="  PPD.PULIDO,     \n";
         $sql.="  PPD.TUPI,     \n";
         $sql.="  PPD.CANTOS,     \n"; 
         $sql.="  PPD.LIJADO_PELOTA,     \n";
         $sql.="  PPD.ROTOCROT,     \n";
         $sql.="  PPD.TACOS,     \n";
         $sql.="  PPD.ESCUADRA_GARLOPA,     \n";
         $sql.="  PPD.OTRA,     \n";
         $sql.="  PPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_DET PPD  \n";
         $sql.="  INNER JOIN PLPR_PULIDO_CAB PPC ON PPD.PLPR_PULIDO_CAB_ID=PPC.PLPR_PULIDO_CAB_ID \n";
         $sql.="WHERE   1=1 \n";
         if (!empty($empleadoId)){
           $sql.="  PPC.EMPLEADO_ID='" . $empleadoId . "'  \n";  
         } 
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLRP_PULIDO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLRP_PULIDO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }          
         if ($piezaFicha!=null){
         	$sql.="  AND UPPER(FIC.PIEZA_FICHA) LIKE '%" . mb_strtoupper($piezaFicha, 'utf-8')   . "%'  \n"; 
         }
         $sql.="ORDER BY   \n";
         $sql.="  PPC.PLRP_PULIDO_FECHA DESC   \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $empleadoId=null; $empleadoApellido=null; $empleadoNombre=null;
         $planProdFecha=null;
         $planProdPulidoCabId=null;  
         $piezaFicha=null;  
         $cantidad=null;
         $terminacion=null;
         $cantidad=null;
         $reparada=null;
         $tapizarMini=null;
         $rota=null;
         $pulido=null;
         $tupi=null;
         $cantos=null;  
         $lijadoPelota=null;  
         $rotocort=null;  
         $tacos=null;  
         $escuadraGarlopa=null;  
         $otra=null;  
         $observaciones=null;
         $stm->bind_result($id, $empleadoId, $empleadoApellido, $empleadoNombre, $planProdFecha, 
           $planProdPulidoCabId, $piezaFicha, $cantidad, $espesor, $terminacion, $cantidad,
           $reparada, $tapizarMini, $rota, $pulido, $tupi, $cantos, $lijadoPelota, $rotocort, 
           $tacos, $escuadraGarlopa, $otra, $observaciones);  
         $filas = array();
         while ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPlanProdPulidoCabId($planProdPulidoCabId);
            $bean->setPiezaFicha($piezaFicha);
            $bean->setTerminacion($terminacion);
            $bean->setCantidad($cantidad);
            $bean->setReparada($reparada);
            $bean->setTapizarMini($tapizarMini);
            $bean->setRota($rota);
            $bean->setPulido($pulido);
            $bean->setTupi($tupi);
            $bean->setCantos($cantos);
            $bean->setLijadoPelota($lijadoPelota);
            $bean->setRotocort($rotocort);
            $bean->setTacos($tacos);
            $bean->setEscuadraGarlopa($escuadraGarlopa);
            $bean->setOtra($otra);
            $bean->setObservaciones($observaciones);
         }
         $this->cierra($conexion, $stm); 
         return $filas; 
      }
      
      public function selTodosPlanoCuenta($empleadoId, $fechaDesde, $fechaHasta, $piezaFicha){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  COUNT(*) \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_DET PPD  \n";
         $sql.="  INNER JOIN PLPR_PULIDO_CAB PPC ON PPD.PLPR_PULIDO_CAB_ID=PPC.PLPR_PULIDO_CAB_ID \n";
         $sql.="WHERE   1=1 \n";
         if (!empty($empleadoId)){
           $sql.="  PPC.EMPLEADO_ID='" . $empleadoId . "'  \n";  
         } 
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLPR_PULIDO_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLPR_PULIDO_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }          
         if ($piezaFicha!=null){
         	$sql.="  AND UPPER(PPD.PIEZA_FICHA) LIKE '%" . mb_strtoupper($piezaFicha, 'utf-8')   . "%'  \n"; 
         }
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }             

   } 
?>