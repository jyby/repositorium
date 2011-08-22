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
	
	function testMassCreateAfterRepository() {
		$repo_id = 2;

		$this->RepositoriesUser->massCreateAfterRepository($repo_id);
		
		$users = $this->RepositoriesUser->User->find('all', array(
			'fields' => array('User.id'),
 			'recursive' => -1
			)
		);
		
		$ru = $this->RepositoriesUser->find('all', array(
			'conditions' => array('repository_id' => $repo_id),
			'fields' => array('User.id'),
// 			'recursive' => -1,
			)
		);
		$this->assertEqual($users, $ru);
	}
	
	function testMassCreateAfterUser() {
		$user_id = 42;
	
		$this->RepositoriesUser->massCreateAfterUser($user_id);
	
		$users = $this->RepositoriesUser->Repository->find('all', array(
			'fields' => array('Repository.id'),
 			'recursive' => -1,
 			'order' => 'Repository.id'
			)
		);
	
		$ru = $this->RepositoriesUser->find('all', array(
			'conditions' => array('RepositoriesUser.user_id' => $user_id),
			'fields' => array('Repository.id'),
			'order' => 'Repository.id'
			)
		);
		
		$this->assertEqual($users, $ru);
	}

}
?>