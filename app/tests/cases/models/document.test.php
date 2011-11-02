<?php
/* Document Test cases generated on: 2011-08-06 19:06:15 : 1312671975*/
App::import('Model', 'Document');

class DocumentTestCase extends CakeTestCase {
	var $fixtures = array('app.document', 'app.user', 'app.repository', 'app.tag', 'app.criteria', 'app.criterias_document', 'app.criterias_user', 'app.tag', 'app.expert', 'app.repositories_user');

	function startTest() {
		$this->Document =& ClassRegistry::init('Document');
	}
	
	function testSaveWithTags() {
		$data = array(
				'Document' => array(
					'title' => 'Lorem ipsum',
					'content' => 'floood',
					'tags' => 'one,two,three',
					'user_id' => 42,
					'repository_id' => 42,
			)
		);
	
		$this->Document->saveWithTags($data);
	
		$doc = $this->Document->findByContent('floood');
		$this->assertFalse(empty($doc), 'document saved');
	
		$tags = $this->Document->Tag->findAllByDocumentId($doc['Document']['id'], array('tag'));
		$expected = array(
			array('Tag' => array('tag' => 'one')),
			array('Tag' => array('tag' => 'two')),
			array('Tag' => array('tag' => 'three')),
		);
		$this->assertEqual($expected,$tags);
	}

	function endTest() {
		unset($this->Document);
		ClassRegistry::flush();
	}

}
?>