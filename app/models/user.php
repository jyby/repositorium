<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'email';
	var $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_administrator' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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
		'Repository' => array(
			'className' => 'Repository',
			'foreignKey' => 'user_id',
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
		'CriteriasUser' => array(
			'className' => 'CriteriasUser',
			'foreignKey' => 'user_id',
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
	
	/* ==================== METHODS ====================== */
	
	function beforeSave($options) {
		if(!empty($this->data['User']['password'])) {
			$this->data['User']['salt'] = mt_rand();
			$this->data['User']['password'] = sha1($this->data['User']['password'] . $this->data['User']['salt']);
		}
	
		return true;
	}
	
	/**
	 * Registers a new user
	 * @param array $data
	 * @return true on success, false otherwise
	 */
	function register($data=array()) {
		if(empty($data) || !array_key_exists('User', $data))
		return false;
	
		$t = array(
		array_key_exists('email', $data['User']),
		array_key_exists('first_name', $data['User']),
		array_key_exists('last_name', $data['User']),
		array_key_exists('password', $data['User']),
		);
	
		if(!($t[0] and $t[1] and $t[2] and $t[3]))
			return false;
	
		$data['User']['is_administrator'] = false;
	
		$user = $this->save($data);
		return $user;
	}
	
	/**
	 * checks user credential
	 * @param array $data with email and username as subkeys of User
	 * @returns the corresponding user object, null otherwise
	 */
	function iniciar_sesion($data = array()) {
		if(empty($data))
		return null;
		$d = $this->findByEmail($data['User']['email']);
	
		$pass_to_check = $d['User']['password'];
		$pass_from_login = sha1($data['User']['password'] . $d['User']['salt']);
		if(strcmp($pass_to_check,$pass_from_login) == 0) {
			return $d;
		}
		return null;
	}
	
	/* afterShave */
	function afterSave($created) {
		if($created) {
	
			/* on create */
			if(!empty($this->data['User']['es_experto'])) {
				$this->_expert_create($this->id);
			}
	
			App::import('Model','Criteria');
			$Criteria = new Criteria;
			$criterios = $Criteria->find('all');
			foreach($criterios as $c) {
				$this->CriteriasUser->create();
	
				$this->CriteriasUser->set(array(
					'user_id' => $this->id,
					'criteria_id' => $c['Criteria']['id'],
					'challenge_size' => $c['Criteria']['minchallenge_size'],
				));
	
				$this->CriteriasUser->save();
			}
	
			CakeLog::write('activity', 'User '.$this->id. ' created');
		} else {
			/* on update */
			if($this->data['User']['es_experto'] == 1) {
				$this->_expert_create($this->id);
			} else {
				$this->_expert_delete($this->id);
			}
			CakeLog::write('activity', 'User '.$this->id. ' updated');
		}
	}
	
	function _expert_create($id) {
		$this->Expert->create();
		$this->Expert->set(array(
			'user_id' => $this->id,
			'repository_id' => 1
		));
		$this->Expert->save();
	}
	
	function _expert_delete($id) {
		$this->Expert->deleteAll(array('Expert.user_id' => $id));
	}
	
	
	function afterFind($results, $primary) {
		$i = 0;
		foreach($results as $r) {
			if(!empty($r['Expert'])) {
				$results[$i]['User']['es_experto'] = 1;
			}
			$i += 1;
		}
		return $results;
	}

}
?>