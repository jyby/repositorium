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

	function testFindDocumentsByTags() {
		$doc1 = array(
			'Documento' => array(
				'titulo' => 'Doc1',
				'texto' => 'contenido',
				'tags' => 'one,two,three'
			)
		);
		
		$doc2 = array(
			'Documento' => array(
				'titulo' => 'Doc2',
				'texto' => 'contenido',
				'tags' => 'one,three'
			)
		);
		
		$doc3 = array(
			'Documento' => array(
				'titulo' => 'Doc3',
				'texto' => 'contenido',
				'tags' => 'two,three'
			)
		);
		
		$doc4 = array(
			'Documento' => array(
				'titulo' => 'Doc4',
				'texto' => 'contenido',
			)
		);
		
		$this->Tag->Documento->saveWithTags($doc1);
		$this->Tag->Documento->saveWithTags($doc2);
		$this->Tag->Documento->saveWithTags($doc3);
		$this->Tag->Documento->saveWithTags($doc4);
		
		//pr($this->Tag->find('all'));
		
		$set1 = $this->Tag->findDocumentsByTags(array('one','two','three'));
		$set2 = $this->Tag->findDocumentsByTags(array('three'));
		$set3 = $this->Tag->findDocumentsByTags(array('two'));
		$set4 = $this->Tag->findDocumentsByTags(array('one'));
		$set5 = $this->Tag->findDocumentsByTags(array());
		
		$set6 = $this->Tag->findDocumentsByTags(array('one', 'three'));
		$set7 = $this->Tag->findDocumentsByTags(array('one', 'two'));
		$set8 = $this->Tag->findDocumentsByTags(array('two', 'three'));

		//pr($this->Tag->Documento->find('all', array('recursive' => -1	)));
		//pr($this->Tag->find('all', array('recursive' => -1	)));
		
		$this->assertEqual(count($set1), 1, "looking for all tags matches 1 document. [%s]");
		$this->assertEqual(count($set2), 3, "looking for \"three\" matches 3 documents. [%s]");
		$this->assertEqual(count($set3), 2, "looking for \"two\" matches 2 documents. [%s]");
		$this->assertEqual(count($set4), 2, "looking for \"one\" matches 2 documents. [%s]");
		$this->assertEqual(count($set5), 4, "looking for nothing yield all documents. [%s]");
		
		$this->assertEqual(count($set6), 2, "looking for \"one\" and \"three\" matches 2 documents. [%s]");
		$this->assertEqual(count($set7), 1, "looking for \"one\" and \"two\" matches 1 document. [%s]");
		$this->assertEqual(count($set8), 2, "looking for \"two\" and \"three\" matches 2 documents. [%s]");
				
	}

}
?>