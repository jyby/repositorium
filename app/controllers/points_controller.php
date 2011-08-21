<?php
/**
 * 
 * Checks and updates user points
 * @author mquezada
 *
 */
class PointsController extends AppController {
	var $name = 'Points';
	var $uses = array('RepositoriesUser');
	
	/**
	 * RepositoriesUser Model
	 * @var RepositoriesUser
	 */
	var $RepositoriesUser;
	
	/**
	 * 
	 * redirects user to challenges
	 */
	function earn() {
		$this->Session->write('Challenge.earn', 'earn');
		$this->_goto_challenge();
	}
	
	/**
	 * 
	 * checks if user has enough points
	 * if he does, dispatch
	 * otherwise => challenge
	 * 
	 */
	function check() {
		// if this is not set, then neither is $action
		if($this->Session->check('Points.check')) {	
			// check for current repository
			$repo = $this->getCurrentRepository();
			if(is_null($repo)) {
				$this->Session->setFlash('You must be in a repository', 'flash_errors');
				$this->redirect('/');
			}
			
			// check if there is an action registered
			if($this->Session->check('Document.action')) {				
				// if is the anon user, redirect him to challenge			
				if($this->getConnectedUser() == $this->anonymous) {
					$this->Session->write('Document.anonymous', true);
					$this->_goto_challenge();
				}
				
				$action = $this->Session->read('Document.action');
				
				$upload = strcmp($action, 'upload') == 0;
				$download = strcmp($action, 'download') == 0;
				
				// determine repository costs
				if($upload) {
					$cost = $repo['Repository']['upload_cost'];
				} elseif($download) {
					if($this->Session->check('Document.searchCount')) {
						$cost = $repo['Repository']['download_cost'] * $this->Session->read('Document.searchCount');
					} else {
						$this->Session->setFlash('Please, first perform a search before downloading documents');
						$this->redirect('/');
					}
				}
				
				// get user points
				$user = $this->getConnectedUser();
				$user_points = $this->RepositoriesUser->find('first', array(
					'conditions' => array(
						'RepositoriesUser.repository_id' => $repo['Repository']['id'],
						'RepositoriesUser.user_id' => $user['User']['id'] 
						),
					'fields' => array('points'),
					'recursive' => -1
					));
				$user_points = $user_points['RepositoriesUser']['points'];
				
				// if user points > cost, give him the chance to spend his points
				if($user_points >= $cost) {
					$this->redirect('spend');
				// if not, just redirect to challenge
				} else {
					$this->_goto_challenge();
				}
			}			
		}
		$this->e404();
	}
	
	/**
	 * 
	 * wrapper for _discount
	 */
	function spend() {
		
	}
			
	/**
	 * 
	 * receives challenge result and add 
	 * points if successful 
	 * 
	 */
	function reward() {
		if($this->Session->check('Document.anonymous') && $this->Session->read('Document.anonymous')
			&& $this->Session->check('Challenge.reward') && $this->Session->check('Challenge.passed')
			&& $this->Session->read('Challenge.passed')) {
			
			$this->_dispatch();
		}
		
		if($this->Session->check('Challenge.reward') && $this->Session->check('Challenge.passed')
			&& $this->Session->read('Challenge.passed')) {
			
			$repo = $this->getCurrentRepository();
			$user = $this->getConnectedUser();
			if(is_null($repo)) {
				$this->Session->setFlash('Error identifying current repository', 'flash_errors');
				$this->redirect('/');
			}
			if($user == $this->anonymous) {
				$this->Session->setFlash('Anonymous user cannot win points, sorry :( (but if you sign in you could!)', 'flash_errors');
				$this->redirect('/');
			}
			
			$reward = $repo['Repository']['challenge_reward'];
			$this->RepositoriesUser->addPoints($user['User']['id'], $repo['Repository']['id'], $points = $reward);
			
			$this->Session->delete('Challenge.reward');
			$this->_dispatch($reward);
		}
	}
	
	/**
	 * 
	 * discount points from user (who usually wanted to skip the challenge)
	 */
	function _discount($cost, $action, $user) {
		$this->RepositoriesUser->discountPoints($user['User']['id'], $repo['Repository']['id'], $cost);
		
		$this->Session->write('Challenge.passed');
		$this->Session->setFlash("{$cost} points have been discounted from your account, now you can {$action} document(s)");
		$this->_dispatch();
	}
	
	function process() {
		if(!$this->Session->check('Points.process')) 
			$this->e404();
		
		
		
		$this->Session->delete('Points.process');
	}
		
	/**
	 * dispatch to desired action
	 * upload
	 * download
	 * index (earn points)
	 */
	function _dispatch($points = null) {
		if($this->Session->check('Challenge.earn')) {
			$this->Session->setFlash("Congratulations, you have earned {$points} points");
			$this->redirect('/');
		} else {
			$action = $this->Session->read('Document.action');
			if(!is_null($points)) 
				$this->Session->setFlash("Congratulations, you have earned {$points} points, now you can {$action} document(s)");
			$this->redirect(array('controller' => 'documents', 'action' => $action));
		}			
	}
	
	/**
	 * redirects to challenges controller
	 */
	function _goto_challenge() {
		$this->redirect(array('controller' => 'challenges'));		
	}
}