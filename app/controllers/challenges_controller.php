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
   * User Model
   * @var User
   */
  var $User;
  
  /**
  * CriteriasUser Model
  * @var CriteriasUser
  */
  var $CriteriasUser;
  
  /**
  * CriteriasDocument Model
  * @var Criteriasdocument
  */
  var $CriteriasDocument;
  
  /**
  * Criteria Model
  * @var Criteria
  */
  var $Criteria;
  
  /**
  * RepositoriesUser Model
  * @var RepositoriesUser
  */
  var $RepositoriesUser;
  
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
  	if(!$this->Session->check('Document.action') && !$this->Session->check('Points.earn')) {
  		$this->Session->setFlash('In order of play a challenge, please choose an action (search, upload or earn points)');
  		$this->redirect('/');
  	}
  }
  
  /**
   * play the game
   */
  function index() {	
	$user = $this->getConnectedUser();
	$repo = $this->getCurrentRepository();
	
	if(is_null($repo)) {
		$this->Session->setFlash('You must be in a repository', 'flash_errors');
		$this->redirect('/');		
	}
	
	$repo_id = $repo['Repository']['id'];
	
	$criterio = $this->Criteria->getRandomCriteria($repo_id);
	
	if(is_null($criterio))
		$this->_skip($goto_points = false);
	
	$documentos = $this->Criteria->generateChallenge($user['User']['id'], $criterio, $repo_id);
	
	if(count($documentos) == 0) 
		$this->_skip($goto_points = false);
	
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
  	
  	$this->_dispatch($goto_points = true, $desafio_correcto);  	
  }
  
  /**
   * skip challenge (no points discount)
   */
  function _skip($goto_points = true) {
  	$this->Session->write('Challenge.passed', true);
  	$this->_dispatch($goto_points);
  }
  
  /**
   * 
   * skip challenge (points discount)
   */
  function skip() {
  	$this->redirect(array('controller' => 'points', 'action' => 'check'));
  }
  
  /**
   * 
   * dispatch
   */
  function _dispatch($goto_points = true, $challenge_passed = false) {
  	if($goto_points) {
  		if($challenge_passed) {
  			$this->Session->write('Challenge.passed', true);
  			$this->Session->write('Challenge.reward', true);
  			$this->redirect(array('controller' => 'points', 'action' => 'reward'));
  		} else {
  			// this doesn't mean to happen
  			$this->redirect('/');
  		}
  	} else {
  		if($this->Session->check('Document.action')) {
  			$action = $this->Session->read('Document.action');
  			$this->redirect(array('controller' => 'documents', 'action' => $action));
  		} elseif($this->Session->check('Challenge.earn')) {
  			// earn points action
  			$this->Session->setFlash('Sorry, there aren\'t enough documents or criteria to perform a challenge');
  			$this->redirect('/');
  		}
  	}  	
  }
 
}
?>