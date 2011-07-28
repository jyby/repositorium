<?php
/* InformacionDesafio Test cases generated on: 2011-07-27 20:20:54 : 1311812454*/
App::import('Model', 'InformacionDesafio');

class InformacionDesafioTestCase extends CakeTestCase {
	var $fixtures = array('app.informacion_desafio', 'app.documento', 'app.usuario', 'app.tamano_desafio', 'app.criterio', 'app.experto', 'app.tag');

	function startTest() {
		$this->InformacionDesafio =& ClassRegistry::init('InformacionDesafio');
	}
	
	function testMassCreateAfterCriteria() {
		$id_criterio = 42;
		$this->InformacionDesafio->massCreateAfterCriteria($id_criterio);
	
		$documents = $this->InformacionDesafio->Documento->find('all', array(
				'fields' => array('Documento.id_documento', 'Documento.autor'),
				'recursive' => -1,
				'order' => 'Documento.id_documento'
			)
		);
	
		$ids = $this->InformacionDesafio->find('all', array(
				'conditions' => array('InformacionDesafio.id_criterio' => $id_criterio), 
				'fields' => array('Documento.id_documento', 'Documento.autor'), 
				'order' => 'Documento.id_documento'
			)
		);
	
		$this->assertEqual($ids, $documents);
	}
	
	function testMassCreateAfterDocument() {
		$id_documento = 42;
		$this->InformacionDesafio->massCreateAfterDocument($id_documento);
		
		$crs = $this->InformacionDesafio->Criterio->find('all', array(
				'fields' => array('Criterio.id_criterio'),
				'recursive' => -1,
				'order' => 'Criterio.id_criterio'
			)
		);
		
		$ids = $this->InformacionDesafio->find('all', array(
				'conditions' => array('InformacionDesafio.id_documento' => $id_documento),
				'fields' => array('InformacionDesafio.id_criterio'),
				'order' => 'InformacionDesafio.id_criterio'
			)
		);		
		
		$this->assertEqual($ids, $crs);
	}

	function endTest() {
		unset($this->InformacionDesafio);
		ClassRegistry::flush();
	}

}
?>