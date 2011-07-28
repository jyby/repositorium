<?php
/* Tag Fixture generated on: 2011-07-27 19:17:20 : 1311808640 */
class TagFixture extends CakeTestFixture {
	var $name = 'Tag';

	var $fields = array(
		'asociacion_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'id_documento' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'tag' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'asociacion_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'asociacion_id' => 1,
			'id_documento' => 1,
			'tag' => 'Lorem ipsum dolor '
		),
	);
}
?>