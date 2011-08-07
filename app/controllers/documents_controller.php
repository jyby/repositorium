<?php
class DocumentsController extends AppController {

	var $name = 'Documents';
	var $uses = array('Documento', 'Usuario');
	
	/**
	 * 
	 * Posible actions:
	 * 
	 * upload (a document)
	 * download (documents from search)
	 * list (own documents)
	 * 
	 * @param string $action
	 */
  function index($action = null) {
  	if(is_null($action) or !in_array($action, array('earn', 'upload', 'view')))
  		$this->e404();
  	
  	$this->Session->write('Document.goto', $action);  	  	
  }
  
  /**
   * 
   * @TODO points handling
   * @TODO dispatch handling
   */
  function upload() {
  	if(empty($this->data))
  		$this->e404(); 
  	
  	$user = $this->getConnectedUser();
  	
  	/*
  	 * document data
  	 */
  	$this->data['Document']['user_id'] = $user['User']['id'];
  	$this->Document->set($this->data);  	
  	
  	// errors
  	
  	if(empty($this->data['Document']['tags'])) {
  		$this->Session->setFlash('You must include at least one tag');
  		$this->redirect('index');
  	}
  		
	if(!$this->Document->validates()) {
		$this->Session->setFlash('There are some errors in the form');
		$this->redirect('index');
	}
		
	if(!$this->Document->saveWithTags($this->data)) {
		$this->Session->setFlash('There was an error trying to save the document. Please try again later');
		$this->redirect('index');
	}
	
	$this->Session->setFlash('Document saved successfuly');
	$this->redirect('/');
	
  } 	
  
}
?>