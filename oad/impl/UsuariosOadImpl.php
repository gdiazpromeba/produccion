<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/UsuariosOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Usuario.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class UsuariosOadImpl extends AOD implements UsuariosOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  USUARIO_LOGIN,     \n";
         $sql.="  USUARIO_NOMBRE_COMPLETO,     \n";
         $sql.="  USUARIO_CLAVE,     \n";
         $sql.="  HABILITADO,     \n";
         $sql.="  INTENTOS,     \n";
         $sql.="  ULTIMA_ACTUALIZACION     \n";
         $sql.="FROM  \n"; 
         $sql.="  USUARIOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  USUARIO_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Usuario();  
         $id=null;  
         $login=null;
         $nombreCompleto=null;
         $habilitado=null;
         $intentos=null;
         $ultimaActualizacion=null;
         $stm->bind_result($id, $login, $nombreCompleto, $habilitado, $intentos, $ultimaActualizacion); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setLogin($login);
            $bean->setNombreCompleto($nombreCompleto);
            $bean->setHabilitado($habilitado);
            $bean->setIntentos($intentos);
            $bean->setUltimaActualizacionLarga($ultimaActualizacion);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 
      
      public function obtienePorUid($uid){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  USUARIO_LOGIN,     \n";
         $sql.="  USUARIO_NOMBRE_COMPLETO,     \n";
         $sql.="  USUARIO_CLAVE,     \n";
         $sql.="  HABILITADO,     \n";
         $sql.="  INTENTOS,     \n";
         $sql.="  ULTIMA_ACTUALIZACION     \n";
         $sql.="FROM  \n"; 
         $sql.="  USUARIOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  USUARIO_LOGIN='" . $uid . "' \n";          
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Usuario();  
         $id=null;  
         $login=null;
         $nombreCompleto=null;
         $clave=null;
         $habilitado=null;
         $intentos=null;
         $ultimaActualizacion=null;
         $stm->bind_result($id, $login, $nombreCompleto, $clave,  $habilitado, $intentos, $ultimaActualizacion); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setLogin($login);
            $bean->setNombreCompleto($nombreCompleto);
            $bean->setHabilitado($habilitado);
            $bean->setIntentos($intentos);
            $bean->setUltimaActualizacionLarga($ultimaActualizacion);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      }      


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO USUARIOS (   \n"; 
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  USUARIO_LOGIN,     \n"; 
         $sql.="  USUARIO_NOMBRE_COMPLETO,     \n"; 
         $sql.="  USUARIO_CLAVE,    \n"; 
         $sql.="  HABILITADO,    \n"; 
         $sql.="  INTENTOS,    \n";
         $sql.="  ULTIMA_ACTUALIZACION)    \n";
         $sql.="VALUES (?, ?, ?, ?, 1, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssis", $bean->getId(), $bean->getLogin(), $bean->getNombreCompleto(), $bean->getClave(), $bean->getIntentos(), $bean->getUltimaActualizacionLarga()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM USUARIOS   \n"; 
         $sql.="WHERE USUARIO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function inhabilita($id){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE USUARIOS \n"; 
         $sql.="SET HABILITADO=0   \n"; 
         $sql.="WHERE USUARIO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE USUARIOS SET   \n"; 
         $sql.="  USUARIO_LOGIN=?,     \n"; 
         $sql.="  USUARIO_NOMBRE_COMPLETO=?,     \n"; 
         $sql.="  USUARIO_CLAVE=?,    \n"; 
         $sql.="  HABILITADO=?,    \n"; 
         $sql.="  INTENTOS=?,    \n";
         $sql.="  ULTIMA_ACTUALIZACION=?    \n";
         $sql.="WHERE USUARIO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssiiss", $bean->getLogin(), $bean->getNombreCompleto(), $bean->getClave(),  $bean->getHabilitado(), $bean->getIntentos(), FechaUtils::ahoraLarga(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 

      public function selTodos($desde, $cuantos, $nombreOParte, $grupoId){ 
         $conexion=$this->conectarse();
         $sql="SELECT     \n";  
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  USUARIO_LOGIN,     \n";
         $sql.="  USUARIO_NOMBRE_COMPLETO,     \n";
         $sql.="  USUARIO_CLAVE,     \n";
         $sql.="  HABILITADO,     \n";
         $sql.="  INTENTOS,     \n";
         $sql.="  ULTIMA_ACTUALIZACION     \n";
         $sql.="FROM  \n"; 
         $sql.="  USUARIOS USU  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  HABILITADO=1  \n"; 
         if (!empty($nombreOParte)){
           $sql.="  AND UPPER(USUARIO_NOMBRE_COMPLETO) LIKE '%" . strtoupper($nombreOParte) . "%'    \n"; 
         }
         if (!empty($grupoId)){
           $sql.="  AND USUARIO_ID IN (SELECT UPG.USUARIO_ID FROM USUARIOS_POR_GRUPO UPG WHERE UPG.GRUPO_ID='" . $grupoId .  "')  \n"; 
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  USUARIO_NOMBRE_COMPLETO  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $login=null;
         $nombreCompleto=null;
         $clave=null;
         $habilitado=null;
         $intentos=null;
         $ultimaActualizacion=null;
         $stm->bind_result($id, $login, $nombreCompleto, $clave, $habilitado, $intentos, $ultimaActualizacion);
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Usuario();  
            $bean->setId($id);
            $bean->setLogin($login);
            $bean->setNombreCompleto($nombreCompleto);
            $bean->setHabilitado($habilitado);
            $bean->setIntentos($intentos);
            $bean->setUltimaActualizacionLarga($ultimaActualizacion);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($nombreOParte, $grupoId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM USUARIOS ";
         $sql.="WHERE  \n"; 
         $sql.="  HABILITADO=1  \n";  
         if ($nombreOParte!=null){
           $sql.="  AND UPPER(USUARIO_NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'    \n"; 
         }
         if (!empty($grupoId)){
           $sql.="  AND USUARIO_ID IN (SELECT UPG.USUARIO_ID FROM USUARIOS_POR_GRUPO UPG WHERE UPG.GRUPO_ID='" . $grupoId .  "')  \n"; 
         }
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function validaUsuario($login, $clave){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) \n"; 
         $sql.="FROM  \n"; 
         $sql.="  USUARIOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  USUARIO_LOGIN='" . $login  . "' \n";
         $sql.="  AND USUARIO_CLAVE='" . $clave . "' \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm);
         $resultado=array(); 
         $resultado["success"]=$cuenta>0;
         return $resultado;          
      }      

   } 
?>