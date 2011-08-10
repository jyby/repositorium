<?php
/**
 * Teh most important class
 *
 * 
 * the cake is a lie
 *
 * @author mquezada
 *  
 */
class ChallengesController extends AppController {
  var $uses = array('User', 'Document', 'CriteriasUser', 'CriteriasDocument', 'Criteria', 'RepositoriesUser');

  /**
   * play the game
   */
  function index() {	
	$user = $this->getConnectedUser();
	$criterio = $this->Criteria->getRandomCriteria();
	
	if(is_null($criterio))
		$this->_skip();
	
	$documentos = $this->Criteria->generateChallenge($user['User']['id'], $criterio);
	
	if(count($documentos) == 0) 
		$this->_skip();
	
	$this->Session->write('Challenge.criterio', $documentos[0]['CriteriasDocument']['criteria_id']);
	$this->set(compact('documentos', 'criterio'));	
  }

  /**
   * check how good it was
   */
  function validate_challenge() {
  	if(empty($this->data))
  		$this->e404();
  	
  	$user = $this->getConnectedUser();
  	$criterio = $this->Session->read('Challenge.criterio');
  	
  	$desafio_correcto = $this->CriteriasDocument->validateChallenge($this->data['Desafio']);
	$this->CriteriasDocument->saveStatistics($this->data, $desafio_correcto);
  	$this->CriteriasUser->saveNextC($user['User']['id'], $criterio, $desafio_correcto);
  	
  	$this->_dispatch();  	
  }
  
  /**
   * skip challenge (no points discount)
   */
  function _skip() {
  	$this->Session->write('Challenge.passed', true);
  	$this->_dispatch();
  }
  
  /**
   * 
   * skip challenge (points discount)
   */
  function skip() {
  	$repository_id = 1;
  	$user = $this->getConnectedUser();
  	$go_to = $this->Session->read('Document.goto');
  	
  	
  }
  
  /**
   * 
   * dispatch
   */
  function _dispatch() {
  	$go_to = $this->Session->read('Desafio.goto');
  	
  	if(strcmp($go_to,'earn') == 0 ) {
  		$this->Session->setFlash('Task finished / Points earned (if any)');
  		$this->redirect('/');
  	}
  	
  	$this->redirect(array('controller' => 'documents', 'action' => $go_to));
  }
 
}
?>