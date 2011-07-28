<?php
/* Documento Test cases generated on: 2011-07-27 19:17:57 : 1311808677*/
App::import('Model', 'Documento');

class DocumentoTestCase extends CakeTestCase {
	var $fixtures = array('app.documento', 'app.usuario', 'app.tamano_desafio', 'app.experto', 'app.informacion_desafio', 'app.tag');

	function startTest() {
		$this->Documento =& ClassRegistry::init('Documento');
	}
	
	
	function endTest() {
		unset($this->Documento);
		ClassRegistry::flush();
	}

	function testSaveWithTag() {

	}

}
?>