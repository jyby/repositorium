<?php
/* Experto Fixture generated on: 2011-07-27 19:17:12 : 1311808632 */
class ExpertoFixture extends CakeTestFixture {
	var $name = 'Experto';

	var $fields = array(
		'id_experto' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'id_usuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'id_contexto' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'indexes' => array('PRIMARY' => array('column' => 'id_experto', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id_experto' => 1,
			'id_usuario' => 1,
			'id_contexto' => 1
		),
	);
}
?>