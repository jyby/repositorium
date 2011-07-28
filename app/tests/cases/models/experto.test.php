<?php
/* Experto Test cases generated on: 2011-07-27 19:18:11 : 1311808691*/
App::import('Model', 'Experto');

class ExpertoTestCase extends CakeTestCase {
	var $fixtures = array('app.experto', 'app.usuario', 'app.documento', 'app.informacion_desafio', 'app.tag', 'app.tamano_desafio');

	function startTest() {
		$this->Experto =& ClassRegistry::init('Experto');
	}

	function endTest() {
		unset($this->Experto);
		ClassRegistry::flush();
	}

}
?>