<?php
interface UsuarioSvc{
	public function obtUsuarioPorId($id);
	public function obtUsuarioPorUid($uid);
	public function insUsuario($usuario);
	public function borUsuario($id);
	public function inhabilita($id);
	public function actUsuario($usuario);
	public function selTodosCuenta($nombreOParte, $grupoId);
	public function selTodos($desde, $cuantos, $nombreOParte, $grupoId);
	public function validaUsuario($login, $clave);
}
?>
