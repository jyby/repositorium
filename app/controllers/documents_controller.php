<?php
class DocumentsController extends AppController {

	var $name = 'Documents';
	var $uses = array('Document', 'User', 'Repository', 'Folio');
	
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
  	
  	// File Repos vars
  	$fileTypeOK = false;
  	$savedFile = false;
  	$folder = "";
  	
  	
  	if(!empty($this->data)) {  	
	  	$user = $this->getConnectedUser();
	  	
	  	$this->data['Document']['repository_id'] = $repo['Repository']['id']; 
	  	$this->data['Document']['user_id'] = $user['User']['id'];
	  	$this->Document->set($this->data);
	  	
	  	// if file exists, save it into directory
	  	if(!empty($this->data['Document']['file'])) {
	  		
	  		$folder = "docfiles/";
	  		$folder_path = WWW_ROOT.$folder;
	  		
	  		if(!is_dir($folder_path)) {
	  			mkdir($folder_path);
	  		}
	  		
	  		if(is_uploaded_file($this->data['Document']['file']['tmp_name'])){
	  			$permitted = array('application/pdf','application/msword');
	  			// check filetype is ok
	  			foreach($permitted as $type) {
	  				if($type == $this->data['Document']['file']['type']) {
	  					$fileTypeOK = true;
	  					$savedFile = move_uploaded_file($this->data['Document']['file']['tmp_name'],
	  						$folder_path . $this->data['Document']['file']['name']);
	  					break;
	  				}
	  			}
	  			if(!$fileTypeOK)
	  				$this->Session->setFlash('File type not allowed');	
	  		}
	  	}
	  	
	  	// errors
	  	if(!empty($this->data['Document']['file']) and !$fileTypeOK){
	  		$this->Session->setFlash('File type not allowed');
	  	}
	  	if(empty($this->data['Document']['tags'])) {
	  		$this->Session->setFlash('You must include at least one tag');
	  	} else if(!$this->Document->validates()) {
			$errors = $this->Document->invalidFields();
			$this->Session->setFlash($errors, 'flash_errors');
		} else if(!$this->Document->saveWithTags($this->data)) {
			$this->Session->setFlash('There was an error trying to save the document. Please try again later');
		} else {
			// now that Document is saved, let's add File register
			if($fileTypeOK and $savedFile){
				$folio['filename'] = $this->data['Document']['file']['name'];
				$folio['size'] = $this->data['Document']['file']['size'];
				$folio['document_id'] = $this->Document->id;
				$folio['type'] = 'pdf';
				$folio['path'] = $folder;
				$this->Folio->set($folio);
				$this->Folio->save();
			}
			
			$this->Session->setFlash('Document saved successfuly');
			$this->_clean_session();
			$this->redirect(array('controller' => 'repositories', 'action' => 'index', $repo['Repository']['url']));
		}
		
  	}
  	
  	$source = $this->Repository->getSourceType($repo['Repository']['source_id']);
	$this->set(compact('source'));
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
  
  
}
?>