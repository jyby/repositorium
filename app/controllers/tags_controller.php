<?php
/**
 * tags_controller.php
 * 
 * tag manager
 * 
 * @package   controller
 * @author    Mauricio Quezada <amantedelacomida56@aol.com>
 * @copyright Copyright (c) 2011 
 */

class TagsController extends AppController {

	var $helpers = array('Js' => array('Jquery'));
	var $uses = array('Criteria', 'Tag', 'Document', 'Attachfile', 'ConstituentsKit');
	
	/**
	 * Criteria Model
	 * @var Criteria
	 */
	var $Criteria;
	
  function index() {
	$repo = $this->requireRepository();
	$criterias = $this->Criteria->find('all', array(
		'conditions' => array(
			'Criteria.repository_id' => $repo['Repository']['id']
			),
		'recursive' => -1,
		'fields' => array('id', 'question'),
		)
	);
	
	$constituents = $this->ConstituentsKit->find('list', array(
					'conditions' => array('ConstituentsKit.kit_id' => $repo['Repository']['kit_id'], 'ConstituentsKit.constituent_id' != '0'), 
					'recursive' => 1,
					'fields'=>array('Constituent.sysname')));
	
	$this->set(compact('criterias','constituents'));	
  }
  

  //función auxiliar hecha para evitar elementos repetidos dentro del arreglo (emular un conjunto)
  function addContent($conjunto_base, $nuevo_conjunto){
	foreach ($nuevo_conjunto as $elemento) {
		if(!in_array($elemento,$conjunto_base)){
			$conjunto_base[] = $elemento;
		}
	}
	return($conjunto_base);
  }

  function process() {
	if (empty($this->data) or trim($this->data['Tag']['search']) == '') {
		$this->Session->setFlash('Please, enter a search term');
		$this->redirect(array('controller' => 'tags', 'action' => 'index'));
	}
	if (empty($this->data['Option']['id']) or count($this->data['Option']['id']) == 0) {
		$this->Session->setFlash('Please select a search option');
		$this->redirect(array('controller' => 'tags', 'action' => 'index'));
	}
	
	$repo = $this->requireRepository();
	
	$words = explode(',', trim($this->data['Tag']['search'])); //fix: el separador es coma, no espacio
	
	$documents = array();

	if(in_array("title",$this->data['Option']['id'])){
		$documents_aux = $this->Document->findDocumentsByTitle($repo['Repository']['id'], $words);
		$documents = $this->addContent($documents,$documents_aux); //agregar documentos al conjunto
	}
	if(in_array("content",$this->data['Option']['id'])){
		$documents_aux = $this->Document->findDocumentsByContent($repo['Repository']['id'], $words);
		$documents = $this->addContent($documents,$documents_aux); //agregar documentos al conjunto
	}
	if(in_array("filename",$this->data['Option']['id'])){
		$documents_aux = $this->Attachfile->findDocumentsByFilename($repo['Repository']['id'], $words);
		$documents = $this->addContent($documents,$documents_aux); //agregar documentos al conjunto
	}
	if(in_array("tags",$this->data['Option']['id'])){
		$documents_aux = $this->Tag->findDocumentsByTags($repo['Repository']['id'], $words);
		$documents = $this->addContent($documents,$documents_aux); //agregar documentos al conjunto
	}
	
	$documents = $this->Criteria->filterDocuments($documents, $this->data['Criteria']['id']);
	
	$c = count($documents);	
	if($c > 0) {
	  $this->Session->write('Search.document_ids', $documents);
	  $this->Session->write('Search.count', count($documents));
	  $msg = 
		'There ' . 
		($c>1 ? ' are ' : ' is ') . 
		$c .' document'  . 
		($c>1 ? 's ' : ' ') .
		'that satisf' . 
		($c>1 ? 'y ' : 'ies ') . 
		'that term. ';
	  $this->Session->setFlash($msg);
	  $this->redirect(array('controller' => 'documents', 'action' => 'download'));	  
	} else {
		
	  $this->Session->setFlash(
		'We\'re sorry. There weren\'t any documents that satisfy that term(s)'
	  );
	  $this->redirect(array('controller' => 'tags', 'action' => 'index'));
	}
	
  }
  
  function autocomplete() {
  	$repo = $this->requireRepository();
  	$repo_id = $repo['Repository']['id'];
  	  	
  	$search = null;
  	if(isset($this->params['url']['search']) && !is_null($this->params['url']['search']))
  		$search = $this->params['url']['search'];
  	else exit;
  	$this->data = $this->Tag->find('all', array(
		'conditions' => array(
			'Tag.tag LIKE' => "%{$search}%",
			'Document.repository_id' => $repo_id
  		),
  		'fields' => array(
  			'DISTINCT Tag.tag'
  		)
  	));
  	$this->render('/elements/tags_autocomplete','ajax');  	
  }
}
?>
