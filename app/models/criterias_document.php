<?php
class CriteriasDocument extends AppModel {
	var $name = 'CriteriasDocument';
	var $validate = array(
		'total_answers_1' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'total_answers_2' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'validated' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'challengeable' => array(
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

	var $belongsTo = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
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
	
	/* virtualFields ftw! */
	var $virtualFields = array(
	    	'total_respuestas' => 'total_answers_1 + total_answers_2',
	    	'consenso' => 'ABS(total_answers_2 - total_answers_1)*100/(total_answers_1 + total_answers_2)',
	    	'total_app' => 'total_answers_2*100/(total_answers_1 + total_answers_2)'
	);
	
	function massCreateAfterCriteria($id_criterio) {
		if(!is_null($id_criterio)) {
			$docs = $this->Document->find('all', array('fields' => array('Document.id'), 'recursive' => -1));

			foreach($docs as $doc) {
				$this->create();
				$this->set(
					array(
						'document_id' => $doc['Document']['id'],
						'criteria_id' => $id_criterio,
					    'total_answers_1' => 0,
					    'total_answers_2' => 0,
					    'validated' => false,
					    'challengeable' => true,
						)
					);
				if(!$this->save())
					return false;
			}
		} else {
			return false;
		}
		return true;
	}
	
	function massCreateAfterDocument($id_documento = null) {
		if(!is_null($id_documento)) {
			$criterios = $this->Criteria->find('all', array('fields' => 'Criteria.id', 'recursive' => -1));
			
			$ds = $this->getDataSource();
			$ds->begin($this);
			
			foreach($criterios as $c) {
				$this->create();
				$this->set(
					array(
						'document_id' => $id_documento,
					  	'criteria_id' => $c['Criteria']['id'],
					  	'total_answers_1' => 0,
					  	'total_answers_2' => 0,
				      	'validated' => false,
						'challengeable' => true,
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
		
		return false;
	}
	
	/**
	 * $data = compact('criteria_id', 'confirmado', 'preguntable', 'quantity', 'user_id');
	 */
	function getRandomDocuments($data = null) {
		if(!isset($data['confirmado']) || !isset($data['criteria_id']) || !isset($data['quantity']))
			return null;
	
		// we only want InformacionDesafio and Documento entries
		$this->unbindModel(array('belongsTo' => array('Criteria')));
	
		$preguntable 	= (isset($data['preguntable']) ? $data['preguntable'] : true) ;
		$usuario_id 	= (isset($data['user_id']) ? $data['user_id'] : 1) ;
		$criteria_id 	= $data['criteria_id'];
		$confirmado 	= $data['confirmado'];
		$quantity 		= $data['quantity'];
	
		$ids = $this->find('all', array(
				'conditions' => array(
					'CriteriasDocument.criteria_id' => $criteria_id,
					'CriteriasDocument.validated' => $confirmado,
					'CriteriasDocument.challengeable' => $preguntable,
					'Document.user_id <>' => $usuario_id
				),
			)
		);
	
		// shuffles the result and then extract the first $quantity $ids
		shuffle($ids);
		$result = array_slice($ids, 0, $quantity);
		// 		pr($result);
		return $result;
	}
	
	/*
	 * first reCaptcha validation
	* returns true if validated documents are well answered
	* false otherwise
	*/
	function validateChallenge($data = null) {
		if(is_null($data) || !is_array($data))
		return false;
	
		$docs = array();
		// first, identify which documents are which
		foreach($data as $d) {
			if(!isset($d['id_criterio']) || !isset($d['id_documento']) || !isset($d['respuesta']))
			return false;
	
			$info = $this->_validatedEntry($d);
				
			if(!is_null($info)) {
				$answer = $info['CriteriasDocument']['is_positive'];
				$given = $d['respuesta'];
	
				/* answer : 0, 1
				 * given  :    1, 2	 */
				if(	$answer+1 != $given )
				return false;
			}
		}
	
		return true;
	}
	
	/**
	 * if $d: informacion_desafio entry
	 * corresponds to a validated document
	 * then returns that entry
	 *
	 * null otherwise
	 *
	 */
	function _validatedEntry($d = null) {
		$info = $this->entry($d);
	
		if($info['CriteriasDocument']['validated'] === '1')
		return $info;
		return null;
	}
	
	/**
	 *
	 * returns info_desafio of given id_criterio and id_documento
	 * @param array $d
	 */
	function entry($d = null) {
		$info = $this->find('first', array(
				'recursive' => -1,
	 			'fields' => array('id' ,'validated', 'is_positive', 'total_answers_1', 'total_answers_2'),
				'conditions' => array(
					'CriteriasDocument.criteria_id' => $d['id_criterio'],
					'CriteriasDocument.document_id' => $d['id_documento']
			)
		));
	
		return $info;
	}
	
	/**
	 *
	 * saves answer statistics
	 * if $correctChallenge then save all data
	 * otherwise, only validated documents
	 *
	 * @param array $data
	 * @param boolean $correctChallenge
	 */
	function saveStatistics($data = null, $correctChallenge = false) {
		if(is_null($data)) return;
	
		foreach($data as $d) {
			$info = $this->entry($d);
	
			/*
			 * if challenge was correct, then save all documents' statistics
			* otherwise, only validated documents' statistcs
			*/
			if($info && ($info['CriteriasDocument']['validated'] === '1' || $correctChallenge)) {
				$id = $info['CriteriasDocument']['id'];
	
				$ans = $d['respuesta'];
				$new_value = $info['CriteriasDocument']['total_answers_'.$ans] + 1;
					
				$this->id = $id;
				$this->saveField('total_answers_'.$ans, $new_value);
			}
		}
	}
}
?>