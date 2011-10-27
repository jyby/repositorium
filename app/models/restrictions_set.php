<?php
class RestrictionsSet extends AppModel {
	var $name = 'RestrictionsSet';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Set' => array(
			'className' => 'Set',
			'foreignKey' => 'set_id',
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