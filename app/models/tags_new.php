<?php
class TagsNew extends AppModel {
    var $name = 'TagsNew';
	var $displayField = 'value';
	var $validate = array(
		'value' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Tag name cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasAndBelongsToMany = array(
	'Document' =>array(
	'className'            => 'documents_tagsnews',
	'joinTable'              => '',
	'foreignKey'             => 'document_id',
	'associationForeignKey'  => 'tagsnew_id',
	'with'                   => '',
	'conditions'             => '',
	'order'                  => '',
	'limit'                  => '',
	'unique'                 => true,
	'finderQuery'            => '',
	'deleteQuery'            => '',
	'insertQuery'            => ''
	)        
	); 
}

?>
