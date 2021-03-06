<?php
/* Criteria Fixture generated on: 2011-08-06 18:58:16 : 1312671496 */
class CriteriaFixture extends CakeTestFixture {
	var $name = 'Criteria';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'repository_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'question' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'answer_1' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'answer_2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'documentpack_size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'documentpack_cost' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'documentupload_cost' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'documentvalidation_reward' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'challenge_reward' => array('type' => 'integer', 'null' => false, 'default' => 10),
		'penalization_a' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'penalization_b' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'depenalization_a' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'depenalization_b' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'minchallenge_size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'maxchallenge_size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'repository_id' => 1,
			'question' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'answer_1' => 'Lorem ipsum dolor sit amet',
			'answer_2' => 'Lorem ipsum dolor sit amet',
			'documentpack_size' => 1,
			'documentpack_cost' => 1,
			'documentupload_cost' => 1,
			'documentvalidation_reward' => 1,
			'penalization_a' => 1.5,
			'penalization_b' => 0.5,
			'depenalization_a' => 1,
			'depenalization_b' => -1,
			'minchallenge_size' => 3,
			'maxchallenge_size' => 1, // not used
			'created' => '2011-08-06 18:58:16',
			'modified' => '2011-08-06 18:58:16',
			'active' => 1
		),
		array(
			'id' => 2,
			'repository_id' => 1,
			'question' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'answer_1' => 'Lorem ipsum dolor sit amet',
			'answer_2' => 'Lorem ipsum dolor sit amet',
			'documentpack_size' => 1,
			'documentpack_cost' => 1,
			'documentupload_cost' => 1,
			'documentvalidation_reward' => 1,
			'penalization_a' => 1.5,
			'penalization_b' => 0.5,
			'depenalization_a' => 1,
			'depenalization_b' => -1,
			'minchallenge_size' => 5,
			'maxchallenge_size' => 1,
			'created' => '2011-08-06 18:58:16',
			'modified' => '2011-08-06 18:58:16',
			'active' => 1
		),
		array(
			'id' => 3,
			'repository_id' => 1,
			'question' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'answer_1' => 'Lorem ipsum dolor sit amet',
			'answer_2' => 'Lorem ipsum dolor sit amet',
			'documentpack_size' => 1,
			'documentpack_cost' => 1,
			'documentupload_cost' => 1,
			'documentvalidation_reward' => 1,
			'penalization_a' => 1.5,
			'penalization_b' => 0.5,
			'depenalization_a' => 1,
			'depenalization_b' => -1,
			'minchallenge_size' => 5,
			'maxchallenge_size' => 1,
			'created' => '2011-08-06 18:58:16',
			'modified' => '2011-08-06 18:58:16',
			'active' => 1
		),
		array(
			'id' => 4,
			'repository_id' => 1,
			'question' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'answer_1' => 'Lorem ipsum dolor sit amet',
			'answer_2' => 'Lorem ipsum dolor sit amet',
			'documentpack_size' => 1,
			'documentpack_cost' => 1,
			'documentupload_cost' => 1,
			'documentvalidation_reward' => 1,
			'penalization_a' => 1.5,
			'penalization_b' => 0.5,
			'depenalization_a' => 1,
			'depenalization_b' => -1,
			'minchallenge_size' => 5,
			'maxchallenge_size' => 1,
			'created' => '2011-08-06 18:58:16',
			'modified' => '2011-08-06 18:58:16',
			'active' => 1
		),
		array(
			'id' => 5,
			'repository_id' => 1,
			'question' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'answer_1' => 'Lorem ipsum dolor sit amet',
			'answer_2' => 'Lorem ipsum dolor sit amet',
			'documentpack_size' => 1,
			'documentpack_cost' => 1,
			'documentupload_cost' => 1,
			'documentvalidation_reward' => 1,
			'penalization_a' => 1.5,
			'penalization_b' => 0.5,
			'depenalization_a' => 1,
			'depenalization_b' => -1,
			'minchallenge_size' => 5,
			'maxchallenge_size' => 1,
			'created' => '2011-08-06 18:58:16',
			'modified' => '2011-08-06 18:58:16',
			'active' => 1
		),
	);
}
?>