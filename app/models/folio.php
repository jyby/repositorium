<?php
class folio extends AppModel {
	var $name = 'folio';
	var $displayField = 'folio';
// 	var $validate = array(
// 		'file' => array(
// 			'notempty' => array(
// 				'rule' => array('notempty'),
// 				'message' => 'file name cannot be empty',
// 				//'allowEmpty' => false,
// 				//'required' => false,
// 				//'last' => false, // Stop validation after this rule
// 				//'on' => 'create', // Limit validation to 'create' or 'update' operations
// 			),
// 		),
// 	);

	var $belongsTo = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
?>