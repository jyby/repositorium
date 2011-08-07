<?php
/* User Test cases generated on: 2011-08-06 19:15:12 : 1312672512*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.document', 'app.repository', 'app.repositories_user', 'app.criteria', 'app.criterias_document', 'app.criterias_user', 'app.expert', 'app.tag', 'app.tag');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

}
?>