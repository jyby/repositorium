<?php
class source extends AppModel {
	var $name = 'source';
	var $displayField = 'name';
// 	var $validate = array(
// 		'source' => array(
// 			'notempty' => array(
// 				'rule' => array('notempty'),
// 				'message' => 'source name cannot be empty',
// 				//'allowEmpty' => false,
// 				//'required' => false,
// 				//'last' => false, // Stop validation after this rule
// 				//'on' => 'create', // Limit validation to 'create' or 'update' operations
// 			),
// 		),
// 	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Repository' => array(
			'className' => 'Repository',
			'foreignKey' => 'source_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
?>