<?php
/* Contexto Test cases generated on: 2011-07-27 19:18:27 : 1311808707*/
App::import('Model', 'Contexto');

class ContextoTestCase extends CakeTestCase {
	var $fixtures = array('app.contexto');

	function startTest() {
		$this->Contexto =& ClassRegistry::init('Contexto');
	}

	function endTest() {
		unset($this->Contexto);
		ClassRegistry::flush();
	}

}
?>