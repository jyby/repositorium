<?php
/* Tag Fixture generated on: 2011-08-06 19:20:40 : 1312672840 */
class TagFixture extends CakeTestFixture {
	var $name = 'Tag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'document_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'tag' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'document_id' => 1,
			'tag' => 'Lorem ipsum dolor ',
			'created' => '2011-08-06 19:20:40',
			'modified' => '2011-08-06 19:20:40'
		),
	);
}
?>