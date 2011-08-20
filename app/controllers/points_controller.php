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
		$repo = $this->getCurrentRepository();
		if(is_null($repo)) {
			$this->Session->setFlash('You must be in a repository', 'flash_errors');
			$this->redirect('/');
		}
		
		if($this->Session->check('Document.action')) {			
			if($this->getConnectedUser() == $this->anonymous) {
				$this->Session->write('Document.anonymous', true);
				$this->redirect(array('controller' => 'challenges'));
			}
			
			$action = $this->Session->read('Document.action');
			
			$upload = strcmp($action, 'upload') == 1;
			$download = strcmp($action, 'download') == 1;
			
			if($upload) {
				$cost = $repo['Repository']['upload_cost'];
			} elseif($download) {
				if($this->Session->check('Document.searchCount')) {
					$cost = $repo['Repository']['download_cost'] * $this->Session->read('Document.searchCount');
				} else {
					$this->Session->setFlash('Please, first perform a search to download documents');
					$this->redirect('/');
				}				
			}
			
			$user = $this->getConnectedUser();
			$user_points = $this->RepositoriesUser->find('first', array(
				'conditions' => array(
					'RepositoriesUser.repository_id' => $repo['Repository']['id'],
					'RepositoriesUser.user_id' => $user['User']['id'] 
					),
				'fields' => array('points'),
				'recursive' => -1
				));
			
			if($user_points >= $cost) {
				$this->RepositoriesUser->discountPoints($user['User']['id'], $repo['Repository']['id'], $cost);
				
				$this->Session->write('Challenge.passed');
				$this->Session->setFlash("{$cost} points have been discount from your account, now you can {$action} document(s)");
				$this->redirect(array('controller' => 'documents', 'action' => $action));
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