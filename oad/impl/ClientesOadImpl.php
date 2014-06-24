<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ClientesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Cliente.php';
//require_once('FirePHPCore/fb.php');  

   class ClientesOadImpl extends AOD implements ClientesOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  CLIENTE_NOMBRE,    \n";
         $sql.="  CONDICIONES_PAGO,    \n";
         $sql.="  CONDUCTA,    \n";
         $sql.="  CONTACTO_COMPRAS,    \n";
         $sql.="  CUIT,    \n";
         $sql.="  CONDICION_IVA,    \n";
         $sql.="  DIRECCION,    \n";
         $sql.="  LOCALIDAD,    \n";
         $sql.="  TELEFONO    \n";
         $sql.="FROM  \n"; 
         $sql.="  CLIENTES  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  CLIENTE_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Cliente();  
         $id=null;  
         $nombre=null;  
         $condicionesPago=null;
         $conducta=null;
         $contactoCompras=null;
         $cuit=null;
         $condicionIva=null;
         $direccion=null;
         $localidad=null;
         $telefono=null;
         $stm->bind_result($id, $nombre, $condicionesPago, $conducta, $contactoCompras, $cuit, $condicionIva, $direccion, $localidad, $telefono); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setCondicionesPago($condicionesPago);
            $bean->setConducta($conducta);
            $bean->setContactoCompras($contactoCompras);
            $bean->setCuit($cuit);
            $bean->setCondicionIva($condicionIva);
            $bean->setDireccion($direccion);
            $bean->setLocalidad($localidad);
            $bean->setTelefono($telefono);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO CLIENTES (   \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  CLIENTE_NOMBRE,     \n"; 
		 $sql.="  CONDICIONES_PAGO,     \n";
		 $sql.="  CONDUCTA,     \n";
		 $sql.="  CONTACTO_COMPRAS,     \n";
         $sql.="  CUIT,    \n";
         $sql.="  CONDICION_IVA,    \n";
         $sql.="  DIRECCION,    \n";
         $sql.="  LOCALIDAD,    \n";
         $sql.="  TELEFONO,    \n";
         $sql.="  HABILITADO)     \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)    \n"; 
		 $idUnico=$this->idUnico();
         $bean->setId($idUnico); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssssssss",$bean->getId(), $bean->getNombre(), $bean->getCondicionesPago(), $bean->getConducta(), $bean->getContactoCompras(), 
           $bean->getCuit(), $bean->getCondicionIva(), $bean->getDireccion(), $bean->getLocalidad(), $bean->getTelefono()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 
      
      public function inhabilita($id){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE CLIENTES    \n"; 
         $sql.="SET HABILITADO=0     \n"; 
         $sql.="WHERE      \n"; 
         $sql.="  CLIENTE_ID=?     \n"; 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("s",$id); 
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM CLIENTES   \n"; 
         $sql.="WHERE CLIENTE_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE CLIENTES SET   \n"; 
         $sql.="  CLIENTE_NOMBRE=?,     \n";
         $sql.="  CONDICIONES_PAGO=?,     \n";
         $sql.="  CONDUCTA=?,     \n";
         $sql.="  CONTACTO_COMPRAS=?,     \n";
         $sql.="  CUIT=?,     \n";
         $sql.="  CONDICION_IVA=?,     \n";
         $sql.="  DIRECCION=?,     \n";
         $sql.="  LOCALIDAD=?,     \n";
         $sql.="  TELEFONO=?     \n";
         $sql.="WHERE CLIENTE_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssssssssss", $bean->getNombre(), $bean->getCondicionesPago(), $bean->getConducta(), $bean->getContactoCompras(), 
           $bean->getCuit(), $bean->getCondicionIva(), $bean->getDireccion(), $bean->getLocalidad(), $bean->getTelefono(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $nombreOParte){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  CLIENTE_NOMBRE,    \n";
         $sql.="  CONDICIONES_PAGO,    \n";
         $sql.="  CONDUCTA,    \n";
         $sql.="  CONTACTO_COMPRAS,    \n";
         $sql.="  CUIT,    \n";
         $sql.="  CONDICION_IVA,    \n";
         $sql.="  DIRECCION,    \n";
         $sql.="  LOCALIDAD,    \n";
         $sql.="  TELEFONO    \n";
         $sql.="FROM  \n"; 
         $sql.="  CLIENTES  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  HABILITADO=1  \n"; 
         if ($nombreOParte!=null){
         	$sql.="  AND UPPER(CLIENTE_NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'  \n"; 
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  CLIENTE_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;
         $condicionesPago=null;
         $conducta=null;
         $contactoCompras=null;
         $cuit=null;
         $condicionIva=null;
         $direccion=null;
         $localidad=null;
         $telefono=null;
         $stm->bind_result($id, $nombre, $condicionesPago, $conducta, $contactoCompras, $cuit, $condicionIva, $direccion, $localidad, $telefono); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Cliente();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setCondicionesPago($condicionesPago);
            $bean->setConducta($conducta);
            $bean->setContactoCompras($contactoCompras);
            $bean->setCuit($cuit);
            $bean->setCondicionIva($condicionIva);
            $bean->setDireccion($direccion);
            $bean->setLocalidad($localidad);
            $bean->setTelefono($telefono);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selPorComienzo($cadena, $desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  CLIENTE_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  CLIENTES  \n";
         $sql.="WHERE  \n"; 
         $sql.="  HABILITADO=1  \n"; 
         $sql.="  AND UPPER(CLIENTE_NOMBRE) LIKE ?  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  CLIENTE_NOMBRE  \n"; 
         $sql.="LIMIT ?, ?  \n";
         $stm=$conexion->prepare($sql);  
         $comienzo=strtoupper($cadena) . "%"; 
         $stm->bind_param('sii', $comienzo, $desde, $cuantos);
         $stm->execute();  
         $id=null;  
         $nombre=null;
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Cliente();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       


      public function selTodosCuenta($nombreOParte){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM CLIENTES "; 
         $sql.="WHERE  \n"; 
         $sql.="  HABILITADO=1  \n";  
         if ($nombreOParte!=null){
         	$sql.="  AND UPPER(CLIENTE_NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'  \n"; 
         }                 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      

      public function selPorComienzoCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM CLIENTES "; 
         $sql.="WHERE  \n"; 
         $sql.="  HABILITADO=1  \n"; 
         $sql.="  AND UPPER(CLIENTE_NOMBRE) LIKE '". strtoupper($cadena)  . "%'  \n";
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