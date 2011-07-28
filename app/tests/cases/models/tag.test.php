<?php
/* Tag Test cases generated on: 2011-07-27 19:18:24 : 1311808704*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $fixtures = array('app.tag', 'app.documento', 'app.usuario', 'app.tamano_desafio', 'app.experto', 'app.informacion_desafio');

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