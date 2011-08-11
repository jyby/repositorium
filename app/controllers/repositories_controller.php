<?php

class RepositoriesController extends AppController {
	var $name = 'Repositories';
	
	function beforeFilter() { }
	
	function index() {
		if($this->getConnectedUser() == $this->anonymous)
			$this->redirect(array('controller' => 'login'));
		$this->redirect('create');
	}
	
	function create() {
		if($this->getConnectedUser() == $this->anonymous)
			$this->redirect(array('controller' => 'login'));
		
		if(!empty($this->data)) {
			$user = $this->getConnectedUser();
			$this->Repository->set($this->data);
			
			if($this->Repository->validates()) {
				$repository = $this->Repository->createNewRepository($this->data, $user);
				
				$this->redirect(array('controller' => 'repositories', 'action' => 'view', $repository['Repository']['name']));
						
			} else {
				$this->Session->setFlash($this->Repository->invalidFields(), 'flash_errors');
			}	
		}		
	}
	
	function _set_repository($id) {
		if(!is_null($id) && gettype($id) == 'integer')
			$this->Session->write('Repository.id', $id);		
	}
	
	function view($repository) {
		if(is_null($repository))
			$this->e404();
		$repo = $this->Repository->findByName($repository);
		
		if(empty($repo))
			$this->e404();

		$this->_set_repository($repo['Repository']['id']);
	}
}