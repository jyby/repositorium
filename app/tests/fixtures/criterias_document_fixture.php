<?php
/* CriteriasDocument Fixture generated on: 2011-08-06 19:00:58 : 1312671658 */
class CriteriasDocumentFixture extends CakeTestFixture {
	var $name = 'CriteriasDocument';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255, 'key' => 'primary'),
		'document_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'criteria_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'official_answer' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'total_answers_1' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'total_answers_2' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 255),
		'validated' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'challengeable' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array('id' => 1,'document_id' => 1,'criteria_id' => 1,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 2,'document_id' => 2,'criteria_id' => 1,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 3,'document_id' => 3,'criteria_id' => 1,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 4,'document_id' => 4,'criteria_id' => 1,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 5,'document_id' => 5,'criteria_id' => 1,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 6,'document_id' => 1,'criteria_id' => 2,'official_answer' => null,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 7,'document_id' => 2,'criteria_id' => 2,'official_answer' => null,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 8,'document_id' => 3,'criteria_id' => 2,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 9,'document_id' => 4,'criteria_id' => 2,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 10,'document_id' => 5,'criteria_id' => 2,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 11,'document_id' => 1,'criteria_id' => 3,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 12,'document_id' => 2,'criteria_id' => 3,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 13,'document_id' => 3,'criteria_id' => 3,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 14,'document_id' => 4,'criteria_id' => 3,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 15,'document_id' => 5,'criteria_id' => 3,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 16,'document_id' => 1,'criteria_id' => 4,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 17,'document_id' => 2,'criteria_id' => 4,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 18,'document_id' => 3,'criteria_id' => 4,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 19,'document_id' => 4,'criteria_id' => 4,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 20,'document_id' => 5,'criteria_id' => 4,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 21,'document_id' => 1,'criteria_id' => 5,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 22,'document_id' => 2,'criteria_id' => 5,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 23,'document_id' => 3,'criteria_id' => 5,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
		array('id' => 24,'document_id' => 4,'criteria_id' => 5,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 0,'challengeable' => 1),
		array('id' => 25,'document_id' => 5,'criteria_id' => 5,'official_answer' => 1,'total_answers_1' => 1,'total_answers_2' => 1,'validated' => 1,'challengeable' => 1),
	);
}
?>