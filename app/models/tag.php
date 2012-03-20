<?php
class Tag extends AppModel {
	var $name = 'Tag';
	var $displayField = 'tag';
	var $validate = array(
		'tag' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Tag name cannot be empty',
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
		)
	);
	//devuelve la cantidad de tags del documento nuevo que ya existen
	function findTagsCount($repo_id = null, $tags = array(),$documents_controller) {
			if(is_null($repo_id)) {
			return null;
		}
		$tag_count=0;
		//echo '<pre>';
		//print_r($tags);
		//echo '</pre>';
				$docs = array();
		foreach ($tags as $tag) {
			$tmp = $this->find('all', array(
			  		'conditions' => array(
						'Tag.tag' => $tag,
						'Document.repository_id' => $repo_id
					),
			  		'fields' => array('Tag.document_id')
				)
			);
				
			$hola = array();
			foreach($tmp as $t) {
				$hola[] = $t['Tag']['document_id'];
			}
			$docs[] = $hola;
		}
				if(count($docs) > 0) {
				//echo 'Entro al if de count>0';
				//echo '<pre>';
				//echo '$docs es:';
				//print_r($docs);
				//echo '</pre>';
			$res = $docs[0];
			for ($i = 1; $i < count($docs); $i++) {
				$res = array_intersect($res, $docs[$i]);
			}
		}
		else {
		//echo 'Entro al else con el find all';
			$res = $this->find('all', array(
				'conditions' => array('Document.repository_id' => $repo_id),
		  		'fields' => 'DISTINCT Tag.document_id',
				)
			);
		}
		//echo '<pre> Tags res: </br>';
		//print_r($res);
		//echo '</pre>';
		if($documents_controller!=""){
		$documents_controller->Session->write("sim_tags", $res);}
		//$sim_tags=count($res);
		//echo $sim_tags;
		return count($res);
	}
	// devuelve la lista de documentos
	// dados por los tags
	function findDocumentsByTags($repo_id = null, $tags = array()) {
		if(is_null($repo_id)) {
			return null;
		}
		$docs = array();
		foreach ($tags as $tag) {
			$tmp = $this->find('all', array(
			  		'conditions' => array(
						'Tag.tag' => $tag,
						'Document.repository_id' => $repo_id
					),
			  		'fields' => array('Tag.document_id')
				)
			);
				
			$hola = array();
			foreach($tmp as $t) {
				$hola[] = $t['Tag']['document_id'];
			}
			$docs[] = $hola;
		}
		if(count($docs) > 0) {
			$res = $docs[0];
			for ($i = 1; $i < count($docs); $i++) {
				$res = array_intersect($res, $docs[$i]);
			}
		} else {
			$res = $this->find('all', array(
				'conditions' => array('Document.repository_id' => $repo_id),
		  		'fields' => 'DISTINCT Tag.document_id',
				)
			);
		}
	
		return $res;
	}
}
?>