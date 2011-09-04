<?php
/* Repository Fixture generated on: 2011-08-06 19:08:24 : 1312672104 */
class RepositoryFixture extends CakeTestFixture {
	var $name = 'Repository';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'min_points' => array('type' => 'integer', 'null' => false, 'default' => 0),
		'download_cost' => array('type' => 'integer', 'null' => false, 'default' => 10),
		'upload_cost' => array('type' => 'integer', 'null' => false, 'default' => 10),
		'documentpack_size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'challenge_reward' => array('type' => 'integer', 'null' => false, 'default' => 0),				
// 		'active' => array('type' => 'boolean', 'null' => false, 'default' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'url' => 'repo1',
			'user_id' => 1,
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2011-08-06 19:08:24',
			'modified' => '2011-08-06 19:08:24',
			'min_points' => 10,
			'download_cost' => 10,
			'upload_cost' => 10,
			'documentpack_size' => 0,
			'challenge_reward' => 0,
		),
		array(
			'id' => 2,
			'name' => 'Asdf',
			'url' => 'repo2',
			'user_id' => 1,
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2011-08-06 19:08:24',
			'modified' => '2011-08-06 19:08:24',
			'min_points' => 10,
			'download_cost' => 10,
			'upload_cost' => 10,
			'documentpack_size' => 0,
			'challenge_reward' => 0,
		)
	);
}
?>