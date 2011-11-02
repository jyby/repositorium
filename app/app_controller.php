<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
App::import('Sanitize');

class AppController extends Controller {
	
	// autocompletion
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	/**
	 * User Model
	 * @var User
	 */
	var $User;
	
	/**
	 * Repository Model
	 * @var Repository
	 */
	var $Repository;
	
	/**
	 * Expert Model
	 * @var Expert
	 */
	var $Expert;
	
	/**
	 * Anonymous user representation, use with AppController::getConnectedUser()
	 */
	var $anonymous = array(
		'User' => array('id' => 1, 'is_administrator' => 0)
	);
	
	var $uses = array('Expert', 'User', 'Repository');
	
	var $helpers = array('Repo', 'Session', 'Html', 'Form');
	
	function login($data = array()) {
		if(empty($data)) {
			return false;
		}
		
		$user = $this->User->getUser($data);
		
		if(!is_null($user)) {
			// clean session
			$this->Session->delete('User');
			$this->Session->delete('Document');
			$this->Session->delete('Points');
			$this->Session->delete('Challenge');
			
			$this->Session->write('User.id', $user['User']['id']);
			$this->Session->write('User.first_name', $user['User']['first_name']);
			$this->Session->write('User.last_name', $user['User']['last_name']);

			if($this->isAdmin()) {
				$this->Session->write('User.esAdmin', true);
			}
			
			if($this->Session->check('Repository.current')) {
				$repository = $this->getCurrentRepository();
				$name = $repository['Repository']['name'];
				$url = $repository['Repository']['url'];
				$this->Session->write('User.points', $this->User->get_user_points($user['User']['id'], $repository['Repository']['id']));
			}
			
			$this->Session->setFlash('Welcome, ' . $user['User']['first_name']);
			
			CakeLog::write('activity',
				'User '. $user['User']['email'] . ' (' .$user['User']['id'] . ') has logged in');
			return true;
		} else {
			$this->Session->setFlash('Incorrect user and/or password', 'flash_errors');
			return false;
		}
	}
	
	function setRepositorySession($repo) {
		if(!empty($repo)) {
			$this->Session->delete('Repository');
			$this->Session->write('Repository.current', $repo['Repository']['url']);
			$this->Session->write('Repository.name', $repo['Repository']['name']);
		}
		
		if($this->isExpert()) {
			$this->Session->write('User.esExperto', true);
		} else {
			$this->Session->write('User.esExperto', false);
		}
	}
 
	function e404() {
		$this->cakeError('error404');
	}
	
	function getConnectedUser() {
		if($this->Session->check('User.id'))
			$user_id = $this->Session->read('User.id');
		else
			return $this->anonymous;
		
		return $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'fields' => array('id', 'is_administrator'), 
			'recursive' => -1));
		
	}
	
	/**
	 * returns current repository data as array 
	 * note: if host is localhost, it just reads from the session var
	 * which means to have an expiration time
	 */
	function getCurrentRepository() {
		$repo = null;
		
		if(Configure::read('App.subdomains')) {
			$url = explode('.', $_SERVER['HTTP_HOST'], 3);
			if (count($url) === 2 OR $url[0] === 'www' ) {
				$repo = null;
			} else {
				$repo = $url[0];
			}
		} elseif($this->Session->check('Repository.current')) {
			$repo = $this->Session->read('Repository.current');
		}
		
		if(!is_null($repo)) {
			$data = $this->Repository->find('first', array('conditions' => array('Repository.url' => $repo)));
			if(!is_null($data) && !empty($data)) {
				return $data;
			}
		}			
		
		return null;
	}
	
	function isAdmin() {		
		$u = $this->getConnectedUser();
		if(isset($u['User']['is_administrator']))
			return $u['User']['is_administrator'];
		return false;
	}
	
	function requireRepository() {
		$repo = $this->getCurrentRepository();
		if(is_null($repo)) {
			$this->Session->setFlash("You must be in a repository", 'flash_errors');
			$this->redirect('/');
		}
		
		return $repo;
	}
	
	function isExpert() {
		$repo = $this->requireRepository();
		$user = $this->getConnectedUser();
		
		$expert = $this->Expert->find('first', array(
  			'conditions' => array(
  				'repository_id' => $repo['Repository']['id'],
  				'user_id' => $user['User']['id']
			),
		  	'recursive' => -1
		));
		
		if(empty($expert)) {
			return false;
		}
		
		return true;
	}
	
	function isAnonymous() {
		return $this->getConnectedUser() == $this->anonymous;
	}
	
	function isLoggedIn() {
		return $this->getConnectedUser() != $this->anonymous;
	}
}
