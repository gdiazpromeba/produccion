<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/LaqueadoresOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Laqueador.php';
//require_once('FirePHPCore/fb.php');

   class LaqueadoresOadImpl extends AOD implements LaqueadoresOad {

      public function selTodos($desde, $cuantos){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  LAQ.LAQUEADOR_ID,     \n";
         $sql.="  LAQ.LAQUEADOR_NOMBRE,     \n";
         $sql.="  LAQ.HABILITADA    \n";
         $sql.="FROM  \n";
         $sql.="  LAQUEADORES LAQ \n";
         $sql.="WHERE  \n";
         $sql.="  LAQ.HABILITADA=1  \n";
         $sql.="ORDER BY  \n";
         $sql.="  LAQ.LAQUEADOR_NOMBRE  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $piezaGenericaId=null;
         $piezaGenericaNombre=null;
         $nombre=null;
         $ficha=null;
         $habilitada=null;
         $stm->bind_result($id, $nombre, $habilitada);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new Laqueador();
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
         $sql="SELECT COUNT(*) FROM LAQUEADORES ";
         $sql.="WHERE HABILITADA=1 ";
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