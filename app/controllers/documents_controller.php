<?php
class DocumentsController extends AppController {

	var $name = 'Documents';
	var $uses = array('Document', 'User');
	
	
	function beforeFilter() {
		if(!$this->isAdmin() || !$this->Session->check('Challenge.passed')) {
			$this->Session->write('Document.goto', $this->action);
			$this->Session->write('Points.check', true);
			
			$this->redirect(array('controller' => 'points', 'action' => 'check'));	
		}
	}
	
  function index() {
	$this->e404();
  }
  
  /**
   * 
   * @TODO points handling
   * @TODO dispatch handling
   */
  function upload() {
  	if(!empty($this->data)) {  	
	  	$user = $this->getConnectedUser();
	  	$this->data['Document']['user_id'] = $user['User']['id'];
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
			$this->redirect('/');
		} 	
  	}
  }

  
  /**
   * 
   * @TODO choose documents from search
   * @TODO choose criteria
   * @TODO points
   */
  function download() {
  	
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