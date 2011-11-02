<?php
/* CriteriasUser Fixture generated on: 2011-08-06 19:05:14 : 1312671914 */
class CriteriasUserFixture extends CakeTestFixture {
	var $name = 'CriteriasUser';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'criteria_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'challenge_size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'criteria_id' => 1,
			'challenge_size' => 5
		),
		array(
			'id' => 2,
			'user_id' => 2,
			'criteria_id' => 1,
			'challenge_size' => 6
		),
		array(
			'id' => 3,
			'user_id' => 1,
			'criteria_id' => 2,
			'challenge_size' => 5
		),
	);
}
?>