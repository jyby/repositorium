<?php
class Kit extends AppModel {
	var $name = 'Kit';

	var $hasMany = array(
		'ConstituentsKit' => array(
			'className' => 'ConstituentsKit',
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