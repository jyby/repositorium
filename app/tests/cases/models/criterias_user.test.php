<?php
/* CriteriasUser Test cases generated on: 2011-08-06 19:05:14 : 1312671914*/
App::import('Model', 'CriteriasUser');

class CriteriasUserTestCase extends CakeTestCase {
	var $fixtures = array('app.criterias_user', 'app.user', 'app.criteria', 'app.repository', 'app.document', 'app.criterias_document', 'app.tag', 'app.expert', 'app.repositories_user');

	function startTest() {
		$this->CriteriasUser =& ClassRegistry::init('CriteriasUser');
	}

	function testMassCreateAfterCriteria() {
		$id_criterio = 42;
		$this->CriteriasUser->massCreateAfterCriteria($id_criterio, $minchallenge_size = 1);
	
		$users = $this->CriteriasUser->User->find('all', array(
				'fields' => 'User.id',
				'recursive' => -1,
				'order' => 'User.id'
			)
		);
	
		$tds = $this->CriteriasUser->find('all', array(
				'conditions' => array('CriteriasUser.criteria_id' => $id_criterio), 
				'fields' => 'User.id', 
				'order' => 'User.id'
			)
		);
	
		$this->assertEqual($tds, $users);
	}
	
	function testMassCreateAfterUser() {
		$user_id = 5;
		$this->CriteriasUser->massCreateAfterUser($user_id);
		
		$criterias = $this->CriteriasUser->Criteria->find('all', array(
			'fields' => array('Criteria.id'), // 'Criteria.minchallenge_size'),
			'recursive' => -1,
			'order' => 'Criteria.id' 
			)		
		);
		
		$tds = $this->CriteriasUser->find('all', array(
			'conditions' => array('CriteriasUser.user_id' => $user_id),
			'fields' => array('Criteria.id'),// 'CriteriasUser.challenge_size'),
			'order' => 'Criteria.id'
			)
		);
		
// 		pr($criterias); pr($tds); exit;
		$this->assertEqual($criterias, $tds);
	}
	
	function testGetC() {
		$user_id = 1;
		$criteria_id = 1;
	
		$c = $this->CriteriasUser->getC($user_id, $criteria_id);
	
		$this->assertNotNull($c);
		$this->assertTrue($c >= 0);
	
	
		$user_id = 4;
		$criteria_id = 1;
	
		$c = $this->CriteriasUser->getC($user_id, $criteria_id);
	
		$this->assertNull($c);
	}
	
	function testsaveNextCChallengeCorrect() {
		$user_id = 1;
		$criteria_id = 1;
		$c = $this->CriteriasUser->getC($user_id, $criteria_id); // 5
	
		//		c = 5
		// 		'funcion_penalizacion_a' => 1.5,
		// 		'funcion_penalizacion_b' => 0.5,
		// 		'funcion_despenalizacion_a' => 1,
		// 		'funcion_despenalizacion_b' => -1,
		// 		'tamano_minimo_desafio' => 3
	
		$this->CriteriasUser->saveNextC($user_id, $criteria_id, $challengeCorrect = true);
	
		$this->assertTrue( $this->CriteriasUser->getC($user_id, $criteria_id) == 4 );
	}
	
	function testsaveNextCChallengeIncorrect() {
		$user_id = 1;
		$criteria_id = 1;
		$c = $this->CriteriasUser->getC($user_id, $criteria_id); // 5
	
		//		c = 5
		// 		'funcion_penalizacion_a' => 1.5,
		// 		'funcion_penalizacion_b' => 0.5,
		// 		'funcion_despenalizacion_a' => 1,
		// 		'funcion_despenalizacion_b' => -1,
		// 		'tamano_minimo_desafio' => 3
	
		$this->CriteriasUser->saveNextC($user_id, $criteria_id, $challengeCorrect = false);
	
		$this->assertTrue( $this->CriteriasUser->getC($user_id, $criteria_id) == 8 );
	}
	
	// in case that new_c < min_c
	function testsaveNextCChallengeBoundary() {
		$user_id = 1;
		$criteria_id = 2;
		$c = $this->CriteriasUser->getC($user_id, $criteria_id); // 5
	
		//		c = 5
		// 		'funcion_penalizacion_a' => 1.5,
		// 		'funcion_penalizacion_b' => 0.5,
		// 		'funcion_despenalizacion_a' => 1,
		// 		'funcion_despenalizacion_b' => -1,
		// 		'tamano_minimo_desafio' => 5
	
		$this->CriteriasUser->saveNextC($user_id, $criteria_id, $challengeCorrect = true);
	
		$this->assertTrue( $this->CriteriasUser->getC($user_id, $criteria_id) == 5 );
	}
	
	function endTest() {
		unset($this->CriteriasUser);
		ClassRegistry::flush();
	}

}
?>