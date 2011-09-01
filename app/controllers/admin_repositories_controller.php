<?php
/**
 * 
 * Repositories Administration
 * @author mquezada
 *
 */

class AdminRepositoriesController extends AppController {
	var $name = 'AdminRepositories';
	var $uses = array('Repository');
	var $paginate = array(
		'Repository' => array(
		  'limit' => 5,
		  'order' => array('Repository.created' => 'desc')
		)
	);
	
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	/**
	 * 
	 * Repository Model
	 * @var Repository
	 */
	var $Repository;
	
	var $helpers = array('Text', 'Repo');
	
	function beforeFilter() {
		if(!$this->isAdmin()) {
			$this->Session->setFlash('You don\'t have permission to access this page');
			$this->redirect('/');
		}		
	}
	
	function index() {
		$current = 'repositories';
		$this->data = $this->paginate();
		
		$this->set(compact('current'));
	}
	
	function edit($id = null) {
		if(empty($this->data)) {
			if(is_null($id)) 
				$this->redirect('index');
			$repo = $this->Repository->read(null, $id);
			
			if(empty($repo))
				$this->e404();
			
			$this->data = $repo;
			$this->set('current', 'repositories');
		} else {
			$this->Repository->set($this->data);
			if(!$this->Repository->validates()) {
				$this->Session->setFlash($this->Repository->validationErrors, 'flash_errors');
			} elseif(!$this->Repository->save()) {
				$this->Session->setFlash('An error ocurred saving the repository. Please, blame the developer', 'flash_errors');
			} else {
				$this->Session->setFlash('Repository saved');
				CakeLog::write('activity', 'Repository [id='.$id.'] edited');
				$this->redirect('index');
			}
		}
	}
	
	function remove($id = null) {
		if(is_null($id))
			$this->e404();
		
		if($this->Repository->delete($id)) {
			$this->Session->setFlash('Repository deleted successfuly');
			CakeLog::write('activity', 'Repository [id='.$id.'] deleted');
		} else {
			$this->Session->setFlash('An error ocurred deleting the repository', 'flash_errors');
		}
		
		$this->redirect('index');
	}
}