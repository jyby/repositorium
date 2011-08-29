<?php
/**
 * 
 * Checks and updates user points
 * @author mquezada
 *
 */
class PointsController extends AppController {
	var $name = 'Points';
	var $uses = array('RepositoriesUser', 'Criteria');
	
	var $earn = 1;
	var $upload = 2;
	var $download = 3;
	
	/**
	 * RepositoriesUser Model
	 * @var RepositoriesUser
	 */
	var $RepositoriesUser;
	
	/**
	 * Criteria Model
	 * @var Criteria
	 */
	var $Criteria;
	
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	function index() {
		$this->redirect('/');
	}
	
	/**
	 * One of the possible actions
	 * @see DocumentsController::upload()
	 * @see DocumentsController::download()
	 */
	function earn() {
		$this->Session->write("Action.type", 'earn');
		$this->redirect('process');
	}
	
	function _get_action() {
		$action = $this->Session->read('Action.type');
		
		$upload   = strcmp($action, 'upload')   == 0;
		$download = strcmp($action, 'download') == 0;
		$earn     = strcmp($action, 'earn')     == 0;
		
		if($earn) return $this->earn;
		if($upload) return $this->upload;
		if($download) return $this->download;
		else return -1;
	}
	
	/**
	 * check if user points are enough to action required
	 * or anon user who doesnt require any points
	 * - upload
	 * - download
	 * - earn (does not require any points)
	 * 
	 * redirects if unexpected behavior
	 * 
	 * @return true if user needs a challenge, false otherwise	 
	 */
	function _check_if_challenge() {
		$action = $this->Session->read('Action.type');
		$repo = $this->getCurrentRepository();		
		$user = $this->getConnectedUser();
		
		/*
		 * anon doesnt need points check
		 * always need a challenge
		 */
		if($user == $this->anonymous)
			return true;
		
		$upload   = strcmp($action, 'upload')   == 0;
		$download = strcmp($action, 'download') == 0;
		$earn     = strcmp($action, 'earn')     == 0;
		
		if($earn) {
			/*
			 * earn points:
			 * go to challenge
			 */			
			return true;
		} else {
			/*
			 * download or upload:
			 * check points
			 */
			if($download) {
				if($this->Session->check('Search.count')) {
					$count = $this->Session->read('Search.count');
					// determine $cost
					$cost = $repo['Repository']['download_cost'] * $count;
				} else {
					$this->_cancel_everything('Please, first perform a search to download documents');
				}
			} elseif($upload) {
				// determine $cost
				$cost = $repo['Repository']['upload_cost'];
			} else {
				// ERROR invalid action
				$this->_cancel_everything('Action not recognized');
			}
			// check $cost against user points
			
			$user_points = $this->RepositoriesUser->find('first', array(
				'conditions' => array(
					'RepositoriesUser.repository_id' => $repo['Repository']['id'],
					'RepositoriesUser.user_id' => $user['User']['id']
				),
				'fields' => array('points'),
				'recursive' => -1
			));
			$user_points = $user_points['RepositoriesUser']['points'];
			
			//if user points > cost, doesnt need a challenge
			if($user_points >= $cost) {
				return false;
			} else {
				return true;
			}
		}
	}
	
	/**
	 * checks user points
	 * Discounts or adds points to user depending of his action
	 * then dispatch
	 * requires Session var "Points.process" given by ChallengesController::validate_challenge()
	 * @see ChallengesController::validate_challenge()
	 */
	function process() {
		$this->Session->delete('Challenge.play');
		/* 
		 * "Action.type" must be set
		 */
		if(!$this->Session->check('Action.type')) {
			$this->Session->setFlash("Please, choose an action to perform: download, upload documents or earn points");
			$this->redirect('/');
		}
		
		$action = $this->Session->read('Action.type');
		$user = $this->getConnectedUser();
		
		$upload   = strcmp($action, 'upload')   == 0;
		$download = strcmp($action, 'download') == 0;
		$earn     = strcmp($action, 'earn')     == 0;
		
		/*
		 * If "Points.process" is not set, then a challenge has not been done.
		 * So, user needs its points checked OR just want to earn points
		 */ 
		if(!$this->Session->check('Points.process')) {
			$user_needs_a_challenge = $this->_check_if_challenge();
			
			if($user_needs_a_challenge) {
				$this->_go_to_challenge();
									
			} elseif(!$this->_wants_to_spend()) {				
				$this->_ask_to_spend();
			}						
		}		
		/*
		* user comes from ChallengesController::validate_challenge()
		*/
		else {
			$this->Session->delete('Points.process');
			
			/*
			 * give points to user for passing the challenge
			 */
			$criteria = $this->Session->read('Challenge.criterio');			
			$this->_reward($criteria);
			
			/*
			 * check points again *if the action is not 'earn'*
			 * and if user isn't anonymous
			 */
			if(!$earn && $user != $this->anonymous) {
				$user_needs_a_challenge_again = $this->_check_if_challenge();
							
				if($user_needs_a_challenge_again) {			
					$this->Session->setFlash('Sorry, passing this challenge didn\'t give you enough points for the action you requested.' 
						.'The points have been given to you anyway ;)');
					$this->_go_to_challenge();	
				}
			}
			
			/*
			 * discount points from user depending his action
			 */
			$this->_pay();
			
			/*
			 * now take the user to his final objective
			 */
			$this->Session->write('Points.dispatch', true);
			$this->_dispatch();			
		}		
	}
	
