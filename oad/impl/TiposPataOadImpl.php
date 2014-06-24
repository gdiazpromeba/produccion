<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/TiposPataOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/TipoPata.php';
//require_once('FirePHPCore/fb.php');

   class TiposPataOadImpl extends AOD implements TiposPataOad {

      public function selTodos($desde, $cuantos){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  TIP.TIPO_PATA_ID,     \n";
         $sql.="  TIP.TIPO_PATA_NOMBRE,     \n";
         $sql.="  TIP.HABILITADA    \n";
         $sql.="FROM  \n";
         $sql.="  TIPOS_PATA TIP \n";
         $sql.="WHERE  \n";
         $sql.="  TIP.HABILITADA=1  \n";
         $sql.="ORDER BY  \n";
         $sql.="  TIP.TIPO_PATA_NOMBRE  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $nombre=null;
         $habilitada=null;
         $stm->bind_result($id, $nombre, $habilitada);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new TipoPata();
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setHabilitada($habilitada);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selTodosCuenta(){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) FROM TIPOS_PATA ";
         $sql.="WHERE HABILITADA=1 ";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }
      
      public function reportePendientes(){
      	$conexion=$this->conectarse();
      	
      	$sql="SELECT                  \n";
      	$sql.="   TIP.TIPO_PATA_NOMBRE,                  \n";
      	$sql.="   SUM(PED.PEDIDO_CANTIDAD) AS CANTIDAD                  \n";
      	$sql.=" FROM                  \n";
      	$sql.="   PEDIDOS_DETALLE PED                  \n";
      	$sql.="   INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID                  \n";
      	$sql.="   INNER JOIN PIEZAS PIE ON PED.PIEZA_ID=PIE.PIEZA_ID                  \n";
      	$sql.="   INNER JOIN TIPOS_PATA TIP ON PIE.TIPO_PATA_ID=TIP.TIPO_PATA_ID                  \n";
      	$sql.=" WHERE                  \n";
      	$sql.="   PEC.PEDIDO_ESTADO='Pendiente'                  \n";
      	$sql.=" GROUP BY                  \n";
      	$sql.="   TIP.TIPO_PATA_NOMBRE                  \n";
      	$sql.=" ORDER BY                  \n";
      	$sql.="   TIP.TIPO_PATA_NOMBRE      	                  \n";
      	$stm=$this->preparar($conexion, $sql);
      	$stm->execute();
      	$tipoPataNombre=null;
      	$cantidad=null;
      	$stm->bind_result($tipoPataNombre, $cantidad);
      	$filas = array();
      	while ($stm->fetch()) {
      		$fila=array();
      		$fila['tipoPataNombre']=$tipoPataNombre;
      		$fila['cantidad']=$cantidad;
      		$filas[]=$fila;
      	}
      	$this->cierra($conexion, $stm);
      	return $filas;
      }      

   }
?>