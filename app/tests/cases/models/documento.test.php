<?php
/* Documento Test cases generated on: 2011-07-27 21:05:23 : 1311815123*/
App::import('Model', 'Documento');

class DocumentoTestCase extends CakeTestCase {
	var $fixtures = array('app.documento', 'app.usuario', 'app.tamano_desafio', 'app.criterio', 'app.informacion_desafio', 'app.experto', 'app.tag');

	function startTest() {
		$this->Documento =& ClassRegistry::init('Documento');
	}

	function endTest() {
		unset($this->Documento);
		ClassRegistry::flush();
	}

	function testSaveWithTags() {
		$data = array(
			'Documento' => array(
				'titulo' => 'Lorem ipsum',
				'texto' => 'floood',
				'tags' => 'one,two,three'
			)			
		);
		
		$this->Documento->saveWithTags($data);
		
		$doc = $this->Documento->findByTexto('floood');
		$this->assertFalse(empty($doc), 'document saved');
		$tags = $this->Documento->Tag->findAllByIdDocumento($doc['Documento']['id_documento'], array('tag'));
		$expected = array(
			array('Tag' => array('tag' => 'one')),
			array('Tag' => array('tag' => 'two')),
			array('Tag' => array('tag' => 'three')),		
		);	
		
		$this->assertEqual($expected,$tags);
	}

}
?>