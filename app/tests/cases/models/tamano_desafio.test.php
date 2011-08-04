<?php
/* TamanoDesafio Test cases generated on: 2011-07-27 20:20:47 : 1311812447*/
App::import('Model', 'TamanoDesafio');

class TamanoDesafioTestCase extends CakeTestCase {
	var $fixtures = array('app.tamano_desafio', 'app.usuario', 'app.documento', 'app.informacion_desafio', 'app.criterio', 'app.tag', 'app.experto');

	function startTest() {
		$this->TamanoDesafio =& ClassRegistry::init('TamanoDesafio');
	}
	
	function testMassCreateAfterCriteria() {
		$id_criterio = 42;
		$this->TamanoDesafio->massCreateAfterCriteria($id_criterio, 1);
		
		$users = $this->TamanoDesafio->Usuario->find('all', array(
			'fields' => 'Usuario.id_usuario',
			'recursive' => -1,
			'order' => 'Usuario.id_usuario'
			)
		);
		
		$tds = $this->TamanoDesafio->find('all', array(
			'conditions' => array('TamanoDesafio.id_criterio' => $id_criterio), 
			'fields' => 'Usuario.id_usuario', 
			'order' => 'Usuario.id_usuario'
			)
		);
		
		$this->assertEqual($tds, $users);
	}
	
	
	function testGetC() {
		$user_id = 1;
		$criteria_id = 1;
		
		$c = $this->TamanoDesafio->getC($user_id, $criteria_id);
		
		$this->assertNotNull($c);		
		$this->assertTrue($c >= 0);		
		
		
		$user_id = 4;
		$criteria_id = 1;
		
		$c = $this->TamanoDesafio->getC($user_id, $criteria_id);
		
		$this->assertNull($c);
	}
	
	function testsaveNextCChallengeCorrect() {
		$user_id = 1;
		$criteria_id = 1;		
		$c = $this->TamanoDesafio->getC($user_id, $criteria_id); // 5
		
//		c = 5
// 		'funcion_penalizacion_a' => 1.5,
// 		'funcion_penalizacion_b' => 0.5,
// 		'funcion_despenalizacion_a' => 1,
// 		'funcion_despenalizacion_b' => -1,
// 		'tamano_minimo_desafio' => 3

		$this->TamanoDesafio->saveNextC($user_id, $criteria_id, $challengeCorrect = true);
		
		$this->assertTrue( $this->TamanoDesafio->getC($user_id, $criteria_id) == 4 );		
	}
	
	function testsaveNextCChallengeIncorrect() {
		$user_id = 1;
		$criteria_id = 1;
		$c = $this->TamanoDesafio->getC($user_id, $criteria_id); // 5
	
		//		c = 5
		// 		'funcion_penalizacion_a' => 1.5,
		// 		'funcion_penalizacion_b' => 0.5,
		// 		'funcion_despenalizacion_a' => 1,
		// 		'funcion_despenalizacion_b' => -1,
		// 		'tamano_minimo_desafio' => 3
	
		$this->TamanoDesafio->saveNextC($user_id, $criteria_id, $challengeCorrect = false);
	
		$this->assertTrue( $this->TamanoDesafio->getC($user_id, $criteria_id) == 8 );
	}
	
	// in case that new_c < min_c
	function testsaveNextCChallengeBoundary() {
		$user_id = 1;
		$criteria_id = 2;
		$c = $this->TamanoDesafio->getC($user_id, $criteria_id); // 5
	
//		c = 5
// 		'funcion_penalizacion_a' => 1.5,
// 		'funcion_penalizacion_b' => 0.5,
// 		'funcion_despenalizacion_a' => 1,
// 		'funcion_despenalizacion_b' => -1,
// 		'tamano_minimo_desafio' => 5
	
		$this->TamanoDesafio->saveNextC($user_id, $criteria_id, $challengeCorrect = true);
	
		$this->assertTrue( $this->TamanoDesafio->getC($user_id, $criteria_id) == 5 );
	}
	
	function endTest() {
		unset($this->TamanoDesafio);
		ClassRegistry::flush();
	}

}
?>