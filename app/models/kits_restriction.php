<?php
class KitsRestriction extends AppModel {
	var $name = 'KitsRestriction';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Kit' => array(
			'className' => 'Kit',
			'foreignKey' => 'kit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Restriction' => array(
			'className' => 'Restriction',
			'foreignKey' => 'restriction_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>