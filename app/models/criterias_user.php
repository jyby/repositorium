<?php
class CriteriasUser extends AppModel {
	var $name = 'CriteriasUser';
	var $validate = array(
		'challenge_size' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The challenge size must be a number',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'positive' => array(
				'rule' => array('positive'),
				'message' => 'The challenge size must be a positive number'
			)
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Criteria' => array(
			'className' => 'Criteria',
			'foreignKey' => 'criteria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/*****************************************************************************************************************/
	
	function positive($value) {
		return $value['challenge_size'] >= 0;
	}
	
	function massCreateAfterCriteria($id_criterio = null, $tamano_minimo_desafio = null) {
		if(!is_null($id_criterio) && !is_null($tamano_minimo_desafio)) {
			$users = $this->User->find('all', array('fields' => 'User.id', 'recursive' => -1));
				
			foreach($users as $user) {
				$this->create();
				$this->set(
					array(
						'user_id' => $user['User']['id'],
						'criteria_id' => $id_criterio,
						'challenge_size' => $tamano_minimo_desafio					
						)
				);
				if(!$this->save())
					return false;
			}
		}
		return true;
	}
	
	function massCreateAfterUser($user_id = null) {
		if(is_null($user_id)) 
			return false;
		
		$criterias = $this->Criteria->find('all', array('fields' => array('Criteria.id', 'Criteria.minchallenge_size'), 'recursive' => -1));
		
		$ds = $this->getDataSource();
		foreach($criterias as $c) {
			$this->create();
			$this->set(
				array(
					'user_id' => $user_id,
					'criteria_id' => $c['Criteria']['id'],
					'challenge_size' => $c['Criteria']['minchallenge_size']
				) 
			);
			
			if(!$this->save()) {
				$ds->rollback($this);
				return false;
			}				
		}
		$ds->commit($this);
		return true;
	}
	
	function _entry($user_id = null, $criteria_id = null) {
		if(is_null($user_id) || is_null($criteria_id))
		return null;
			
		return $this->find('first', array(
				'conditions' => array(
					'CriteriasUser.user_id' => $user_id,
					'CriteriasUser.criteria_id' => $criteria_id
		)
		));
	}
	
	function getC($user_id = null, $criteria_id = null) {
		$td = $this->_entry($user_id, $criteria_id);
	
		if($td)
			return $td['CriteriasUser']['challenge_size'];
	
		return null;
	}
	
	function saveNextC($user_id = null, $criteria_id = null, $challengeCorrect = false) {
		$td = $this->_entry($user_id, $criteria_id);
		$des = ($challengeCorrect ? 'de' : '');
	
		if($td) {
			$cr = $td['Criteria'];
			$td = $td['CriteriasUser'];
				
			$c = $this->getC($user_id, $criteria_id);
			$new_value = $cr[$des.'penalization_a']*$c + $cr[$des.'penalization_b'];
				
			if($new_value < $cr['minchallenge_size'])
				$new_value = $cr['minchallenge_size'];
				
			$this->id = $td['id'];
			if($this->saveField('challenge_size', $new_value))
				return true;
		}
	
		return false;
	}
}
?>