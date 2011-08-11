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
				$repository = $this->Repository->createNewRepository($this->data, $user);
				$this->redirect(array('controller' => 'repositories', 'action' => 'set_repositories', $repository['Repository']['id']));		
			} else {
				$this->Session->setFlash($this->Repository->invalidFields(), 'flash_errors');
			}	
		}		
	}
	
	function set_repository($id) {
		if(!is_null($id) && gettype($id) == 'integer')
			$this->Session->write('Repository.id', $id);
		
		
		$this->redirect('/');
	}
}