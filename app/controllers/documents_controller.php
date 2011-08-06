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
  
}
?>