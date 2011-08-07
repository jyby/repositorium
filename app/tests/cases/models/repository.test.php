<?php
/* Repository Test cases generated on: 2011-08-06 19:08:25 : 1312672105*/
App::import('Model', 'Repository');

class RepositoryTestCase extends CakeTestCase {
	var $fixtures = array('app.repository', 'app.user', 'app.repositories_user', 'app.criteria', 'app.document', 'app.tag', 'app.criterias_document', 'app.criterias_user', 'app.expert', 'app.tag');

	function startTest() {
		$this->Repository =& ClassRegistry::init('Repository');
	}

	function endTest() {
		unset($this->Repository);
		ClassRegistry::flush();
	}

}
?>