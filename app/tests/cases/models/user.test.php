<?php
/* User Test cases generated on: 2011-08-07 18:31:57 : 1312756317*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.document', 'app.repository', 'app.repositories_user', 'app.criteria', 'app.criterias_document', 'app.criterias_user', 'app.expert', 'app.tag');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

	function testRegister() {
		$data = array(
			'User' => array(
				'email' => 'test@example.com',
				'first_name' => 'Foo',
				'last_name' => 'Bar',
				'password' => 'macoy123',
				'is_administrator' => true,
			)
		);
		
		$registered = $this->User->register($data);
		
		$this->assertTrue($registered);
		
		$user = $this->User->find('first', array('conditions'=>array('User.email' => 'test@example.com')));
		
		$this->assertNotNull($user);
		$this->assertFalse($user['User']['is_administrator']);
		$this->assertFalse(strcmp($user['User']['password'], $data['User']['password']) == 0);
	}

	function testGetUser() {
		$data = array(
			'User' => array(
				'email' => 'test2@example.com', // from fixture
				'password' => 'macoy123' 
			)
		);
		
		$user = $this->User->getUser($data);
		
		$this->assertNotNull($user);
		$this->assertTrue(strcmp($user['User']['first_name'], 'Foo') == 0);
	}

}
?>