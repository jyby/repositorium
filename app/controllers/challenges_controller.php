<?php
/**
 * One of the most important classes
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
  
  /**
   * 
   * @see ChallengesController::play()
   */
  function index() {
  	$this->redirect('play');	 	
  }
  
  /**
   * 
   * prepares challenge and displays view to solve it
   * requires Session var "Challenge.play" given by PointsController::process()
   * @see PointsController::process()
   */
  function play() {
  	if(!$this->Session->check('Challenge.play')) {  		
  		$this->Session->setFlash('In order of play a challenge, please choose an action (search, upload or earn points)');  		
  		$this->redirect('/');
  	} 	
  	
  	$this->Session->delete('Challenge');
  	
  	$user = $this->getConnectedUser();
  	$repo = $this->getCurrentRepository();
  	
  	if(is_null($repo)) {
  		$this->Session->setFlash('You must be in a repository', 'flash_errors');
  		$this->redirect('/');
  	}
  	
  	$repo_id = $repo['Repository']['id'];
  	
  	$criterio = $this->Criteria->getRandomCriteria($repo_id);
  	
  	if(is_null($criterio))
  		$this->_skip_challenge();
  	
  	$documentos = $this->Criteria->generateChallenge($user['User']['id'], $criterio, $repo_id);
  	
  	if(count($documentos) == 0)
  		$this->_skip_challenge();
  	
  	$this->Session->write('Challenge.criterio', $documentos[0]['CriteriasDocument']['criteria_id']);
  	$this->Session->write('Challenge.validate', true);
  	
  	$this->set(compact('documentos', 'criterio'));
  }
  
  /**
   * exceptional case when there aren't enough
   * criterias or documents to play a challenge
   * 
   * had to rewrite dispatch logic here :(
   * 
   */
  function _skip_challenge() {
  	$this->Session->delete('Challenge.play');
  	$this->Session->write('Document.continue', true);
  	
  	$action = $this->Session->read('Action.type');
  	$earn = strcmp($action, 'earn') == 0;
  	$download = strcmp($action, 'download') == 0;
  	$upload = strcmp($action, 'upload') == 0;
  	
  	if($earn) {
  		$this->Session->setFlash('Sorry, there aren\'t enough documents or criterias to play a challenge');
  		$this->redirect('/');
  	} elseif($download || $upload) {
  		$this->redirect(array(
  			'controller' => 'documents',
  			'action' => $this->Session->read('Action.type')
  		));
  	} else {
  		$this->redirect('/');	
  	}  	
  }
  
  /**
   * 
   * wrapper for _validate_challenge
   */
  function validate_challenge() {
  	if(empty($this->data) || !$this->Session->check('Challenge.validate'))
  		$this->e404();
  	
  	$this->Session->delete('Challenge.validate');
  	$this->Session->delete('Challenge.play');
  	
  	$this->_validate_challenge($this->data);
  	
  }
  
  /**
   * validates challenge and dispatch to PointsController::process()
   * if unsuccessful, increases user's amount of questions and show failure
   * requires Session var "Challenge.validate" given by play()
   * @see PointsController::process()
   * @see ChallengesController::_dispatch()
   */
  function _validate_challenge($data) {	
  	$user = $this->getConnectedUser();
  	$criterio = $this->Session->read('Challenge.criterio');
  	$desafio_correcto = $this->CriteriasDocument->validateChallenge($data['Desafio']);
  	$this->CriteriasDocument->saveStatistics($data['Desafio'], $desafio_correcto);
  	$this->CriteriasUser->saveNextC($user['User']['id'], $criterio, $desafio_correcto);
  	 
  	$this->_dispatch($desafio_correcto);
  }
  
  function _dispatch($challenge_successful = false) {
  	if($challenge_successful) {
  		$this->_process_points();  		
  	} else {
  		$this->redirect('failure');
  	}
  }
  
  /**
   * for retry challenge
   */
  function failure() {
  	$this->Session->delete('Challenge');
  }
  
  /**
   * redirects to PointsController::process()
   */
  function _process_points() {
  	$this->Session->write('Points.process', true);
  	
  	$this->redirect( array(
  	  	'controller' => 'points',
  	  	'action' => 'process'
  		)
  	);
  }
  
}
?>