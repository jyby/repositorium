<?php
class DocumentsController extends AppController {

	var $name = 'Documents';
	var $uses = array('Document', 'User', 'Repository', 'CogsKit');
	
	/**
	 * User Model
	 * @var User
	 */
	var $User;
	
	/**
	 * Document Model
	 * @var Document
	 */
	var $Document;
	
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	function beforeFilter() {
		if(!$this->Session->check('Document.continue')) {
			$this->Session->write('Action.type', $this->action);			
			$this->redirect(array('controller' => 'points', 'action' => 'process'));	
		}
	}
	
  function index() {
	$this->e404();
  }
  
  function _clean_session() {
  	$this->Session->delete('Document');
  }
  
  /**
   * 
   * @TODO points handling
   * @TODO dispatch handling
   */
  function upload() {
  	$repo = $this->requireRepository();
  	
  	$cogs = $this->CogsKit->find('list', array(
  		  				'conditions' => array('CogsKit.kit_id' => $repo['Repository']['kit_id'], 'CogsKit.cog_id' != '0'), 
  		  				'recursive' => 1,
  		  				'fields'=>array('Cog.sysname')));
  	
  	if(!empty($this->data)) {
		//attach necesary behaviors
		foreach ($cogs as $cog){
			$configArray = array('cod'=> 1);
			$configArray['data'] =& $this->data;
			$configArray['session'] =& $this->Session;
  			$this->Document->Behaviors->attach($cog, $configArray);
		}
  		
		$this->save($this->data);
		
  		foreach ($cogs as $cog){
  			$this->Document->Behaviors->detach($cog);
  		}
  	}
  	
  	
	$this->set(compact('cogs'));
  }

  
  /**
   * 
   */
  function download() {
  	if($this->Session->check('Search.document_ids')) {
  		$document_ids = $this->Session->read('Search.document_ids');  		
  		
  		$repo = $this->requireRepository();
  		$doc_pack = $repo['Repository']['documentpack_size'];
  		  		
  		$docs = array();  		
  		foreach($document_ids as $id) {
  			$docs[] = $this->Document->find('first', array(
  		 		'conditions' => array('Document.id' => $id),
  		  		'recursive' => -1,)
  			);
  		}
  		
  		// if there are more documents, shuffle them
  		if(count($docs) > $doc_pack) {
  			shuffle($docs);
  			$docs_ids = array_rand($docs, $doc_pack);
  			$docs_ids_array = (is_array($docs_ids) ? $docs_ids : array($docs_ids));
  			$docs = array_intersect_key($docs, array_flip($docs_ids_array));
  		}
  		
  		$this->set(compact('docs', 'doc_pack'));
  		$this->_clean_session();  			
  	}
  }
  
  /**
   * 
   *  @deprecated
   */
  public function get($criterio = null) {
  	if(!$this->Session->check('Desafio.docs') and is_null($criterio)) {
  		$this->Session->setFlash(
  		'Ganaste la posibilidad de descargar documentos, haz una búsqueda para poder acceder a ellos!');
  		$this->redirect(array('controller' => 'tags'));
  	} else if(!is_null($criterio)) {
  		$docs = $this->Tag->findDocumentsByTags(array($criterio));
  	} else {
  		$docs = $this->Session->read('Desafio.docs');
  	}
  
  	$this->Session->delete('Desafio');
  	$criterio = $this->Criterio->find('first', array('recursive' => -1));
  	$pack = $criterio['Criterio']['tamano_pack'];
  
  	$doc_objs = $this->Documento->find('all', array(
  	  'conditions' => array(
  		'Documento.id_documento' => $docs
  	),
  	  'recursive' => -1,
  	));
  	$premio = array();
  	if(count($doc_objs) > 0) {
  		if(count($doc_objs) < $pack)
  		$pack = count($doc_objs);
  
  		/* shuffle documents */
  		shuffle($doc_objs);
  		$tmp = array_rand($doc_objs, $pack);
  		$tmp = (is_array($tmp) ? $tmp : array($tmp));
  		/* insersect by keys from documents and some random subset of size $pack of $doc_objs */
  		/* $premio are $pack random documents from search result */
  		$premio = array_intersect_key(
  		$doc_objs,
  		array_flip($tmp)
  		);
  	}
  	$this->set(compact('premio', 'doc_objs'));
  }
  
  function save(&$data){
  	
  	$repo = $this->requireRepository();
  	$user = $this->getConnectedUser();
  	 
  	$this->data['Document']['repository_id'] = $repo['Repository']['id'];
  	$this->data['Document']['user_id'] = $user['User']['id'];
  	$this->data['Document']['kit_id'] = $repo['Repository']['kit_id'];
  	$this->Document->set($this->data);
  	 
  	// errors
  	if(empty($this->data['Document']['tags'])) {
  		$this->Session->setFlash('You must include at least one tag');
  	} else if(!$this->Document->validates()) {
  		$errors = $this->Document->invalidFields();
  		$this->Session->setFlash($errors, 'flash_errors');
  	} else if(!$this->Document->saveWithTags($this->data)) {
  		$this->Session->setFlash('There was an error trying to save the document. Please try again later');
  	} else {
  		$this->Session->setFlash('Document saved successfuly');
  		$this->_clean_session();
  		$this->redirect(array('controller' => 'repositories', 'action' => 'index', $repo['Repository']['url']));
  	}
  }
  
  
}
?>