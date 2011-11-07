<?php
class ConstituentsKit extends AppModel {
	var $name = 'ConstituentsKit';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Constituent' => array(
			'className' => 'Constituent',
			'foreignKey' => 'constituent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Kit' => array(
			'className' => 'kit',
			'foreignKey' => 'kit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>