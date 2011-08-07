<?php
class Criteria extends AppModel {
	var $name = 'Criteria';
	var $displayField = 'question';
	var $validate = array(
		'question' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'answer_1' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'answer_2' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'documentpack_size' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'documentpack_cost' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'documentupload_cost' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'documentvalidation_reward' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'penalization_a' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'penalization_b' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'depenalization_a' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'depenalization_b' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'minchallenge_size' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'maxchallenge_size' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Repository' => array(
			'className' => 'Repository',
			'foreignKey' => 'repository_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'CriteriasDocument' => array(
			'className' => 'CriteriasDocument',
			'foreignKey' => 'criteria_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'CriteriasUser' => array(
			'className' => 'CriteriasUser',
			'foreignKey' => 'criteria_id',
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
	
	// actualiza los documentos agregando el nuevo criterio a InfoDesafio
	// y los usuarios, con TamanoDesafio
	function afterSave($created) {
		if($created) {
			$ds = $this->getDataSource();
				
			$ds->begin($this);
			if(
				$this->CriteriasDocument->massCreateAfterCriteria($this->id) &&
				$this->CriteriasUser->massCreateAfterCriteria($this->id, $this->field('minchallenge_size', array('id' => $this->id))))
				$ds->commit($this);
			else
				$ds->rollback($this);
		}
	}
	
	
	function getRandomCriteria() {
		$criterios = $this->find('all', array('recursive' => -1));
	
		if(empty($criterios))
			return null;
	
		return $criterios[array_rand($criterios)];
	}
	
	function generateChallenge($user_id = null, $criterio = null, $proportion = 0.5) {
		if(is_null($user_id))
			return null;
	
		if(is_null($criterio) || !isset($criterio['Criteria']['id']))
			$criterio = $this->getRandomCriteria();
	
		if(is_null($criterio))
			return null;
	
		$criterio_id = $criterio['Criteria']['id'];
		$c = $this->CriteriasUser->getC($user_id, $criterio_id);
	
		$qty_of_validated    = ceil($proportion * $c);
		$qty_of_nonvalidated = floor((1 - $proportion) * $c);
	
		$v_params = array(
				'criteria_id' => $criterio_id,
				'user_id' => $user_id,
				'confirmado' => true,
				'quantity' => $qty_of_validated 
		);
	
		$n_params = array(
				'criteria_id' => $criterio_id,
				'user_id' => $user_id,
				'confirmado' => false,
				'quantity' => $qty_of_nonvalidated 
		);
	
		$validated = $this->CriteriasDocument->getRandomDocuments($v_params);
	
		if(count($validated) < $qty_of_validated)
			$n_params['quantity'] = $qty_of_nonvalidated + ($qty_of_validated - count($validated));
	
		$nonvalidated = $this->CriteriasDocument->getRandomDocuments($n_params);
	
		$challenge = array_merge($validated, $nonvalidated);
		shuffle($challenge);
	
		return $challenge;
	}

}
?>