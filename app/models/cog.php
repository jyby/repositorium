<?php
class Cog extends AppModel {
	var $name = 'Cog';
	var $displayField = 'name';

	var $hasMany = array(
		'IngredientsSet' => array(
			'className' => 'CogsSet',
			'foreignKey' => 'cog_id',
			'dependent' => true,
		)
	);
	
}
?>