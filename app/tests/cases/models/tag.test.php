<?php
/* Tag Test cases generated on: 2011-08-06 19:19:50 : 1312672790*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $fixtures = array('app.tag', 'app.document', 'app.user', 'app.expert', 'app.repository', 'app.repositories_user', 'app.criteria', 'app.criterias_document', 'app.criterias_user');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}
	
	function testFindDocumentsByTags() {
		$repo_id = 42;
		
		$doc1 = array(
			'Document' => array(
				'title' => 'Doc1',
				'content' => 'contenido',
				'tags' => 'one,two,three',
				'user_id' => 42,
				'repository_id' => $repo_id,
			)
		);
	
		$doc2 = array(
			'Document' => array(
				'title' => 'Doc2',
				'content' => 'contenido',
				'tags' => 'one,three',
				'user_id' => 42,
				'repository_id' => $repo_id,
			)
		);
	
		$doc3 = array(
			'Document' => array(
				'title' => 'Doc3',
				'content' => 'contenido',
				'tags' => 'two,three',
				'user_id' => 42,
				'repository_id' => $repo_id,
			)
		);
	
		$doc4 = array(
			'Document' => array(
				'title' => 'Doc4',
				'content' => 'contenido',
				'user_id' => 42,
				'repository_id' => $repo_id,
			)
		);
		
		// no deberia ser encontrado ninguna vez
		$doc5 = array(
			'Document' => array(
				'title' => 'Doc4',
				'content' => 'contenido',
				'user_id' => 42,
				'repository_id' => ($repo_id+1),
			)
		);
	
		$this->Tag->Document->saveWithTags($doc1);
		$this->Tag->Document->saveWithTags($doc2);
		$this->Tag->Document->saveWithTags($doc3);
		$this->Tag->Document->saveWithTags($doc4);
	
		$set1 = $this->Tag->findDocumentsByTags($repo_id, array('one','two','three'));
		$set2 = $this->Tag->findDocumentsByTags($repo_id, array('three'));
		$set3 = $this->Tag->findDocumentsByTags($repo_id, array('two'));
		$set4 = $this->Tag->findDocumentsByTags($repo_id, array('one'));
		$set5 = $this->Tag->findDocumentsByTags($repo_id, array());
	
		$set6 = $this->Tag->findDocumentsByTags($repo_id, array('one', 'three'));
		$set7 = $this->Tag->findDocumentsByTags($repo_id, array('one', 'two'));
		$set8 = $this->Tag->findDocumentsByTags($repo_id, array('two', 'three'));
	
		$this->assertEqual(count($set1), 1, "looking for all tags matches 1 document. [%s]");
		$this->assertEqual(count($set2), 3, "looking for \"three\" matches 3 documents. [%s]");
		$this->assertEqual(count($set3), 2, "looking for \"two\" matches 2 documents. [%s]");
		$this->assertEqual(count($set4), 2, "looking for \"one\" matches 2 documents. [%s]");
		$this->assertEqual(count($set5), 3, "looking for nothing yield 3 documents. [%s]");

		$this->assertEqual(count($set6), 2, "looking for \"one\" and \"three\" matches 2 documents. [%s]");
		$this->assertEqual(count($set7), 1, "looking for \"one\" and \"two\" matches 1 document. [%s]");
		$this->assertEqual(count($set8), 2, "looking for \"two\" and \"three\" matches 2 documents. [%s]");
	
	}

	function endTest() {
		unset($this->Tag);
		ClassRegistry::flush();
	}

}
?>