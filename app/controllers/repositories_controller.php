<?php

class RepositoriesController extends AppController {
	var $name = 'Repositories';
	
	function beforeFilter() { }
	
	function index($repo_url) {
		if(isset(Configure::read('Repository.current'))) {
			$data = $this->Repository->find('first', array('conditions' => array(
				'Repository.url' => Configure::read('Repository.current')
				)				
			));			
			$this->set(compact('data'));
		} elseif(!is_null($repo_url)) {
			$data = $this->Repository->find('first', array('conditions' => array(
				'Repository.url' => $repo_url
				)
			));
			
			if(!is_null($data) && !empty($data)) {
				Configure::write('Repository.current', $data['Repository']['url']);
				$this->set(compact('data'));
			} else {
				$this->e404();
			}
		} else {
			$this->e404();
		}
	}
	
	function create() {
		if($this->getConnectedUser() == $this->anonymous)
			$this->redirect(array('controller' => 'login'));
		
		if(!empty($this->data)) {
			$user = $this->getConnectedUser();
			$this->Repository->set($this->data);
			
			if($this->Repository->validates()) {
				$repository = $this->Repository->createNewRepository($this->data, $user);
				
				$this->_set_repository($repo_data = array('repo_id' => $repository['Repository']['id']));				
			} else {
				$this->Session->setFlash($this->Repository->invalidFields(), 'flash_errors');
			}	
		}		
	}
	
	function _set_repository($repo_data = array()) {
		if(is_null($repo_data) || empty($repo_data))
			$this->e404();
		
		if(isset($repo_data['repo_id'])) {
			$c = array(
				'Repository.id' => $repo_data['repo_id']
			);
		} else {
			$c = array(
				'Repository.name' => $repo_data['repo_name']
			);
		}
		
		$repo = $this->Repository->find('first', array('conditions' => $c));
		
		if(!is_null($repo) && !empty($repo)) {
			Configure::write('Repository.current', $repo['Repository']['name']);
		}
		$this->redirect(array('controller' => 'repositories', 'action' => 'view', $repo['Repository']['name']));
	}
}