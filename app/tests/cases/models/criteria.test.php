<?php
/* Criteria Test cases generated on: 2011-08-06 18:58:16 : 1312671496*/
App::import('Model', 'Criteria');

class CriteriaTestCase extends CakeTestCase {
	var $fixtures = array('app.criteria', 'app.repository', 'app.document', 'app.criterias_document', 'app.user', 'app.criterias_user', 'app.tag', 'app.expert', 'app.repositories_user');

	function startTest() {
		$this->Criteria =& ClassRegistry::init('Criteria');
	}
	
	function testGetRandomCriteria() {
		$result = $this->Criteria->getRandomCriteria();
	
		// 		there's no data so far
		// 		$this->assertNull($result);
	
		// test again
		$result = $this->Criteria->getRandomCriteria();
	
		$criterios = $this->Criteria->find('all', array('recursive' => -1));
		$this->assertTrue(in_array($result, $criterios));
	}
		
	function testGenerateChallenge() {
		$proportion = 0.5;
		$user_id = 2; // (s)he has c=5, therefore 5 questions
		$c = 5;
	
		$validated = ceil($c*$proportion);
		$nvalidated = floor($c*$proportion);
		$challenge = $this->Criteria->generateChallenge($user_id, $proportion);
	
		/* (aun?) no se puede garantizar de que hayan suficientes documentos */
		$this->assertTrue(5 >= count($challenge));
	}

	function endTest() {
		unset($this->Criteria);
		ClassRegistry::flush();
	}

}
?>