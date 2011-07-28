<?php
/* Tag Test cases generated on: 2011-07-27 21:06:06 : 1311815166*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $fixtures = array('app.tag', 'app.documento', 'app.usuario', 'app.tamano_desafio', 'app.criterio', 'app.informacion_desafio', 'app.experto');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function endTest() {
		unset($this->Tag);
		ClassRegistry::flush();
	}

	function testFindDocumentsByTag() {

	}

}
?>