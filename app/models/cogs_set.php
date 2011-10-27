<?php
class CogsSet extends AppModel {
	var $name = 'CogsSet';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Cog' => array(
			'className' => 'Cog',
			'foreignKey' => 'cog_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Set' => array(
			'className' => 'Set',
			'foreignKey' => 'set_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>