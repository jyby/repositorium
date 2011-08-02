<?php
/* InformacionDesafio Fixture generated on: 2011-07-27 19:17:16 : 1311808636 */
class InformacionDesafioFixture extends CakeTestFixture {
	var $name = 'InformacionDesafio';

	var $fields = array(
		'id_estadisticas' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'id_documento' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'id_criterio' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'total_respuestas_1_no_validado' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'total_respuestas_2_no_validado' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'respuesta_oficial_de_un_experto' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'total_respuestas_1_como_desafio' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'total_respuestas_2_como_desafio' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'confirmado' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'preguntable' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id_estadisticas', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array('id_estadisticas' => 1,'id_documento' => 1,'id_criterio' => 1,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 2,'id_documento' => 2,'id_criterio' => 1,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 3,'id_documento' => 3,'id_criterio' => 1,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 4,'id_documento' => 4,'id_criterio' => 1,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 5,'id_documento' => 5,'id_criterio' => 1,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 6,'id_documento' => 1,'id_criterio' => 2,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 7,'id_documento' => 2,'id_criterio' => 2,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 8,'id_documento' => 3,'id_criterio' => 2,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 9,'id_documento' => 4,'id_criterio' => 2,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 10,'id_documento' => 5,'id_criterio' => 2,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 11,'id_documento' => 1,'id_criterio' => 3,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 12,'id_documento' => 2,'id_criterio' => 3,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 13,'id_documento' => 3,'id_criterio' => 3,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 14,'id_documento' => 4,'id_criterio' => 3,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 15,'id_documento' => 5,'id_criterio' => 3,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 16,'id_documento' => 1,'id_criterio' => 4,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 17,'id_documento' => 2,'id_criterio' => 4,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 18,'id_documento' => 3,'id_criterio' => 4,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 19,'id_documento' => 4,'id_criterio' => 4,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 20,'id_documento' => 5,'id_criterio' => 4,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 21,'id_documento' => 1,'id_criterio' => 5,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 22,'id_documento' => 2,'id_criterio' => 5,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 23,'id_documento' => 3,'id_criterio' => 5,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
		array('id_estadisticas' => 24,'id_documento' => 4,'id_criterio' => 5,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 0,'preguntable' => 1),
		array('id_estadisticas' => 25,'id_documento' => 5,'id_criterio' => 5,'total_respuestas_1_no_validado' => 1,'total_respuestas_2_no_validado' => 1,'respuesta_oficial_de_un_experto' => 1,'total_respuestas_1_como_desafio' => 1,'total_respuestas_2_como_desafio' => 1,'confirmado' => 1,'preguntable' => 1),
	);
}
?>