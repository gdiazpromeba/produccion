<?php
/*
 * Created on 01/11/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ClienteCampo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FormatoCampo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/FormatoCampoOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ClienteCampoOadImpl.php';

 
   

   
   $svcCC=new ClienteCampoOadImpl();
   $svcFC=new FormatoCampoOadImpl();
   
   
   //cuenta original
   $cuenta=$svcCC->selTodosCuenta();
   echo "cuenta original OK<br/>";
   
   $arrFC=$svcFC->selTodos(0,1);
   $beanFC=array_pop($arrFC);
   echo "obtenci�n de un formato OK<br/>";
   
   //prueba inserci�n (necesita que exista al menos 1 formatoCampo)
   $bean=new ClienteCampo();
   $bean->setNombre("Campo de cliente de prueba");
   $bean->setClaveRecurso("campo_prueba");
   $bean->setFormato($beanFC);
   
   $svcCC->inserta($bean);
   echo "inserci�n OK<br/>";
   
   //prueba modificaci�n
   $bean->setNombre("xx");
   $svcCC->actualiza($bean);
   echo "actualizaci�n OK<br/>";
   
   //prueba obtenci�n individual
   $bean2=$svcCC->obtienePorId($bean->getId());
   assert($bean2->getNombre()==$bean->getNombre());
   echo "obtenci�n individual OK<br/>";
   
   //prueba borrado
   $svcCC->borra($bean2->getId());
   $cuenta2=$svcCC->selTodosCuenta();
   assert($cuenta2==$cuenta); //despu�s de haber insertado y borrado uno, queda la misma cantidad
   echo "borrado OK<br/>";
   
   //prueba obtenci�n de todo
   $svcCC->selTodos(0, 10);
   echo "selecci�n de todos OK<br/>";
   
   echo "fin del test";
   

?>
