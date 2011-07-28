<?php
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
				$this->save();
			}
		}
	}
	
}
?>
