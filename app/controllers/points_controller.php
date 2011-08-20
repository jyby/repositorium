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
	 * @var RepositoriesUser
	 */
	var $RepositoriesUser;
	
	/**
	 * 
	 * redirects user to challenges
	 */
	function earn() {
		$this->Session->write('Challenge.action', 'earn');
		$this->redirect(array('controller' => 'challenges', 'action' => 'index'));
	}
	
	/**
	 * 
	 * checks if user has enough points
	 * if he does, dispatch
	 * otherwise => challenge
	 * 
	 */
	function check() {
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
				$this->redirect(array('controller' => 'challenges'));
			}
			
			$action = $this->Session->read('Document.action');
			
			$upload = strcmp($action, 'upload') == 1;
			$download = strcmp($action, 'download') == 1;
			
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
			
			// if user points > cost, give him the chance to spend his points
			if($user_points >= $cost) {
				$this->RepositoriesUser->discountPoints($user['User']['id'], $repo['Repository']['id'], $cost);
				
				$this->Session->write('Challenge.passed');
				$this->Session->setFlash("{$cost} points have been discount from your account, now you can {$action} document(s)");
				$this->redirect(array('controller' => 'documents', 'action' => $action));
				
			// if not, just redirect to challenge
			} else {
				$this->redirect(array('controller' => 'challenges'));
			}
		}

		$this->e404();
	}
			
	/**
	 * 
	 * receives challenge result and add 
	 * points if successful 
	 * 
	 */
	function reward() {
		if($this->Session->check('Challenge.reward')) {
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
			$this->dispatch();
		}
	}
		
	/**
	 * 
	 * dispatch to desired action
	 * upload
	 * download
	 * index (earn points)
	 */
	function dispatch() {
		
	}
}