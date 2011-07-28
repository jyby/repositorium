<?php
/* Usuario Test cases generated on: 2011-07-27 19:18:07 : 1311808687*/
App::import('Model', 'Usuario');

class UsuarioTestCase extends CakeTestCase {
	var $fixtures = array('app.usuario', 'app.documento', 'app.informacion_desafio', 'app.tag', 'app.tamano_desafio', 'app.experto');

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