<?php
class Restriction extends AppModel {
	var $name = 'restriction';
	var $displayField = 'name';

	var $hasMany = array(
		'RestrictionsSet' => array(
			'className' => 'RestrictionsSet',
			'foreignKey' => 'restriction_id',
			'dependent' => true,
		)
	);
	
	var $belongsTo = array(
			'Cog' => array(
				'className' => 'Cog',
				'foreignKey' => 'cog_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
	);
	
}
?>