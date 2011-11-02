<?php
/* RepositoriesUser Fixture generated on: 2011-08-06 19:13:15 : 1312672395 */
class RepositoriesUserFixture extends CakeTestFixture {
	var $name = 'RepositoriesUser';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'repository_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'points' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'repository_id' => 1,
			'user_id' => 1,
			'points' => 10
		),
	);
}
?>