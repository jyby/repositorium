<?php
/**
 * 
 * Enter description here ...
 * @author mquezada
 *
 */
class TamanoDesafio extends AppModel {
	var $name = 'TamanoDesafio';
	var $primaryKey = 'id_desafio';
	var $belongsTo = array(
	  'Usuario' => array(
		'className' => 'Usuario',
		'foreignKey' => 'id_usuario'
      ),
      'Criterio' => array(
      	'className' => 'Criterio',
      	'foreignKey' => 'id_criterio'
      )		
	);

	var $validate = array(
		'c_preguntas' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'The number of questions per criterion for a particular user must be a numeric value.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	
	/*****************************************************************************************************************/
	
	function massCreateAfterCriteria($id_criterio = null, $tamano_minimo_desafio = null) {
		if(!is_null($id_criterio) && !is_null($tamano_minimo_desafio)) {
			$users = $this->Usuario->find('all', array('fields' => 'Usuario.id_usuario', 'recursive' => -1));
			
			foreach($users as $user) {
				$this->create();
				$this->set(
					array(
						'id_usuario' => $user['Usuario']['id_usuario'],
						'id_criterio' => $id_criterio,
						'c_preguntas' => $tamano_minimo_desafio					
					)
				);
				if(!$this->save())
					return false;
			}
		}
		return true;
	}
	
	function _entry($user_id = null, $criteria_id = null) {
		if(is_null($user_id) || is_null($criteria_id))
			return null;
			
		return $this->find('first', array(
			'conditions' => array(
				'TamanoDesafio.id_usuario' => $user_id,
				'TamanoDesafio.id_criterio' => $criteria_id
			)
		));
	}
	
	function getC($user_id = null, $criteria_id = null) {
		$td = $this->_entry($user_id, $criteria_id);
		
		if($td)		
			return $td['TamanoDesafio']['c_preguntas'];			
				
		return null;		
	}
	
	function saveNextC($user_id = null, $criteria_id = null, $challengeCorrect = false) {
		$td = $this->_entry($user_id, $criteria_id);
		$des = ($challengeCorrect ? 'des' : '');
		
		if($td) {
			$cr = $td['Criterio'];
			$td = $td['TamanoDesafio'];
			
			$c = $this->getC($user_id, $criteria_id);
			$new_value = $cr['funcion_'.$des.'penalizacion_a']*$c + $cr['funcion_'.$des.'penalizacion_b'];
			
			if($new_value < $cr['tamano_minimo_desafio'])
				$new_value = $cr['tamano_minimo_desafio'];
			
			$this->id = $td['id_desafio'];			
			if($this->saveField('c_preguntas', $new_value));
				return true;	
		}
		
		return false;
	}
	
}
?>
