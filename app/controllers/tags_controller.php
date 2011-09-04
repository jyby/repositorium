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
	var $uses = array('Criteria', 'Tag');
	
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
	
	$this->set(compact('criterias'));	
  }

  function process() {
	if (empty($this->data) or trim($this->data['Tag']['search']) == '') {
		$this->Session->setFlash('Please, enter a search term');
		$this->redirect('index');
	}
	
	if(empty($this->data['Criteria']['id'])) {
		$this->Session->setFlash('Please, choose at least one quality criteria');
		$this->redirect('index');
	}
	$repo = $this->requireRepository();
	
// 	CakeLog::write('activity', 'User '. $this->Session->read('User.id') . ' has searched for: ['. $this->data['Tag']['search'] .']');
	
	$tags = explode(' ', trim($this->data['Tag']['search']));
	
	$documents = $this->Tag->findDocumentsByTags($repo['Repository']['id'], $tags);
	$documents = $this->Criteria->filterDocuments($documents, $this->data['Criteria']['id']);
	
	$c = count($documents);	
	if($c > 0) {
	  $this->Session->write('Documents.searched_docs', $documents);
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
	  $this->redirect('index');
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
