<?php
class Document extends AppModel {
	var $name = 'Document';
	var $displayField = 'title';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Document title cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Document content cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
		'Repository' => array(
			'className' => 'Repository',
			'foreignKey' => 'repository_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'document_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Attachfile' => array(
			'className' => 'Attachfile',
			'foreignKey' => 'document_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CriteriasDocument' => array(
			'className' => 'CriteriasDocument',
			'foreignKey' => 'criteria_id',
			'dependent' => true,
		)
	);


	// ============================ METHODS ==============================================
	function findDocumentsByTitle($repo_id = null, $words = array()){
		if(is_null($repo_id)) {
			return null;
		}
		$docs = array();
		foreach ($words as $word) {
			$tmp = $this->find('all', array(
			  		'conditions' => array(
						'Document.title LIKE ' => '%'.$word.'%',
						'Document.repository_id' => $repo_id
					),
			  		'fields' => array('Document.id')
				)
			);
				
			$hola = array();
			foreach($tmp as $t) {
				$hola[] = $t['Document']['id'];
			}
			$docs[] = $hola;
		}
		if(count($docs) > 0) {
			$res = $docs[0];
			for ($i = 1; $i < count($docs); $i++) {
				$res = array_intersect($res, $docs[$i]);
			}
		} else {
			/*$res = $this->find('all', array(
				'conditions' => array('Document.repository_id' => $repo_id),
		  		'fields' => 'DISTINCT Tag.document_id',
				)
			);*/
		}
	
		return $res;
	}
	
	function findDocumentsByContent($repo_id = null, $words = array()){
		if(is_null($repo_id)) {
			return null;
		}
		$docs = array();
		foreach ($words as $word) {
			$tmp = $this->find('all', array(
			  		'conditions' => array(
						'Document.content LIKE ' => '%'.$word.'%',
						'Document.repository_id' => $repo_id
					),
			  		'fields' => array('Document.id')
				)
			);
				
			$hola = array();
			foreach($tmp as $t) {
				$hola[] = $t['Document']['id'];
			}
			$docs[] = $hola;
		}
		if(count($docs) > 0) {
			$res = $docs[0];
			for ($i = 1; $i < count($docs); $i++) {
				$res = array_intersect($res, $docs[$i]);
			}
		} else {
			/*$res = $this->find('all', array(
				'conditions' => array('Document.repository_id' => $repo_id),
		  		'fields' => 'DISTINCT Tag.document_id',
				)
			);*/
		}
	
		return $res;
	}
 	
	/**
	 * 
	 * @TODO handle tags with spaces
	 * saves a document and its tags
	 * @param array $data
	 * @param string $delimiter (of tags)
	 * @return true if successfully, false otherwise
	 */
	function saveWithTags(&$data = array(), $delimiter = ',') {
		if(!empty($data)) {
			$this->create();
	
			$there_are_tags = false;
			if(isset($data['Document']['tags'])) {
				$dataSource = $this->getDataSource();
				$there_are_tags = true;
				$dataSource->begin($this); // BEGIN
			}
	
			if($there_are_tags) {
				$tags = explode($delimiter, $data['Document']['tags']);
				$tags = array_map("trim", $tags);
				unset($data['Document']['tags']);
			}
	
			$this->set($data);
			if(!$this->save()) {
				if($there_are_tags)
					$dataSource->rollback($this); // ROLLBACK
				return false;
			}
			
			$id = $this->id;
			
			if($there_are_tags) {
				$tagData = array();
				$i = 0;
				foreach($tags as $tag) {
					//cgajardo: issue #37
					if($tag=="") continue;
					$tagData[$i]['Tag'] = array(
	        	            'tag' => $tag,
	        	            'document_id' => $id
					);
					$i += 1;
				}
				 
				if($this->Tag->saveAll($tagData)) {
					$dataSource->commit($this); // C0MMIT
					
					return true;
				} else {
					$dataSource->rollback($this); // ROLLBACK
				}
			}
		}
		return false;
	}
	
	
	// done: multiples criterios
	// done: multiple repositories
	function afterSave($created) {
		if($created) {
			$doc = $this->read(null, $this->id);
			$this->CriteriasDocument->massCreateAfterDocument($this->id, $doc['Document']['repository_id']);
		}
	}
	
	function afterFind($results) {
		$i = 0;
		foreach($results as $r) {
			if(!isset($r['Document']['user_id']))
				return $results;
			$u = $this->User->find('first', array(
					'conditions' => array(
						'User.id' => $r['Document']['user_id']
					),
					'fields' => 'User.first_name, User.last_name', 
					'recursive' => -1
			));
			$u = $u['User'];
			$results[$i]['Document']['nombre_autor'] = $u['first_name'] . ' ' . $u['last_name'];
			$i++;
		}
		return $results;
	}

}
?>