<?php
class CogsKit extends AppModel {
	var $name = 'CogsKit';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Cog' => array(
			'className' => 'Cog',
			'foreignKey' => 'cog_id',
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