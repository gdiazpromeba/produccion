<?php
require_once '../../config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/FichasOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Ficha.php';

class FichasOadImpl extends AOD implements FichasOad {

  public function obtiene($id) {
    $conexion = $this->conectarse();
    $sql = "SELECT  \n";
    $sql .= "  FICHA_ID,     \n";
    $sql .= "  PIEZA_FICHA,     \n";
    $sql .= "  FICHA_CONTENIDO    \n";
    $sql .= "FROM  \n";
    $sql .= "  FICHAS  \n";
    $sql .= "WHERE  \n";
    $sql .= "  FICHA_ID='" . $id . "' \n";
    $stm = $this->preparar($conexion, $sql);
    $stm->execute();
    $bean = new Ficha();
    $id = null;
    $ficha = null;
    $contenido = null;
    $stm->bind_result($id, $ficha, $contenido);
    if ($stm->fetch()) {
      $bean->setId($id);
      $bean->setFicha($ficha);
      $bean->setContenido($contenido);
    }
    $this->cierra($conexion, $stm);
    return $bean;
  }

  public function inserta($bean) {
    $conexion = $this->conectarse();
    $sql = "INSERT INTO FICHAS (   \n";
    $sql .= "  FICHA_ID,     \n";
    $sql .= "  PIEZA_FICHA,     \n";
    $sql .= "  FICHA_CONTENIDO)    \n";
    $sql .= "VALUES (?, ?, ?)    \n";
    $nuevoId = $this->idUnico();
    $bean->setId($nuevoId);
    $stm = $this->preparar($conexion, $sql);
    $stm->bind_param("sis", $bean->getId(), $bean->getFicha(), $bean->getContenido());
    return $this->ejecutaYCierra($conexion, $stm, $nuevoId);
  }

  public function borra($id) {
    $conexion = $this->conectarse();
    $sql = "DELETE FROM FICHAS   \n";
    $sql .= "WHERE FICHA_ID=?   \n";
    $stm = $this->preparar($conexion, $sql);
    $stm->bind_param("s", $id);
    return $this->ejecutaYCierra($conexion, $stm);
  }

  public function actualiza($bean) {
    $conexion = $this->conectarse();
    $sql = "UPDATE FICHAS SET   \n";
    $sql .= "  PIEZA_FICHA=?,     \n";
    $sql .= "  FICHA_CONTENIDO=?     \n";
    $sql .= "WHERE FICHA_ID=?   \n";
    $stm = $this->preparar($conexion, $sql);
    $stm->bind_param("iss", $bean->getFicha(), $bean->getContenido(), $bean->getId());
    return $this->ejecutaYCierra($conexion, $stm);
  }

  public function selPorComienzo($cadena, $desde, $cuantos) {
    $conexion = $this->conectarse();
    $sql = "SELECT  \n";
    $sql .= "  FICHA_ID,     \n";
    $sql .= "  PIEZA_FICHA,     \n";
    $sql .= "  FICHA_CONTENIDO    \n";
    $sql .= "FROM  \n";
    $sql .= "  FICHAS  \n";
    $sql .= "WHERE  \n";
    $sql .= " PIEZA_FICHA LIKE ?  \n";
    $sql .= "ORDER BY  \n";
    $sql .= "  PIEZA_FICHA  \n";
    $sql .= "LIMIT ?, ?  \n";
    $stm = $conexion->prepare($sql);
    $comienzo = strtoupper($cadena) . "%";
    $stm->bind_param('sii', $comienzo, $desde, $cuantos);
    $stm->execute();
    $id = null;
    $ficha = null;
    $contenido = null;
    $stm->bind_result($id, $ficha, $contenido);
    $filas = array ();
    while ($stm->fetch()) {
      $bean = new Ficha();
      $bean->setId($id);
      $bean->setFicha($ficha);
      $bean->setContenido($contenido);
      $filas[$id] = $bean;
    }
    $this->cierra($conexion, $stm);
    return $filas;
  }

  public function selPorComienzoCuenta($cadena) {
    $conexion = $this->conectarse();
    $sql = "SELECT COUNT(*) FROM FICHAS ";
    $sql.= "WHERE  \n";
    $sql.= "PIEZA_FICHA LIKE '" . $cadena . "%'  \n";
    $stm = $this->preparar($conexion, $sql);
    $stm->execute();
    $cuenta = null;
    $stm->bind_result($cuenta);
    $stm->fetch();
    $this->cierra($conexion, $stm);
    return $cuenta;
  }

  public function selTodos($desde, $cuantos, $numeroOParte, $parteContenido) {
    $conexion = $this->conectarse();
    $sql = "SELECT  \n";
    $sql .= "  FICHA_ID,     \n";
    $sql .= "  PIEZA_FICHA,     \n";
    $sql .= "  FICHA_CONTENIDO    \n";
    $sql .= "FROM  \n";
    $sql .= "  FICHAS  \n";
    $sql .= "WHERE  \n";
    $sql .= " 1=1  \n";
    if (!empty ($numeroOParte)) {
      $sql .= " AND PIEZA_FICHA LIKE '%" . $numeroOParte . "%'  \n";
    }
    if (!empty ($parteContenido)) {
      $sql .= " AND FICHA_CONTENIDO LIKE '%" . $parteContenido . "%'  \n";
    }
    $sql .= "ORDER BY  \n";
    $sql .= "  PIEZA_FICHA  \n";
    $sql .= "LIMIT " . $desde . ", " . $cuantos . "  \n";
    $stm = $this->preparar($conexion, $sql);
    $stm->execute();
    $id = null;
    $ficha = null;
    $contenido = null;
    $stm->bind_result($id, $ficha, $contenido);
    $filas = array ();
    while ($stm->fetch()) {
      $bean = new Ficha();
      $bean->setId($id);
      $bean->setFicha($ficha);
      $bean->setContenido($contenido);
      $filas[$id] = $bean;
    }
    $this->cierra($conexion, $stm);
    return $filas;
  }

  public function selTodosCuenta($numeroOParte, $parteContenido) {
    $conexion = $this->conectarse();
    $sql = "SELECT COUNT(*) FROM FICHAS ";
    $sql .= "WHERE  \n";
    $sql .= " 1=1  \n";
    if (!empty ($numeroOParte)) {
      $sql .= " AND PIEZA_FICHA LIKE '%" . $numeroOParte . "%'  \n";
    }
    if (!empty ($parteContenido)) {
      $sql .= " AND FICHA_CONTENIDO LIKE '%" . $parteContenido . "%'  \n";
    }
    $stm = $this->preparar($conexion, $sql);
    $stm->execute();
    $cuenta = null;
    $stm->bind_result($cuenta);
    $stm->fetch();
    $this->cierra($conexion, $stm);
    return $cuenta;
  }

}
?>