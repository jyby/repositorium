<?php
class Kit extends AppModel {
	var $name = 'Kit';

	var $hasMany = array(
		'CogsKit' => array(
			'className' => 'CogsKit',
			'foreignKey' => 'kit_id',
			'dependent' => true,
		),
		'KitsRestriction' => array(
			'className' => 'KitsRestriction',
			'foreignKey' => 'kit_id',
			'dependent' => true,
		)
	);
}
?>