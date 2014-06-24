<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/TerminacionesOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Terminacion.php';
//require_once('FirePHPCore/fb.php');

   class TerminacionesOadImpl extends AOD implements TerminacionesOad {

      public function selPorComienzo($cadena, $desde, $cuantos){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  TER.TERMINACION_ID,     \n";
         $sql.="  TER.TERMINACION_NOMBRE,     \n";
         $sql.="  TER.HABILITADA    \n";
         $sql.="FROM  \n";
         $sql.="  TERMINACIONES TER \n";
         $sql.="WHERE  \n";
         $sql.="  TER.HABILITADA=1  \n";
         $sql.="  AND UPPER(TER.TERMINACION_NOMBRE) LIKE '" . mb_strtoupper($cadena, 'utf-8')   . "%'  \n";
         $sql.="ORDER BY  \n";
         $sql.="  TER.TERMINACION_NOMBRE  \n";
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
            $bean=new Terminacion();
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setHabilitada($habilitada);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }






      public function selPorComienzoCuenta($cadena){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) FROM TERMINACIONES ";
         $sql.="WHERE HABILITADA=1 ";
         $sql.="  AND UPPER(TERMINACION_NOMBRE) LIKE '" . mb_strtoupper($cadena, 'utf-8')   . "%'  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }
      
      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  TERMINACION_ID,     \n"; 
         $sql.="  TERMINACION_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  TERMINACIONES  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  TERMINACION_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Terminacion();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 
      
      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO TERMINACIONES (   \n"; 
         $sql.="  TERMINACION_ID,     \n"; 
         $sql.="  TERMINACION_NOMBRE)    \n"; 
         $sql.="VALUES (?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ss",$bean->getId(), $bean->getNombre()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      }      

   }
?>