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

	/**
	 * 
	 * Anonymous user representation, use with AppController::getConnectedUser()
	 * @var integer
	 */
	var $anonymous = 1;
	
	function login($data = array()) {
		App::import('Model','User');
		$User = new User;
		
		$data = Sanitize::clean($data);
		$usuario = $User->getUser($data);
		
		if( isset($usuario['User']['id']) ) {
			if(!empty($usuario['Expert']))
				$this->Session->write('User.esExperto', true);
			if(!empty($usuario['User']['is_administrator']))
				$this->Session->write('User.esAdmin', true);
			$this->Session->write('User.id', $usuario['User']['id']);
			$this->Session->write('User.first_name', $usuario['User']['first_name']);
			$this->Session->write('User.last_name', $usuario['User']['last_name']);
			$this->Session->setFlash('Welcome, ' . $usuario['User']['first_name']);
			CakeLog::write('activity',
				'User '. $usuario['User']['full_name'] . ' (' .$usuario['User']['id'] . ') has logged in');
			return true;
		} else {
			$this->Session->setFlash('Incorrect user and/or password', 'flash_errors');
			return false;
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
		
		return $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'recursive' => -1));
		
	}
}
