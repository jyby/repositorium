<?php
/* Criterio Test cases generated on: 2011-07-27 19:18:20 : 1311808700*/
App::import('Model', 'Criterio');

class CriterioTestCase extends CakeTestCase {
	var $fixtures = array('app.documento', 'app.criterio', 'app.tamano_desafio', 'app.usuario', 'app.informacion_desafio', 'app.tag', 'app.experto');

	function startTest() {
		$this->Criterio =& ClassRegistry::init('Criterio');	
	}	

	function endTest() {
		unset($this->Criterio);		
		ClassRegistry::flush();
	}

}
?>