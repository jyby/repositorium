<?php
/* Expert Fixture generated on: 2011-08-06 19:06:53 : 1312672013 */
class ExpertFixture extends CakeTestFixture {
	var $name = 'Expert';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'repository_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'active' => array('type' => 'integer', 'null' => false, 'default' => true, 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'repository_id' => 1,
			'created' => '2011-08-06 19:06:53',
			'modified' => '2011-08-06 19:06:53',
			'active' => 1
		),
	);
}
?>