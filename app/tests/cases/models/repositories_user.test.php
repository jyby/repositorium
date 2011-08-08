<?php
/* RepositoriesUser Test cases generated on: 2011-08-06 19:13:15 : 1312672395*/
App::import('Model', 'RepositoriesUser');

class RepositoriesUserTestCase extends CakeTestCase {
	var $fixtures = array('app.repositories_user', 'app.repository', 'app.user', 'app.criteria', 'app.document', 'app.tag', 'app.criterias_document', 'app.criterias_user', 'app.expert', 'app.tag');

	function startTest() {
		$this->RepositoriesUser =& ClassRegistry::init('RepositoriesUser');
	}

	function endTest() {
		unset($this->RepositoriesUser);
		ClassRegistry::flush();
	}
	
	function testAddPoints() {
		$user_id = 1;
		$points = 10;
		$repository_id = 1;
		
		$result = $this->RepositoriesUser->addPoints($user_id, $repository_id, $points);
		$ru = $this->RepositoriesUser->find('first', array('conditions' => compact('user_id', 'repository_id'), 'recursive' => -1));
				
		$this->assertTrue($result);
		$this->assertTrue($ru['RepositoriesUser']['points'] == 20);
	}
	
	function testDiscountPoints() {
		$user_id = 1;
		$points = 10;
		$repository_id = 1;
		
		$result = $this->RepositoriesUser->discountPoints($user_id, $repository_id, $points);
		$ru = $this->RepositoriesUser->find('first', array('conditions' => compact('user_id', 'repository_id'), 'recursive' => -1));
		
		$this->assertTrue($result);
		$this->assertTrue($ru['RepositoriesUser']['points'] == 0);
	}
	
	function testDiscountPointsNegative() {
		$user_id = 1;
		$points = 20;
		$repository_id = 1;
		
		$result = $this->RepositoriesUser->discountPoints($user_id, $repository_id, $points);
		$ru = $this->RepositoriesUser->find('first', array('conditions' => compact('user_id', 'repository_id'), 'recursive' => -1));
		
		$this->assertFalse($result);
		$this->assertTrue($ru['RepositoriesUser']['points'] == 10);
	}

}
?>