	/**
	 * redirects to challenge
	 */
	function _go_to_challenge() {
		$this->Session->write('Challenge.play', true);
		$this->redirect( array(
			'controller' => 'challenges',
			'action' => 'play')				
		);
	}
	
	/**
	 * 
	 * gives spend credential
	 */
	function _ask_to_spend() {
		$this->Session->write('Points.spend', false);
		$this->redirect('spend');
	}
	
	/**
	 * tells if user wants to spend points
	 */
	function _wants_to_spend() {
		return $this->Session->check('Points.spend') && $this->Session->read('Points.spend');
	}
	
	/**
	 * 
	 * page which gives the option to spend points and skip a challenge
	 */
	function spend() {
		if(!empty($this->data)) {
			if($this->data['Point']['spend']) {
				$this->Session->write('Points.spend', true);
				$this->Session->write('Points.process', true);
				$this->redirect('process');
			}
		}		
	}
	
	/**
	 * 
	 * give user points
	 * anon doesn't earn points
	 */
	function _reward($criteria_id) {
		$user = $this->getConnectedUser();
		
		if($user == $this->anonymous)
			return;
		
		if($this->_wants_to_spend())
			return;
		
		$repo = $this->getCurrentRepository();
		$criteria = $this->Criteria->read(null, $criteria_id);
		if(!$criteria) {
			$this->_cancel_everything('Criteria not found');
		}
		$reward = $criteria['Criteria']['challenge_reward'];
			
		if($this->RepositoriesUser->addPoints($user['User']['id'], $repo['Repository']['id'], $reward))	{	
			$this->Session->write('Points.status', "Congratulations! you have won {$reward} points");
		} else {
			$this->Session->write("Points.status", "An error occurred adding points. Please blame to the administrator or the developer");
			$this->Session->write("Points.proceed", false);
		}
	}
	
	/**
	 * discount user points
	 * anon doesn't need this
	 * neither if action == 'earn'
	 */
	function _pay() {
		if($this->Session->check('Points.proceed') && !$this->Session->read('Points.proceed')) {
			$this->_cancel_everything($this->Session->read('Points.status'));
		}
		
		$user = $this->getConnectedUser();		
		
		if($user == $this->anonymous) 
			return;
		
		if($this->_get_action() == $this->earn)
			return;
		
		$repo = $this->getCurrentRepository();
		$action = $this->_get_action();
		
		if($action == $this->upload) {
			$cost = $repo['Repository']['upload_cost'];
		}
		
		else if($action == $this->download) {
			if(!$this->Session->check('Search.count')) {
				$this->_cancel_everything('Document search results not found');
			}			
			
			$count = $this->Session->read('Search.count');
			$cost = $repo['Repository']['download_cost'] * $count;
		}
		
		else { 
			$this->_cancel_everything('Action not recognized');
		}
				
		if($this->RepositoriesUser->discountPoints($user['User']['id'], $repo['Repository']['id'], $cost)) {
			$this->Session->write("Points.status", "Spent {$cost} points");
		} else {
			$this->Session->write("Points.status", "An error occurred subtracting points. Please blame to the administrator or the developer");
			$this->Session->write("Points.proceed", false);
		}
	}
	
	/**
	 * dispatch to user action:
	 * - upload
	 * - download
	 * - index (for earn points)
	 * requires Session var "Points.dispatch" given by PointsController::process()
	 * @see PointsController::process()
	 */
	function _dispatch() {
		$action = $this->_get_action();
		$action_name = $this->Session->read('Action.type');
		
		if(!$this->Session->check('Points.dispatch')) {
			$this->_cancel_everything('This is not meant to happen');
		}
		
		if($this->Session->check('Points.proceed') && !$this->Session->read('Points.proceed')) {
			$this->_cancel_everything($this->Session->read('Points.status'));
		}
		
		if($this->getConnectedUser() == $this->anonymous)
			$this->Session->setFlash("Thank you, now you can {$action_name} document(s)");
		else
			$this->Session->setFlash($this->Session->read('Points.status'));
				
		if($action == $this->earn) {
			$this->redirect('/');
		}
		
		if($action == $this->upload || $action == $this->download) {
			$this->Session->write('Document.continue', true);
			$this->_clean_session();
			$this->redirect(array(
				'controller' => 'documents',
				'action' => $action_name
				)
			);
		}
				
		else { 
			$this->_cancel_everything('Action not recognized');
		}
				
	}
	
	/**
	 * cleans session variables
	 */
	function _clean_session() {
		$this->Session->delete('Points');
	}
	
	/**
	 * 
	 * in case something goes wrong
	 */
	function _cancel_everything($reason) {
		$this->Session->setFlash("Sorry, an unexpected error has occurred [Message: {$reason}]", 'flash_errors');
		$this->_clean_session();
		$this->redirect('/');
	}
	
	
}