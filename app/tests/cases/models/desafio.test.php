<?php
/* Desafio Test cases generated on: 2011-08-01 19:40:36 : 1312242036*/
App::import('Model', 'Desafio');
App::import('Model', 'Criterio');

class DesafioTestCase extends CakeTestCase {
	var $fixtures = array('app.desafio', 'app.usuario');

	function startTest() {
		$this->Desafio =& ClassRegistry::init('Desafio');
		$this->Criterio =& ClassRegistry::init('Criterio');
	}
	



	function endTest() {
		unset($this->Desafio);
		unset($this->Criterio);
		ClassRegistry::flush();
	}

}
?>