<?php
/* Expert Test cases generated on: 2011-08-06 19:06:53 : 1312672013*/
App::import('Model', 'Expert');

class ExpertTestCase extends CakeTestCase {
	var $fixtures = array('app.expert', 'app.user', 'app.repository', 'app.repositories_user');

	function startTest() {
		$this->Expert =& ClassRegistry::init('Expert');
	}

	function endTest() {
		unset($this->Expert);
		ClassRegistry::flush();
	}

}
?>