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

}
?>