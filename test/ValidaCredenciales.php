<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/UsuarioSvcImpl.php';
	
	$usu = new Usuario();
	$uid = "usuario" . rand();
	$usu->setUsuario($uid);
	$usu->setClave("manuela");
	$usu->setNombre("Nombre del usuario");
	
	$usv = new UsuarioSvcImpl();
	
	$usv->insUsuario($usu);
	
	// Create a handler function
	function my_assert_handler($file, $line, $code) {
		echo "<hr>Assertion Failed:
		        File '$file'<br />
		        Line '$line'<br />
		        Code '$code'<br /><hr />";
	}
	
	// Set up the callback
	assert_options(ASSERT_CALLBACK, 'my_assert_handler');
	
	//debe fallar porque la clave es "manuela" 
	assert(!$usv->validaUsuario($uid, "nomanuela"));
	
	//no debe fallar porque la clave es "manuela" 
	assert($usv->validaUsuario($uid, "manuela"));
	echo "test finalizado";
	
	//limpieza
	$usv->borUsuario($usu->getId());
?>
