<?php
class Repository extends AppModel {
	var $name = 'Repository';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Repository name cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'min_points' => array(
			'positive' => array(
				'rule' => array('positive', 'min_points'),
				'message' => 'Points must be greater than 0'
			)
		),
		'download_cost' => array(
			'positive' => array(
				'rule' => array('positive', 'download_cost'),
				'message' => 'Download cost must be greater than 0',
			)
		),
		'upload_cost' => array(
			'positive' => array(
				'rule' => array('positive', 'upload_cost'),
				'message' => 'Upload cost must be greater than 0'
			)
		)
	);
	
	
	function positive($value, $key) {
		return $value[$key] >= 0;
	}
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Criteria' => array(
			'className' => 'Criteria',
			'foreignKey' => 'repository_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'repository_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Expert' => array(
			'className' => 'Expert',
			'foreignKey' => 'repository_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'repositories_users',
			'foreignKey' => 'repository_id',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	/*******************************************************/
	
	function createNewRepository($data, $user) {
		
	}
	
	function afterSave($created) {
		
	}

}
?>