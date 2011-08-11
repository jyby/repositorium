<?php

class RepositoriesController extends AppController {
	var $name = 'Repositories';
	
	function beforeFilter() {
		if($this->getConnectedUser() == $this->anonymous)
			$this->redirect(array('controller' => 'login'));
	}
	
	function index() {
		$this->redirect('create');
	}
	
	function create() {
		if(!empty($this->data)) {
			$user = $this->getConnectedUser();
			$this->Repository->set($this->data);
			
			if($this->Repository->validates()) {
				$this->Repository->createNewRepository($this->data, $user);
				
				/*
				 * redirects to user's new repository 
				 */
				$this->redirect('/');		
			} else {
				$this->Session->setFlash($this->Repository->invalidFields(), 'flash_errors');
			}	
		}		
	}
}