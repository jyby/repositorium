<?php
class Restriction extends AppModel {
	var $name = 'Restriction';
	var $displayField = 'name';

	var $hasMany = array(
		'KitsRestriction' => array(
			'className' => 'KitsRestriction',
			'foreignKey' => 'restriction_id',
			'dependent' => true,
		)
	);
	
	var $belongsTo = array(
			'Constituent' => array(
				'className' => 'Constituent',
				'foreignKey' => 'constituent_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);
	
}
?>