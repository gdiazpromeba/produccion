<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/EmpleadosOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Empleado.php';
//  require_once('FirePHPCore/fb.php');

   class EmpleadosOadImpl extends AOD implements EmpleadosOad {

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  EMP.EMPLEADO_ID,     \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,    \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,    \n";
         $sql.="  EMP.CATEGORIA_ID,    \n";
         $sql.="  CAT.CATEGORIA_NOMBRE,    \n";
         $sql.="  EMP.TARJETA_NUMERO,    \n";
         $sql.="  EMP.FECHA_INICIO,    \n";
         $sql.="  EMP.SINDICALIZADO,    \n";
         $sql.="  EMP.DEPENDIENTES,    \n";
         $sql.="  EMP.DIRECCION,    \n";
         $sql.="  EMP.CUIL,    \n";
         $sql.="  EMP.NACIMIENTO    \n";
         $sql.="FROM  \n";
         $sql.="  EMPLEADOS EMP  \n";
         $sql.="  INNER JOIN CATEGORIAS_LABORALES CAT ON EMP.CATEGORIA_ID=CAT.CATEGORIA_LABORAL_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  EMP.EMPLEADO_ID='" . $id . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new Empleado();
         $id=null;
         $nombre=null;
         $apellido=null;
         $categoriaId=null;
         $categoriaNombre=null;
         $tarjetaNumero=null;
         $fechaInicio=null;
         $sindicalizado=null;
         $dependientes=null;
         $direccion=null;
         $cuil=null;
         $nacimiento=null;
         $stm->bind_result($id, $apellido, $nombre, $categoriaId, $categoriaNombre, $tarjetaNumero, $fechaInicio, $sindicalizado, $dependientes, $direccion, $cuil, $nacimiento);
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setApellido($apellido);
            $bean->setCategoriaId($categoriaId);
            $bean->setCategoriaNombre($categoriaNombre);
            $bean->setTarjetaNumero($tarjetaNumero);
            $bean->setFechaInicioLarga($fechaInicio);
            $bean->setSindicalizado($sindicalizado);
            $bean->setDependientes($dependientes);
            $bean->setDireccion($direccion);
            $bean->setCuil($cuil);
            $bean->setNacimientoLarga($nacimiento);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }

      public function obtienePorTarjeta($tarjetaNumero){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  EMP.EMPLEADO_ID,     \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,    \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,    \n";
         $sql.="  EMP.CATEGORIA_ID,    \n";
         $sql.="  CAT.CATEGORIA_NOMBRE,    \n";
         $sql.="  EMP.TARJETA_NUMERO,    \n";
         $sql.="  EMP.FECHA_INICIO,    \n";
         $sql.="  EMP.SINDICALIZADO,    \n";
         $sql.="  EMP.DEPENDIENTES,    \n";
         $sql.="  EMP.DIRECCION,    \n";
         $sql.="  EMP.CUIL,    \n";
         $sql.="  EMP.NACIMIENTO    \n";
         $sql.="FROM  \n";
         $sql.="  EMPLEADOS EMP  \n";
         $sql.="  INNER JOIN CATEGORIAS_LABORALES CAT ON EMP.CATEGORIA_ID=CAT.CATEGORIA_LABORAL_ID  \n";
         $sql.="WHERE  \n";
         $sql.="  EMP.TARJETA_NUMERO='" . $tarjetaNumero . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new Empleado();
         $id=null;
         $nombre=null;
         $apellido=null;
         $categoriaId=null;
         $categoriaNombre=null;
         $tarjetaNumero=null;
         $fechaInicio=null;
         $sindicalizado=null;
         $dependientes=null;
         $direccion=null;
         $cuil=null;
         $nacimiento=null;
         $stm->bind_result($id, $apellido, $nombre, $categoriaId, $categoriaNombre, $tarjetaNumero, $fechaInicio, $sindicalizado, $dependientes, $direccion, $cuil, $nacimiento);
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setApellido($apellido);
            $bean->setCategoriaId($categoriaId);
            $bean->setCategoriaNombre($categoriaNombre);
            $bean->setTarjetaNumero($tarjetaNumero);
            $bean->setFechaInicioLarga($fechaInicio);
            $bean->setSindicalizado($sindicalizado);
            $bean->setDependientes($dependientes);
            $bean->setDireccion($direccion);
            $bean->setCuil($cuil);
            $bean->setNacimientoLarga($nacimiento);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }


      public function selPorComienzo($cadena, $desde, $cuantos){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  EMPLEADO_ID,     \n";
         $sql.="  CONCAT(EMPLEADO_APELLIDO, ', ', EMPLEADO_NOMBRE) AS NOMBRE_COMPLETO,    \n";
         $sql.="  EMPLEADO_APELLIDO,    \n";
         $sql.="  EMPLEADO_NOMBRE,    \n";
         $sql.="  TARJETA_NUMERO    \n";
         $sql.="FROM  \n";
         $sql.="  EMPLEADOS  \n";
         $sql.="WHERE  \n";
         $sql.="  HABILITADO=1  \n";
         $sql.="  AND UPPER(CONCAT(EMPLEADO_APELLIDO, ', ', EMPLEADO_NOMBRE))  LIKE '" . mb_strtoupper($cadena, 'utf-8')   . "%'  \n";
         $sql.="ORDER BY  \n";
         $sql.="  CONCAT(EMPLEADO_APELLIDO, ', ', EMPLEADO_NOMBRE)  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $nombreCompleto=null;
         $nombre=null;
         $apellido=null;
         $tarjetaNumero=null;
         $stm->bind_result($id, $nombreCompleto, $apellido, $nombre, $tarjetaNumero);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new Empleado();
            $bean->setId($id);
            $bean->setNombreCompleto($nombreCompleto);
            $bean->setApellido($apellido);
            $bean->setNombre($nombre);
            $bean->setTarjetaNumero($tarjetaNumero);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function inserta($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO EMPLEADOS (   \n";
         $sql.="  EMPLEADO_ID,     \n";
         $sql.="  EMPLEADO_APELLIDO,     \n";
         $sql.="  EMPLEADO_NOMBRE,     \n";
         $sql.="  CATEGORIA_ID,     \n";
         $sql.="  TARJETA_NUMERO,     \n";
         $sql.="  FECHA_INICIO,     \n";
         $sql.="  DEPENDIENTES,     \n";
         $sql.="  SINDICALIZADO,     \n";
         $sql.="  DIRECCION,     \n";
         $sql.="  CUIL,     \n";
         $sql.="  NACIMIENTO,     \n";
         $sql.="  HABILITADO)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)    \n";
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("ssssisiisss",$bean->getId(), $bean->getApellido(),$bean->getNombre(), $bean->getCategoriaId(),
           $bean->getTarjetaNumero(), $bean->getFechaInicioLarga(),  $bean->getDependientes(),
           $bean->isSindicalizado(), $bean->getDireccion(), $bean->getCuil(), $bean->getNacimientoLarga());
         return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      }

      public function actualiza($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE EMPLEADOS SET    \n";
         $sql.="  EMPLEADO_APELLIDO=?, \n";
         $sql.="  EMPLEADO_NOMBRE=?,   \n";
         $sql.="  CATEGORIA_ID=?,      \n";
         $sql.="  TARJETA_NUMERO=?,    \n";
         $sql.="  FECHA_INICIO=?,      \n";
         $sql.="  DEPENDIENTES=?,      \n";
         $sql.="  SINDICALIZADO=?,     \n";
         $sql.="  DIRECCION=?,         \n";
         $sql.="  CUIL=?,              \n";
         $sql.="  NACIMIENTO=?         \n";
         $sql.="WHERE      \n";
         $sql.="  EMPLEADO_ID=?     \n";
         $idUnico=$this->idUnico();
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("sssisiissss", $bean->getApellido(),$bean->getNombre(), $bean->getCategoriaId(),
         $bean->getTarjetaNumero(), $bean->getFechaInicioLarga(),  $bean->getDependientes(), $bean->isSindicalizado(),
         $bean->getDireccion(), $bean->getCuil(), $bean->getNacimientoLarga(), $bean->getId());
         $res=$this->ejecutaYCierra($conexion, $stm);
         return $res;
      }

      public function borra($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM EMPLEADOS \n";
         $sql.="WHERE      \n";
         $sql.="  EMPLEADO_ID=?     \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         $res=$this->ejecutaYCierra($conexion, $stm);
         return $res;
      }

      public function inhabilita($id){
         $conexion=$this->conectarse();
         $sql="UPDATE EMPLEADOS SET HABILITADO=0 \n";
         $sql.="WHERE      \n";
         $sql.="  EMPLEADO_ID=?     \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         $res=$this->ejecutaYCierra($conexion, $stm);
         return $res;
      }




      public function selPorComienzoCuenta($cadena){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) FROM EMPLEADOS ";
         $sql.="WHERE  \n";
         $sql.="  HABILITADO=1  \n";
         $sql.="  AND UPPER(CONCAT(EMPLEADO_APELLIDO, ', ', EMPLEADO_NOMBRE)) LIKE '". strtoupper($cadena)  . "%'  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }


      public function selTodos($desde, $cuantos, $apellido){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  EMP.EMPLEADO_ID,     \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,    \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,    \n";
         $sql.="  EMP.CATEGORIA_ID,    \n";
         $sql.="  CAT.CATEGORIA_NOMBRE,    \n";
         $sql.="  EMP.TARJETA_NUMERO,    \n";
         $sql.="  EMP.FECHA_INICIO,    \n";
         $sql.="  EMP.SINDICALIZADO,    \n";
         $sql.="  EMP.DEPENDIENTES,    \n";
         $sql.="  EMP.DIRECCION,    \n";
         $sql.="  EMP.CUIL,    \n";
         $sql.="  EMP.NACIMIENTO    \n";
         $sql.="FROM  \n";
         $sql.="  EMPLEADOS  EMP \n";
         $sql.="  INNER JOIN CATEGORIAS_LABORALES CAT ON EMP.CATEGORIA_ID=CAT.CATEGORIA_LABORAL_ID \n";
         $sql.="WHERE  \n";
         $sql.="  EMP.HABILITADO=1  \n";
         if (!empty($apellido)){
         	$sql.="  AND UPPER(EMPLEADO_APELLIDO) LIKE '%" . mb_strtoupper($apellido, 'utf-8')   . "%'  \n";
         }
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $nombre=null;
         $apellido=null;
         $categoriaId=null;
         $categoriaNombre=null;
         $tarjetaNumero=null;
         $fechaInicio=null;
         $sindicalizado=null;
         $dependientes=null;
         $direccion=null;
         $cuil=null;
         $nacimiento=null;
         $stm->bind_result($id, $apellido, $nombre, $categoriaId, $categoriaNombre, $tarjetaNumero, $fechaInicio, $sindicalizado, $dependientes, $direccion, $cuil, $nacimiento);
         $filas=array();
         while ($stm->fetch()) {
            $bean=new Empleado();
         	$bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setApellido($apellido);
            $bean->setCategoriaId($categoriaId);
            $bean->setCategoriaNombre($categoriaNombre);
            $bean->setTarjetaNumero($tarjetaNumero);
            $bean->setFechaInicioLarga($fechaInicio);
            $bean->setSindicalizado($sindicalizado);
            $bean->setDependientes($dependientes);
            $bean->setDireccion($direccion);
            $bean->setCuil($cuil);
            $bean->setNacimientoLarga($nacimiento);
         	$filas[]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }

      public function selTodosCuenta($apellido){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) FROM EMPLEADOS   \n";
         $sql.="WHERE HABILITADO=1   \n";
         if (!empty($apellido)){
         	$sql.="  AND UPPER(EMPLEADO_APELLIDO) LIKE '%" . mb_strtoupper($apellido, 'utf-8')   . "%'  \n";
         }
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }



      public function selHorarioActual($empleadoId){
      	$conexion=$this->conectarse();
        $sql="SELECT    \n";
        $sql.="  HPE.PERIODO_COMIENZO,    \n";
        $sql.="  HPE.PERIODO_FIN    \n";
        $sql.="FROM     \n";
        $sql.="  HORARIOS_PERIODOS HPE    \n";
        $sql.="  INNER JOIN HORARIOS HOR ON HPE.HORARIO_ID=HOR.HORARIO_ID    \n";
        $sql.="  INNER JOIN HORARIOS_EMPLEADOS HEM ON HOR.HORARIO_ID=HEM.HORARIO_ID    \n";
        $sql.="  INNER JOIN EMPLEADOS EMP ON HEM.EMPLEADO_ID=EMP.EMPLEADO_ID    \n";
        $sql.="WHERE    \n";
        $sql.="  EMP.EMPLEADO_ID='" .  $empleadoId . "'    \n";
        $sql.="  AND HEM.HOREMP_EFECTIVO_DESDE=    \n";
        $sql.="   (SELECT    \n";
        $sql.="    MAX(HEM2.HOREMP_EFECTIVO_DESDE) FROM HORARIOS_EMPLEADOS HEM2    \n";
        $sql.="    WHERE HEM2.HOREMP_EFECTIVO_DESDE <= CURRENT_DATE    \n";
        $sql.="    AND HEM2.EMPLEADO_ID=HEM.EMPLEADO_ID)    \n";
        $sql.="ORDER BY    \n";
        $sql.="  HPE.PERIODO_ORDEN    \n";
        $stm=$this->preparar($conexion, $sql);
        $stm->execute();
        $periodoComienzo=null;
        $periodoFin=null;
        $stm->bind_result($periodoComienzo, $periodoFin);
        $filas = array();
        while ($stm->fetch()) {
            $fila=array();
            $fila['periodoComienzo']=$periodoComienzo;
            $fila['periodoFin']=$periodoFin;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;

      }


   }
?>