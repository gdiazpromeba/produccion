<?php

require_once $raiz  .  'oad/AOD.php';
require_once $raiz  .  'oad/AlertasMailOad.php';
require_once $raiz  .  'util/FechaUtils.php';

//require_once('FirePHPCore/fb.php');

   class AlertasMailOadImpl extends AOD implements AlertasMailOad {
   
   
    /**
      items de pedidos pendientes, con terminación, que no han sido asignados a ningún
      laqueador por más de una semana
    */
    public function selLaqueadosNoAsignados(){
      $conexion=$this->conectarse();
      $sql="SELECT                             \n";      
      $sql.="  PEC.PEDIDO_NUMERO,              \n";
      $sql.="  PEC.PEDIDO_FECHA,               \n";
      $sql.="  PED.PEDIDO_CANTIDAD,            \n";
      $sql.="  PIE.PIEZA_NOMBRE,               \n";
      $sql.="  TER.TERMINACION_NOMBRE,         \n";
      $sql.="  CLI.CLIENTE_NOMBRE              \n";
      $sql.="FROM                              \n";
      $sql.="  PEDIDOS_CABECERA PEC            \n";
      $sql.="  INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID                                        \n";
      $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON PEC.PEDIDO_CABECERA_ID=PED.PEDIDO_CABECERA_ID                 \n";
      $sql.="  INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID                                              \n";
      $sql.="  INNER JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID                           \n";
      $sql.="  LEFT  JOIN REMITOS_LAQUEADO_DETALLE RLD ON PED.PEDIDO_DETALLE_ID=RLD.PEDIDO_DETALLE_ID          \n";
      $sql.="WHERE                                                                                             \n";
      $sql.="  PEC.HABILITADO=1                                                                                \n";
      $sql.="  AND PEC.PEDIDO_ESTADO='Pendiente'                                                               \n";
      $sql.="  AND RLD.PEDIDO_DETALLE_ID IS NULL                                                               \n";
      $sql.="AND DATEDIFF(CURDATE(), PEC.PEDIDO_FECHA)>7                                                       \n";   
      $stm=$this->preparar($conexion, $sql);
      $stm->execute();
      $pedidoNumero=null;
      $pedidoFecha=null;
      $cantidad=null;
      $piezaId=null;
      $piezaNombre=null;
      $terminacionNombre=null;
      $clienteNombre=null;
      $stm->bind_result($pedidoNumero, $pedidoFecha,  $cantidad, $piezaNombre, $terminacionNombre, $clienteNombre);
      $filas = array();
      while ($stm->fetch()) {
        $fila = array();
        $fila['pedidoNumero']=$pedidoNumero;
        $fila['pedidoFecha']=FechaUtils::cadenaLargaADMA($pedidoFecha);
        $fila['cantidad']=$cantidad;
        $fila['piezaNombre']=$piezaNombre;
        $fila['terminacionNombre']=$terminacionNombre;
        $fila['clienteNombre']=$clienteNombre;
        $filas[]=$fila;
      }
      $this->cierra($conexion, $stm);
      return $filas;
    }
    
  
    
    /**
      paquetes armados y asignados a un laqueador, que no
      le han sido enviados pasado más de un día
    */
    public function selPaquetesNoEnviados(){
      $conexion=$this->conectarse();
      $sql="SELECT                            \n";                            
      $sql.="  RLC.REMITO_LAQUEADO_NUMERO,    \n";               
      $sql.="    LAQ.LAQUEADOR_NOMBRE,        \n";                 
      $sql.="    RLC.FECHA_ENVIO,    \n";
      $sql.="    PEC.PEDIDO_NUMERO,    \n";
      $sql.="    CLI.CLIENTE_NOMBRE,    \n";
      $sql.="    PED.PEDIDO_CANTIDAD,    \n";
      $sql.="    PIE.PIEZA_NOMBRE,    \n";
      $sql.="    TER.TERMINACION_NOMBRE    \n";
      $sql.="  FROM                             \n";               
      $sql.="    REMITOS_LAQUEADO_CABECERA RLC                 \n";
      $sql.="    INNER JOIN REMITOS_LAQUEADO_DETALLE RLD ON RLC.REMITO_LAQUEADO_CAB_ID = RLD.REMITO_LAQUEADO_CAB_ID     \n";
      $sql.="    INNER JOIN PEDIDOS_DETALLE PED ON RLD.PEDIDO_DETALLE_ID = PED.PEDIDO_DETALLE_ID     \n";
      $sql.="    INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID    \n";
      $sql.="    INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID    \n";
      $sql.="    INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID    \n";
      $sql.="    INNER JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID=LAQ.LAQUEADOR_ID       \n";
      $sql.="    LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID    \n";
      $sql.="  WHERE                                                                   \n";
      $sql.="    PEC.PEDIDO_ESTADO='Pendiente'                                                \n";
      $sql.="    AND RLC.ESTADO='En Taller'                                            \n";
      $sql.="    AND DATEDIFF(CURDATE(), RLC.FECHA_ENVIO)>1                        \n";    
     
      $stm=$this->preparar($conexion, $sql);
      $stm->execute();
      $remitoNumero=null;
      $laqueadorNombre=null;
      $fechaEnvio=null;
      $pedidoNumero=null;
      $clienteNombre=null;
      $cantidad=null;
      $piezaNombre=null;
      $terminacionNombre=null;
      $stm->bind_result($remitoNumero, $laqueadorNombre,  $fechaEnvio, $pedidoNumero, $clienteNombre, $cantidad, $piezaNombre, $terminacionNombre);
      $filas = array();
      while ($stm->fetch()) {
        $fila = array();
        $fila['remitoNumero']=$remitoNumero;
        $fila['laqueadorNombre']=$laqueadorNombre;
        $fila['fechaEnvio']=FechaUtils::cadenaLargaADMA($fechaEnvio);
        $fila['pedidoNumero']=$pedidoNumero;
        $fila['clienteNombre']=$clienteNombre;
        $fila['cantidad']=$cantidad;
        $fila['piezaNombre']=$piezaNombre;
        $fila['terminacionNombre']=$terminacionNombre;
        $filas[]=$fila;
      }
      $this->cierra($conexion, $stm);
      return $filas;
    }   
    
    /**
      paquetes (remitos) entregados a un laqueador, que éste retuvo por más de 5 días sin completar
    */
    public function selPaquetesNoLaqueados(){
      $conexion=$this->conectarse();
      $sql="SELECT                            \n";                            
      $sql.="  RLC.REMITO_LAQUEADO_NUMERO,    \n";               
      $sql.="    LAQ.LAQUEADOR_NOMBRE,        \n";                 
      $sql.="    RLC.FECHA_ENVIO,    \n";
      $sql.="    PEC.PEDIDO_NUMERO,    \n";
      $sql.="    CLI.CLIENTE_NOMBRE,    \n";
      $sql.="    PED.PEDIDO_CANTIDAD,    \n";
      $sql.="    PIE.PIEZA_NOMBRE,    \n";
      $sql.="    TER.TERMINACION_NOMBRE    \n";
      $sql.="  FROM                             \n";               
      $sql.="    REMITOS_LAQUEADO_CABECERA RLC                 \n";
      $sql.="    INNER JOIN REMITOS_LAQUEADO_DETALLE RLD ON RLC.REMITO_LAQUEADO_CAB_ID = RLD.REMITO_LAQUEADO_CAB_ID     \n";
      $sql.="    INNER JOIN PEDIDOS_DETALLE PED ON RLD.PEDIDO_DETALLE_ID = PED.PEDIDO_DETALLE_ID     \n";
      $sql.="    INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID    \n";
      $sql.="    INNER JOIN CLIENTES CLI ON PEC.CLIENTE_ID=CLI.CLIENTE_ID    \n";
      $sql.="    INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID    \n";
      $sql.="    INNER JOIN LAQUEADORES LAQ ON RLC.LAQUEADOR_ID=LAQ.LAQUEADOR_ID       \n";
      $sql.="    LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID    \n";
      $sql.="  WHERE                                                                   \n";
      $sql.="    PEC.PEDIDO_ESTADO='Pendiente'                                                \n";
      $sql.="    AND RLC.ESTADO='En Laqueador'                                                \n";
      $sql.="    AND DATEDIFF(CURDATE(), RLC.FECHA_ENVIO)>5            \n";
     
      $stm=$this->preparar($conexion, $sql);
      $stm->execute();
      $remitoNumero=null;
      $laqueadorNombre=null;
      $fechaEnvio=null;
      $pedidoNumero=null;
      $clienteNombre=null;
      $cantidad=null;
      $piezaNombre=null;
      $terminacionNombre=null;
      $stm->bind_result($remitoNumero, $laqueadorNombre,  $fechaEnvio, $pedidoNumero, $clienteNombre, $cantidad, $piezaNombre, $terminacionNombre);
      $filas = array();
      while ($stm->fetch()) {
        $fila = array();
        $fila['remitoNumero']=$remitoNumero;
        $fila['laqueadorNombre']=$laqueadorNombre;
        $fila['fechaEnvio']=FechaUtils::cadenaLargaADMA($fechaEnvio);
        $fila['pedidoNumero']=$pedidoNumero;
        $fila['clienteNombre']=$clienteNombre;
        $fila['cantidad']=$cantidad;
        $fila['piezaNombre']=$piezaNombre;
        $fila['terminacionNombre']=$terminacionNombre;
        $filas[]=$fila;
      }
      $this->cierra($conexion, $stm);
      return $filas;
    }     
    
    /**
      pedidos pendientes están a 2 días de la fecha prometida o ya se pasaron de ella
    */
    public function selPendientesPasadosPrometida(){
      $conexion=$this->conectarse();
      $sql="  SELECT                            \n";
      $sql.="  CLI.CLIENTE_NOMBRE,              \n";
      $sql.="   PEC.FECHA_PROMETIDA,            \n";
      $sql.="   PEC.PEDIDO_NUMERO,              \n";
      $sql.="   PIE.PIEZA_NOMBRE,               \n";
      $sql.="   PED.PEDIDO_CANTIDAD,            \n";
      $sql.="   TER.TERMINACION_NOMBRE          \n";
      $sql.=" FROM                              \n";
      $sql.="   PEDIDOS_CABECERA PEC            \n";
      $sql.="   INNER JOIN PEDIDOS_DETALLE PED ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID          \n";
      $sql.="   INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID                                       \n";
      $sql.="   INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=PEC.CLIENTE_ID                                 \n";
      $sql.="   LEFT JOIN TERMINACIONES TER ON PED.TERMINACION_ID=TER.TERMINACION_ID                     \n";
      $sql.=" WHERE                                                          \n";
      $sql.="   PEC.HABILITADO=1                                                                                \n";
      $sql.="   AND PEC.PEDIDO_ESTADO='Pendiente'                                \n";
      $sql.="   AND DATEDIFF(CURDATE(), PEC.FECHA_PROMETIDA) >-2             \n";
      $stm=$this->preparar($conexion, $sql);
      $stm->execute();
      $clienteNombre=null;
      $fechaPrometida=null;
      $pedidoNumero=null;
      $piezaNombre=null;
      $cantidad=null;
      $terminacionNombre=null;
      $stm->bind_result($clienteNombre, $fechaPrometida,  $pedidoNumero, $piezaNombre, $cantidad, $terminacionNombre);
      $filas = array();
      while ($stm->fetch()) {
        $fila = array();
        $fila['clienteNombre']=$clienteNombre;
        $fila['fechaPrometida']=FechaUtils::cadenaLargaADMA($fechaPrometida);
        $fila['pedidoNumero']=$pedidoNumero;
        $fila['piezaNombre']=$piezaNombre;
        $fila['cantidad']=$cantidad;
        $fila['terminacionNombre']=$terminacionNombre;
        $filas[]=$fila;
      }
      $this->cierra($conexion, $stm);
      return $filas;
    }    

    
    
    
   }
?>