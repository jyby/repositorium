<?php
class InformacionDesafio extends AppModel {
	var $name = 'InformacionDesafio';
	var $primaryKey = 'id_estadisticas';
	var $belongsTo = array(
	  'Documento' => array(
        'className' => 'Documento',
        'foreignKey' => 'id_documento'
      ),
      'Criterio' => array(
      	'className' => 'Criterio',
      	'foreignKey' => 'id_criterio'
      )
    );
    
    /* virtualFields ftw! */   
    var $virtualFields = array(
    	'total_respuestas' => 'total_respuestas_1_como_desafio + total_respuestas_2_como_desafio',
    	'consenso' => 'ABS(total_respuestas_2_como_desafio - total_respuestas_1_como_desafio)*100/(total_respuestas_1_como_desafio + total_respuestas_2_como_desafio)',
    	'total_app' => 'total_respuestas_2_como_desafio*100/(total_respuestas_1_como_desafio + total_respuestas_2_como_desafio)'
    );

	var $validate = array(
		'total_respuestas_1_no_validado' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'La cantidad de respuestas de tipo 1 para este documento previas a la validación deben ser un valor numérico.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'total_respuestas_2_no_validado' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'La cantidad de respuestas de tipo 2 para este documento previas a la validación deben ser un valor numérico.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),/*
		'respuesta_oficial_de_un_experto' => array(
			'boolean' => array(
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			),*/
		'total_respuestas_1_como_desafio' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'La cantidad de respuestas de tipo 1 para este documento como validado preguntable deben ser un valor numérico.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'total_respuestas_2_como_desafio' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'La cantidad de respuestas de tipo 2 para este documento como validado preguntable  deben ser un valor numérico.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'confirmado' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'La calificación de un documento como confirmado solo puede ser verdadera o falsa.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'preguntable' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'La calificación de un documento como preguntable solo puede ser verdadera o falsa.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	/******* methods *******/	
	
	/*function afterFind($results, $primary) {
		if($primary) {
			$i = 0;
		  	foreach($results as $r) {
		  		pr($r);
				$results[$i]['InformacionDesafio']['total_respuestas'] =  
					  $results[$i]['InformacionDesafio']['total_respuestas_1_como_desafio']
					+ $results[$i]['InformacionDesafio']['total_respuestas_2_como_desafio'];			
				$i += 1;
		  	}	  	
		}
		return $results;
	}*/
	
	
	function massCreateAfterCriteria($id_criterio) {
		if(!is_null($id_criterio)) {
			$docs = $this->Documento->find('all', array('fields' => array('Documento.id_documento', 'Documento.autor'), 'recursive' => -1));
			
			foreach($docs as $doc) {
				$this->create();
				$this->set(
				array(
					'id_documento' => $doc['Documento']['id_documento'],
					'id_criterio' => $id_criterio,
					'total_respuestas_1_no_validado' => 0,
			    	'total_respuestas_2_no_validado' => 0,
					//'respuesta_oficial_de_un_experto' => ,
				    'total_respuestas_1_como_desafio' => 0,
				    'total_respuestas_2_como_desafio' => 0,
				    'confirmado' => false,
				    'preguntable' => true,
					) 
				);
				if(!$this->save())
					return false;
			}						
		}
		return true;
	}
	
	function massCreateAfterDocument($id_documento = null) {
		if(!is_null($id_documento)) {
			$criterios = $this->Criterio->find('all');
			foreach($criterios as $c) {
				$this->create();
				$this->set(
					array(
						'id_documento' => $id_documento,
					  	'id_criterio' => $c['Criterio']['id_criterio'],
					  	'total_respuestas_1_no_validado' => 0,
					  	'total_respuestas_2_no_validado' => 0,
					  	//'respuesta_oficial_de_un_experto' => ,
					  	'total_respuestas_1_como_desafio' => 0,
					  	'total_respuestas_2_como_desafio' => 0,
				      	'confirmado' => false,
						'preguntable' => true,
					)
				);
				$this->save();
			}
		}				
	}
	
	/**
	 * $data = compact('criteria_id', 'confirmado', 'preguntable', 'quantity', 'user_id');
	 */
	function getRandomDocuments($data = null) {
		if(!isset($data['confirmado']) || !isset($data['criteria_id']) || !isset($data['quantity']))
			return null;

		// we only want InformacionDesafio and Documento entries
		$this->unbindModel(array('belongsTo' => array('Criterio')));
		
		$preguntable 	= (isset($data['preguntable']) ? $data['preguntable'] : true) ;
		$usuario_id 	= (isset($data['user_id']) ? $data['user_id'] : 1) ;
		$criteria_id 	= $data['criteria_id'];
		$confirmado 	= $data['confirmado'];
		$quantity 		= $data['quantity'];

		$ids = $this->find('all', array(
			'conditions' => array(
				'InformacionDesafio.id_criterio' => $criteria_id,
				'InformacionDesafio.confirmado' => $confirmado,
				'InformacionDesafio.preguntable' => $preguntable,
				'Documento.autor <>' => $usuario_id
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
				$answer = $info['InformacionDesafio']['respuesta_oficial_de_un_experto'];
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
		
		if($info['InformacionDesafio']['confirmado'] === '1')
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
 			'fields' => array('id_estadisticas' ,'confirmado', 'respuesta_oficial_de_un_experto', 'total_respuestas_1_como_desafio', 'total_respuestas_2_como_desafio'),
			'conditions' => array(
			'InformacionDesafio.id_criterio' => $d['id_criterio'],
			'InformacionDesafio.id_documento' => $d['id_documento']
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
			if($info && ($info['InformacionDesafio']['confirmado'] === '1' || $correctChallenge)) {
				$id = $info['InformacionDesafio']['id_estadisticas'];
				
				$ans = $d['respuesta'];
				$new_value = $info['InformacionDesafio']['total_respuestas_'.$ans.'_como_desafio'] + 1;
									
				$this->id = $id;
				$this->saveField('total_respuestas_'.$ans.'_como_desafio', $new_value);
			}
		}		
	}
}
?>
