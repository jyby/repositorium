<?php
/* TamanoDesafio Fixture generated on: 2011-07-27 19:17:25 : 1311808645 */
class TamanoDesafioFixture extends CakeTestFixture {
	var $name = 'TamanoDesafio';

	var $fields = array(
		'id_desafio' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'id_usuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'id_criterio' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'c_preguntas' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id_desafio', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id_desafio' => 1,
			'id_usuario' => 1,
			'id_criterio' => 1,
			'c_preguntas' => 5
		),
		array(
			'id_desafio' => 2,
			'id_usuario' => 2,
			'id_criterio' => 1,
			'c_preguntas' => 6
		),
		array(
			'id_desafio' => 3,
			'id_usuario' => 1,
			'id_criterio' => 2,
			'c_preguntas' => 5
		),
	);
}
?>