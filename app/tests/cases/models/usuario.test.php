<?php
/* Usuario Test cases generated on: 2011-07-27 21:06:27 : 1311815187*/
App::import('Model', 'Usuario');

class UsuarioTestCase extends CakeTestCase {
	var $fixtures = array('app.usuario', 'app.documento', 'app.informacion_desafio', 'app.criterio', 'app.tamano_desafio', 'app.tag', 'app.experto');

	function startTest() {
		$this->Usuario =& ClassRegistry::init('Usuario');
	}

	function endTest() {
		unset($this->Usuario);
		ClassRegistry::flush();
	}

	function testRegister() {

	}

	function testIniciarSesion() {

	}

}
?>