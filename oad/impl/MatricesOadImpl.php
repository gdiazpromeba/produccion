<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/MatricesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Matriz.php';
//require_once('FirePHPCore/fb.php');  

   class MatricesOadImpl extends AOD implements MatricesOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MAT.MATRIZ_ID,     \n"; 
         $sql.="  MAT.MATRIZ_NOMBRE,     \n";
         $sql.="  MAT.MATRIZ_TIPO,     \n";
         $sql.="  MAT.MATRIZ_FOTO,     \n"; 
         $sql.="  MAT.ANCHO_BASE,     \n";
         $sql.="  MAT.LARGO_BASE,     \n";
         $sql.="  MAT.ALTURA_CONJUNTO,     \n";
         $sql.="  MAT.MATRIZ_FORMA,     \n";
         $sql.="  MAT.DEPOSITO_ID,     \n"; 
         $sql.="  DEP.DEPOSITO_NOMBRE,     \n"; 
         $sql.="  MAT.MATRIZ_CONDICION    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  MATRICES MAT,  \n"; 
         $sql.="  INNER JOIN DEPOSITOS DEP  ON MAT.DEPOSITO_ID=DEP.DEPOSITO_ID     \n";
         $sql.="WHERE  \n"; 
         $sql.="  MATRIZ_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Matriz();  
         $id=null;  
         $nombre=null;  
         $tipo=null;
         $foto=null;  
         $anchoBase=null;
         $largoBase=null;
         $alturaConjunto=null;
         $matrizForma=null;
         $depositoId=null;  
         $depositoNombre=null;  
         $condicion=null;  
         $stm->bind_result($id, $nombre, $tipo, $foto, $anchoBase, $largoBase, $alturaConjunto, $matrizForma, $depositoId, $depositoNombre, $condicion); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setTipo($tipo);
            $bean->setFoto($foto);
            $bean->setAnchoBase($anchoBase);
            $bean->setLargoBase($largoBase);
            $bean->setAlturaConjunto($alturaConjunto);
            $bean->setForma($matrizForma);
            $bean->setDepositoId($depositoId);
            $bean->setDepositoNombre($depositoNombre);
            $bean->setCondicion($condicion);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO MATRICES (   \n"; 
         $sql.="  MATRIZ_ID,     \n"; 
         $sql.="  MATRIZ_NOMBRE,     \n";
         $sql.="  MATRIZ_TIPO,     \n";
         $sql.="  MATRIZ_FOTO,     \n"; 
         $sql.="  ANCHO_BASE,     \n";
         $sql.="  LARGO_BASE,     \n";
         $sql.="  ALTURA_CONJUNTO,     \n";
         $sql.="  MATRIZ_FORMA,     \n";
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  MATRIZ_CONDICION)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?,  ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssiiisss",$bean->getId(), $bean->getNombre(), $bean->getTipo(), $bean->getFoto(), 
                                      $bean->getAnchoBase(), $bean->getLargoBase(), $bean->getAlturaConjunto(), 
                                      $bean->getForma(), $bean->getDepositoId(), $bean->getCondicion()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM MATRICES   \n"; 
         $sql.="WHERE MATRIZ_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE MATRICES SET   \n"; 
         $sql.="  MATRIZ_NOMBRE=?,     \n";
         $sql.="  MATRIZ_TIPO=?,     \n";
         $sql.="  MATRIZ_FOTO=?,     \n"; 
         $sql.="  ANCHO_BASE=?,     \n";
         $sql.="  LARGO_BASE=?,     \n";
         $sql.="  ALTURA_CONJUNTO=?,     \n";
         $sql.="  MATRIZ_FORMA=?,     \n";
         $sql.="  DEPOSITO_ID=?,     \n"; 
         $sql.="  MATRIZ_CONDICION=?     \n"; 
         $sql.="WHERE MATRIZ_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssiiissss", $bean->getNombre(), $bean->getTipo(), $bean->getFoto(), 
                                        $bean->getAnchoBase(),  $bean->getLargoBase(),  $bean->getAlturaConjunto(),  
                                        $bean->getForma(), $bean->getDepositoId(), $bean->getCondicion(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 

      public function selTodos($desde, $cuantos, $nombreOParte, $depositoId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MAT.MATRIZ_ID,     \n"; 
         $sql.="  MAT.MATRIZ_NOMBRE,     \n";
         $sql.="  MAT.MATRIZ_TIPO,     \n";
         $sql.="  MAT.MATRIZ_FOTO,     \n"; 
         $sql.="  MAT.ANCHO_BASE,     \n";
         $sql.="  MAT.LARGO_BASE,     \n";
         $sql.="  MAT.ALTURA_CONJUNTO,     \n";
         $sql.="  MAT.MATRIZ_FORMA,     \n";
         $sql.="  MAT.DEPOSITO_ID,     \n"; 
         $sql.="  DEP.DEPOSITO_NOMBRE,     \n"; 
         $sql.="  MAT.MATRIZ_CONDICION    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  MATRICES MAT  \n"; 
         $sql.="  INNER JOIN DEPOSITOS DEP  ON MAT.DEPOSITO_ID=DEP.DEPOSITO_ID     \n";
         $sql.="WHERE  1=1  \n";
         if (!empty($nombreOParte)){
           $sql.=" AND UPPER(MAT.MATRIZ_NOMBRE) LIKE '%" . strtoupper($nombreOParte) .   "%'  \n";
         }
         if (!empty($depositoId)){
           $sql.=" AND MAT.DEPOSITO_ID='" . $depositoId .   "'  \n";
         }
         $sql.="ORDER BY  \n";
         $sql.="  MAT.MATRIZ_NOMBRE     \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
//         fb($sql);
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $tipo=null;
         $foto=null;  
         $anchoBase=null;
         $largoBase=null;
         $alturaConjunto=null;
         $matrizForma=null;
         $depositoId=null;  
         $depositoNombre=null;  
         $condicion=null;  
         $stm->bind_result($id, $nombre, $tipo, $foto, $anchoBase, $largoBase, $alturaConjunto, $matrizForma, $depositoId, $depositoNombre, $condicion); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Matriz();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setTipo($tipo);
            $bean->setFoto($foto);
            $bean->setAnchoBase($anchoBase);
            $bean->setLargoBase($largoBase);
            $bean->setAlturaConjunto($alturaConjunto);
            $bean->setForma($matrizForma);
            $bean->setDepositoId($depositoId);
            $bean->setDepositoNombre($depositoNombre);
            $bean->setCondicion($condicion);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selPorComienzo($cadena, $desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MAT.MATRIZ_ID,     \n"; 
         $sql.="  MAT.MATRIZ_NOMBRE     \n"; 
         $sql.="FROM  \n"; 
         $sql.="  MATRICES MAT  \n"; 
         $sql.="WHERE  \n";
         $sql.="  UPPER(MAT.MATRIZ_NOMBRE) LIKE ?  \n";         
         $sql.="ORDER BY  \n";
         $sql.="  MAT.MATRIZ_NOMBRE     \n";
         $sql.="LIMIT ?, ?   \n"; 
         $stm=$conexion->prepare($sql);  
         $comienzo=strtoupper($cadena) . "%"; 
         $stm->bind_param('sii', $comienzo, $desde, $cuantos);
         $stm->execute();  
         $id=null;  
         $nombre=null;
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Matriz();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selPorComienzoCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM MATRICES "; 
         $sql.="WHERE  \n"; 
         $sql.="  UPPER(MATRIZ_NOMBRE) LIKE '". strtoupper($cadena)  . "%'  \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }      


      public function selTodosCuenta($nombreOParte, $depositoId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM MATRICES MAT \n"; 
         $sql.="WHERE  1=1  \n";
         if (!empty($nombreOParte)){
           $sql.=" AND UPPER(MAT.MATRIZ_NOMBRE) LIKE '" . strtoupper($nombreOParte) .   "'  \n";
         }
         if (!empty($depositoId)){
           $sql.=" AND MAT.DEPOSITO_ID='" . $depositoId .   "'  \n";
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