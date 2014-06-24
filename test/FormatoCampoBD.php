<?php
/*
 * Created on 01/11/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FormatoCampo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/FormatoCampoOadImpl.php';
 
   

   
   $svc=new FormatoCampoOadImpl();
   
   //cuenta original
   $cuenta=$svc->selTodosCuenta();
   
   //prueba inserci�n
   $bean=new FormatoCampo();
   $bean->setNombre("Formato de campo de prueba");
   $bean->setTipo(FormatoCampo::TIPO_ALFANUMERICO);
   $bean->setLugaresDecimales(null);
   $bean->setLugaresEnteros(null);
   $bean->setAlineacion(1);
   $bean->setMascara(null);
   $svc->inserta($bean);
   echo "inserci�n OK<br/>";
   
   //prueba modificaci�n
   $bean->setNombre("xx");
   $svc->actualiza($bean);
   echo "actualizaci�n OK<br/>";
   
   //prueba obtenci�n individual
   $bean2=$svc->obtienePorId($bean->getId());
   assert($bean2->getNombre()==$bean->getNombre());
   echo "obtenci�n individual OK<br/>";
   
   //prueba borrado
   $svc->borra($bean2->getId());
   $cuenta2=$svc->selTodosCuenta();
   assert($cuenta2==$cuenta); //despu�s de haber insertado y borrado uno, queda la misma cantidad
   echo "borrado OK<br/>";
   
   //prueba obtenci�n de todo
   $svc->selTodos(0, 10);
   echo "selecci�n de todos OK<br/>";
   
   echo "fin del test";
   

?>
